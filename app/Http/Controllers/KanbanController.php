<?php

namespace App\Http\Controllers;

use App\Models\Board;
use App\Models\Issue;
use App\Models\Project;
use App\Models\Sprint;
use App\Models\Status;
use App\Models\User;
use Illuminate\Http\Request;

class KanbanController extends Controller
{
    public function index()
    {
        $boards = Board::with(['project:id,name,project_key', 'projects:id,name,project_key'])
            ->whereHas('projects', fn ($q) => $q->where('is_active', true))
            ->orderBy('name')
            ->get();
        if ($boards->isNotEmpty() && (request()->ajax() || request()->header('X-Requested-With') === 'XMLHttpRequest')) {
            return $this->showBoard($boards->first());
        }
        if ($boards->isNotEmpty()) {
            return redirect()->route('kanban.board.show', $boards->first());
        }
        $first = Project::where('is_active', true)->orderBy('name')->first();
        if ($first && (request()->ajax() || request()->header('X-Requested-With') === 'XMLHttpRequest')) {
            return $this->board($first);
        }
        if ($first) {
            return redirect()->route('kanban.board', $first);
        }
        $projects = Project::where('is_active', true)->orderBy('name')->get(['id', 'name', 'project_key']);
        return view('kanban.index', compact('projects', 'boards'));
    }

    /** Show Kanban by Board: one board selected, show issues from all its tagged projects. */
    public function showBoard(Board $board)
    {
        $board->load(['projects' => fn ($q) => $q->where('is_active', true)->orderBy('name')]);
        $boardProjects = $board->projects;
        $project = $board->project ?? $boardProjects->first();
        if (! $project) {
            abort(404, 'Board has no projects.');
        }
        $boards = Board::with(['project:id,name,project_key', 'projects:id,name,project_key'])
            ->whereHas('projects', fn ($q) => $q->where('is_active', true))
            ->orderBy('name')
            ->get();
        $projectIds = $boardProjects->pluck('id')->all();
        return $this->boardResponse($project, $boards, $board, $boardProjects, $projectIds);
    }

    public function boardStats(Project $project): array
    {
        $total = Issue::where('project_id', $project->id)->count();
        if ($total === 0) {
            return [
                'total' => 0,
                'segments' => [['label' => 'Open issues', 'count' => 0, 'percentage' => 0, 'color' => '#6c757d']],
            ];
        }

        $openCount = Issue::where('project_id', $project->id)->whereNull('status_id')->count();
        $byAssignee = Issue::where('project_id', $project->id)
            ->whereNotNull('status_id')
            ->selectRaw('assignee_id, count(*) as issue_count')
            ->groupBy('assignee_id')
            ->get();

        $colors = ['#696cff', '#059669', '#d97706', '#dc2626', '#7c3aed', '#0891b2', '#65a30d', '#ca8a04'];
        $segments = [];
        $ci = 0;

        $segments[] = [
            'label' => 'Open issues',
            'count' => $openCount,
            'percentage' => round($openCount / $total * 100, 1),
            'color' => '#6c757d',
        ];

        $assigneeIds = $byAssignee->pluck('assignee_id')->filter()->values()->all();
        $users = $assigneeIds ? User::whereIn('id', $assigneeIds)->get()->keyBy('id') : collect();

        foreach ($byAssignee as $row) {
            $assigneeId = $row->assignee_id;
            $count = (int) $row->issue_count;
            $label = $assigneeId ? ($users->get($assigneeId)?->name ?? 'User #'.$assigneeId) : 'Unassigned';
            $segments[] = [
                'label' => $label,
                'count' => $count,
                'percentage' => round($count / $total * 100, 1),
                'color' => $colors[$ci % count($colors)],
            ];
            $ci++;
        }

        return ['total' => $total, 'segments' => $segments];
    }

    public function board(Project $project)
    {
        $boards = Board::with(['project:id,name,project_key', 'projects:id,name,project_key'])
            ->whereHas('projects', fn ($q) => $q->where('is_active', true))
            ->orderBy('name')
            ->get();
        return $this->boardResponse($project, $boards, null, null, null);
    }

    /** Build Kanban view data and return full or partial view. When $boardProjectIds is set, load issues from all those projects. */
    private function boardResponse(Project $project, $boards, ?Board $currentBoard = null, $boardProjects = null, ?array $boardProjectIds = null)
    {
        $projects = $boards->isEmpty()
            ? Project::where('is_active', true)->orderBy('name')->get(['id', 'name', 'project_key'])
            : collect();
        $sprints = $currentBoard
            ? Sprint::with('board:id,project_id,name')->where('board_id', $currentBoard->id)->orderByDesc('start_date')->get()
            : Sprint::with('board:id,project_id,name')->whereHas('board', fn ($q) => $q->where('project_id', $project->id))->orderByDesc('start_date')->get();
        $sprintId = request()->integer('sprint_id', 0);
        $sprint = $sprintId ? $sprints->firstWhere('id', $sprintId) : null;

        // Prefer a workflow diagram explicitly tagged to this board; fall back to project "Kanban" workflow
        if ($currentBoard) {
            $workflow = $currentBoard->workflows()->with('transitions')->first();
        } else {
            $workflow = null;
        }
        if (! $workflow) {
            $workflow = $project->workflows()->where('name', 'Kanban')->with('transitions')->first();
        }
        $statuses = $workflow
            ? $workflow->getStatusesInOrder()
            : Status::orderBy('order_no')->get();

        $issueQuery = $boardProjectIds !== null && count($boardProjectIds) > 0
            ? Issue::whereIn('project_id', $boardProjectIds)
            : Issue::where('project_id', $project->id);
        $issueQuery = $issueQuery->with(['issueType:id,name,color', 'priority:id,name,color', 'assignee:id,username,display_name', 'project:id,name,project_key']);
        if ($sprint) {
            $issueQuery->whereHas('sprints', fn ($q) => $q->where('sprints.id', $sprint->id));
        }
        $allIssues = $issueQuery->orderBy('due_date')->get();

        $issuesByStatus = [];
        foreach ($statuses as $status) {
            $issuesByStatus[$status->id] = $allIssues->where('status_id', $status->id)->values();
        }
        $backlog = $allIssues->whereNull('status_id')->values();

        $boardProjects = $boardProjects ?? collect();

        if (request()->boolean('partial')) {
            return view('kanban._board_content', compact('project', 'boards', 'projects', 'currentBoard', 'boardProjects', 'statuses', 'issuesByStatus', 'backlog', 'sprints', 'sprint', 'workflow'));
        }

        return view('kanban.board', compact('project', 'boards', 'projects', 'currentBoard', 'boardProjects', 'statuses', 'issuesByStatus', 'backlog', 'sprints', 'sprint', 'workflow'));
    }

    public function updateStatus(Request $request, Issue $issue)
    {
        $validated = $request->validate([
            'status_id' => 'required|nullable|exists:statuses,id',
        ]);
        $issue->update(['status_id' => $validated['status_id'] ?: null]);
        return response()->json(['success' => true, 'issue_key' => $issue->issue_key]);
    }
}
