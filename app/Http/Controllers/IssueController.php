<?php

namespace App\Http\Controllers;

use App\Models\Issue;
use App\Models\IssueLabel;
use App\Models\IssueType;
use App\Models\Priority;
use App\Models\Project;
use App\Models\Status;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class IssueController extends Controller
{
    public function index(Request $request)
    {
        $perPage = max(10, min(100, (int) $request->input('per_page', 10)));
        $query = Issue::with(['project:id,name,project_key', 'issueType:id,name,color', 'status:id,name,color', 'assignee:id,username,display_name', 'priority:id,name,color']);
        if ($request->filled('project_id')) {
            $query->where('project_id', $request->project_id);
        }
        if ($request->filled('status_id')) {
            $query->where('status_id', $request->status_id);
        }
        if ($request->filled('q')) {
            $term = trim((string) $request->input('q'));
            $query->where(function ($q) use ($term) {
                $q->where('issue_key', 'like', "%{$term}%")
                    ->orWhere('summary', 'like', "%{$term}%")
                    ->orWhere('description', 'like', "%{$term}%");
            });
        }
        $issues = $query->latest('id')->paginate($perPage);
        $projects = Project::where('is_active', true)->orderBy('name')->get(['id', 'name']);
        $statuses = Status::orderBy('order_no')->get(['id', 'name']);
        return view('issues.index', compact('issues', 'projects', 'statuses'));
    }

    public function create(Request $request)
    {
        $projects = Project::where('is_active', true)->orderBy('name')->get();
        $issueTypes = IssueType::orderBy('name')->get();
        $priorities = Priority::orderBy('level')->get();
        $statuses = Status::orderBy('order_no')->get();
        $users = User::where('is_active', true)->orderBy('display_name')->get();
        $labels = IssueLabel::orderBy('name')->get();
        $parentIssues = [];
        if ($request->filled('project_id')) {
            $parentIssues = Issue::where('project_id', $request->project_id)->whereNull('parent_issue_id')->orderBy('issue_key')->get();
        }
        return view('issues.create', compact('projects', 'issueTypes', 'priorities', 'statuses', 'users', 'labels', 'parentIssues'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'project_id' => 'required|exists:projects,id',
            'issue_type_id' => 'required|exists:issue_types,id',
            'summary' => 'required|string|max:255',
            'description' => 'nullable|string',
            'priority_id' => 'nullable|exists:priorities,id',
            'status_id' => 'nullable|exists:statuses,id',
            'reporter_id' => 'nullable|exists:users,id',
            'assignee_id' => 'nullable|exists:users,id',
            'story_points' => 'nullable|numeric',
            'due_date' => 'nullable|date',
            'parent_issue_id' => 'nullable|exists:issues,id',
        ]);
        if (array_key_exists('description', $validated)) {
            $validated['description'] = $this->sanitizeIssueDescription($validated['description']);
        }
        $project = Project::findOrFail($validated['project_id']);
        $validated['reporter_id'] = $validated['reporter_id'] ?? auth()->id();
        $validated['issue_key'] = $this->generateIssueKey($project);
        $issue = Issue::create($validated);
        if ($request->filled('label_ids')) {
            $issue->labels()->sync($request->label_ids);
        }
        return redirect()->route('issues.show', $issue)->with('success', 'Issue created.');
    }

    public function show(Issue $issue)
    {
        $issue->load([
            'project',
            'issueType',
            'priority',
            'status',
            'reporter',
            'assignee',
            'parent',
            'labels',
            'comments.user',
            'attachments.uploader',
            'subtasks',
            'sprints',
            'watchers',
        ]);
        if (request()->filled('modal')) {
            return view('issues._show_modal', compact('issue'));
        }
        return view('issues.show', compact('issue'));
    }

    public function edit(Issue $issue)
    {
        $projects = Project::where('is_active', true)->orderBy('name')->get();
        $issueTypes = IssueType::orderBy('name')->get();
        $priorities = Priority::orderBy('level')->get();
        $statuses = Status::orderBy('order_no')->get();
        $users = User::where('is_active', true)->orderBy('display_name')->get();
        $labels = IssueLabel::orderBy('name')->get();
        $parentIssues = Issue::where('project_id', $issue->project_id)->whereNull('parent_issue_id')->where('id', '!=', $issue->id)->orderBy('issue_key')->get();
        return view('issues.edit', compact('issue', 'projects', 'issueTypes', 'priorities', 'statuses', 'users', 'labels', 'parentIssues'));
    }

    public function update(Request $request, Issue $issue)
    {
        $validated = $request->validate([
            'project_id' => 'required|exists:projects,id',
            'issue_type_id' => 'required|exists:issue_types,id',
            'summary' => 'required|string|max:255',
            'description' => 'nullable|string',
            'priority_id' => 'nullable|exists:priorities,id',
            'status_id' => 'nullable|exists:statuses,id',
            'reporter_id' => 'nullable|exists:users,id',
            'assignee_id' => 'nullable|exists:users,id',
            'story_points' => 'nullable|numeric',
            'due_date' => 'nullable|date',
            'parent_issue_id' => 'nullable|exists:issues,id',
        ]);
        if (array_key_exists('description', $validated)) {
            $validated['description'] = $this->sanitizeIssueDescription($validated['description']);
        }
        $issue->update($validated);
        if ($request->has('label_ids')) {
            $issue->labels()->sync($request->label_ids ?? []);
        }
        return redirect()->route('issues.show', $issue)->with('success', 'Issue updated.');
    }

    public function destroy(Issue $issue)
    {
        $issue->delete();
        return redirect()->route('issues.index')->with('success', 'Issue deleted.');
    }

    private function generateIssueKey(Project $project): string
    {
        $prefix = strtoupper(substr(preg_replace('/[^A-Z0-9]/', '', $project->project_key), 0, 4)) ?: 'PRJ';
        $last = Issue::where('project_id', $project->id)->orderBy('id', 'desc')->first();
        $num = $last ? (int) preg_replace('/\D/', '', $last->issue_key) + 1 : 1;
        return $prefix . '-' . $num;
    }

    private function sanitizeIssueDescription(?string $html): ?string
    {
        if ($html === null) {
            return null;
        }

        $allowedTags = '<p><br><b><strong><i><em><u><ul><ol><li><blockquote><code><pre><a><h1><h2><h3><h4><h5><h6>';
        $clean = strip_tags($html, $allowedTags);

        // Remove common inline event handlers and javascript: links.
        $clean = preg_replace('/\s+on\w+\s*=\s*(".*?"|\'.*?\'|[^\s>]+)/i', '', $clean ?? '');
        $clean = preg_replace('/href\s*=\s*("|\')\s*javascript:[^"\']*\1/i', 'href="#"', $clean ?? '');
        $clean = trim($clean ?? '');

        return Str::of(strip_tags($clean))->trim()->isEmpty() ? null : $clean;
    }
}
