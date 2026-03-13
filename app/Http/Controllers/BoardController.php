<?php

namespace App\Http\Controllers;

use App\Models\Board;
use App\Models\Project;
use App\Models\Workflow;
use Illuminate\Http\Request;

class BoardController extends Controller
{
    public function index(Request $request)
    {
        $boards = Board::with(['project:id,name,project_key', 'projects:id,name,project_key'])
            ->latest('id')->paginate(15);
        if ($request->filled('partial')) {
            return view('boards._table', compact('boards'));
        }
        return view('boards.index', compact('boards'));
    }

    public function create(Request $request)
    {
        $board = null;
        $projects = Project::where('is_active', true)->orderBy('name')->get();
        if ($request->ajax() || $request->filled('modal')) {
            return view('boards._form', compact('board', 'projects'));
        }
        return view('boards.create', compact('projects'));
    }

    public function store(Request $request)
    {
        $projectIds = $request->input('project_ids') ?? $request->input('project_ids[]') ?? [];
        if (! is_array($projectIds)) {
            $projectIds = array_filter([$projectIds]);
        }
        $projectIds = array_values(array_filter(array_map('intval', $projectIds)));
        if (count($projectIds) < 1) {
            if ($request->ajax() || $request->wantsJson()) {
                return response()->json(['success' => false, 'message' => 'Select at least one project.', 'errors' => ['project_ids' => ['Select at least one project.']]], 422);
            }
            return redirect()->back()->withErrors(['project_ids' => 'Select at least one project.'])->withInput();
        }
        foreach ($projectIds as $id) {
            if (! Project::where('id', $id)->exists()) {
                if ($request->ajax() || $request->wantsJson()) {
                    return response()->json(['success' => false, 'message' => 'Invalid project selected.', 'errors' => ['project_ids' => ['Invalid project selected.']]], 422);
                }
                return redirect()->back()->withErrors(['project_ids' => 'Invalid project selected.'])->withInput();
            }
        }
        $validated = $request->validate([
            'name' => 'nullable|string|max:150',
            'board_type' => 'required|in:scrum,kanban',
        ]);
        $validated['project_ids'] = $projectIds;
        $primaryId = $projectIds[0] ?? null;
        $board = Board::create([
            'project_id' => $primaryId,
            'name' => $validated['name'] ?? null,
            'board_type' => $validated['board_type'],
        ]);
        $board->projects()->sync($projectIds);
        if ($request->ajax() || $request->wantsJson()) {
            return response()->json(['success' => true, 'message' => 'Board created.']);
        }
        return redirect()->route('boards.index')->with('success', 'Board created.');
    }

    public function show(Board $board)
    {
        $board->load(['project', 'sprints']);
        if (request()->filled('modal')) {
            return view('boards._show_modal', compact('board'));
        }
        return view('boards.show', compact('board'));
    }

    public function edit(Board $board)
    {
        $board->load(['projects', 'workflows']);
        $projects = Project::where('is_active', true)->orderBy('name')->get();
        // Show all workflow diagrams that have transitions, regardless of selected projects
        $workflows = Workflow::with('project:id,name,project_key')
            ->whereHas('transitions')
            ->orderBy('name')
            ->get();
        if (request()->ajax() || request()->filled('modal')) {
            return view('boards._form', compact('board', 'projects', 'workflows'));
        }
        return view('boards.edit', compact('board', 'projects', 'workflows'));
    }

    public function update(Request $request, Board $board)
    {
        // Support both project_ids and project_ids[] (form multi-select)
        $projectIds = $request->input('project_ids') ?? $request->input('project_ids[]') ?? [];
        if (! is_array($projectIds)) {
            $projectIds = array_filter([$projectIds]);
        }
        $projectIds = array_values(array_filter(array_map('intval', $projectIds)));

        $validated = $request->validate([
            'name' => 'nullable|string|max:150',
            'board_type' => 'required|in:scrum,kanban',
        ]);

        if (count($projectIds) < 1) {
            if ($request->ajax() || $request->wantsJson()) {
                return response()->json(['success' => false, 'message' => 'Select at least one project.', 'errors' => ['project_ids' => ['Select at least one project.']]], 422);
            }
            return redirect()->back()->withErrors(['project_ids' => 'Select at least one project.'])->withInput();
        }

        foreach ($projectIds as $id) {
            if (! Project::where('id', $id)->exists()) {
                if ($request->ajax() || $request->wantsJson()) {
                    return response()->json(['success' => false, 'message' => 'Invalid project selected.', 'errors' => ['project_ids' => ['Invalid project selected.']]], 422);
                }
                return redirect()->back()->withErrors(['project_ids' => 'Invalid project selected.'])->withInput();
            }
        }

        $validated['project_ids'] = $projectIds;
        $primaryId = $projectIds[0] ?? $board->project_id;
        $board->update([
            'project_id' => $primaryId,
            'name' => $validated['name'] ?? null,
            'board_type' => $validated['board_type'],
        ]);
        $board->projects()->sync($projectIds);

        // Optional: tag a single workflow diagram to this board (used by Kanban status workflow)
        $workflowId = (int) $request->input('workflow_id', 0);
        if ($workflowId > 0) {
            // Any workflow diagram with transitions can be used, independent of board projects
            $validWorkflow = Workflow::where('id', $workflowId)
                ->whereHas('transitions')
                ->exists();
            if (! $validWorkflow) {
                if ($request->ajax() || $request->wantsJson()) {
                    return response()->json(['success' => false, 'message' => 'Invalid workflow selected.', 'errors' => ['workflow_id' => ['Invalid workflow selected.']]], 422);
                }
                return redirect()->back()->withErrors(['workflow_id' => 'Invalid workflow selected.'])->withInput();
            }
        }
        // Clear previous workflow tags and apply new one (if any)
        Workflow::where('board_id', $board->id)->update(['board_id' => null]);
        if ($workflowId > 0) {
            Workflow::where('id', $workflowId)->update(['board_id' => $board->id]);
        }
        if ($request->ajax() || $request->wantsJson()) {
            return response()->json(['success' => true, 'message' => 'Board updated.']);
        }
        return redirect()->route('boards.index')->with('success', 'Board updated.');
    }

    public function destroy(Request $request, Board $board)
    {
        $board->delete();
        if ($request->ajax() || $request->wantsJson()) {
            return response()->json(['success' => true, 'message' => 'Board deleted.']);
        }
        return redirect()->route('boards.index')->with('success', 'Board deleted.');
    }
}
