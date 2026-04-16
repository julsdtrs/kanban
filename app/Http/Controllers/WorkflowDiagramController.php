<?php

namespace App\Http\Controllers;

use App\Models\Board;
use App\Models\Status;
use App\Models\Workflow;
use App\Models\WorkflowTransition;
use Illuminate\Http\Request;

class WorkflowDiagramController extends Controller
{
    private function boardsWithWorkflow()
    {
        return Board::with([
            'project:id,name,project_key',
            'workflows' => fn ($q) => $q->with('project:id,name')->orderBy('name'),
        ])
            ->whereHas('workflows')
            ->orderBy('name')
            ->get(['id', 'name', 'project_id', 'board_type']);
    }

    public function index()
    {
        $boards = $this->boardsWithWorkflow();
        if ($boards->isEmpty()) {
            return view('workflow-diagram.index', compact('boards'));
        }
        $firstWorkflow = optional($boards->first()->workflows)->first();
        if (! $firstWorkflow) {
            return view('workflow-diagram.index', compact('boards'));
        }

        // Always show diagram for first workflow: full page load redirects here; AJAX gets show view
        if (request()->ajax() || request()->header('X-Requested-With') === 'XMLHttpRequest') {
            return $this->show($firstWorkflow);
        }
        return redirect()->route('workflows.diagram.show', $firstWorkflow);
    }

    public function show(Workflow $workflow)
    {
        $boards = $this->boardsWithWorkflow();
        $workflow->load(['project', 'transitions' => fn ($q) => $q->orderBy('order'), 'transitions.fromStatus', 'transitions.toStatus']);
        $selectedBoard = $workflow->board;
        if (! $selectedBoard && $boards->isNotEmpty()) {
            $selectedBoard = $boards->first(function (Board $board) use ($workflow) {
                return $board->workflows->contains('id', $workflow->id);
            }) ?: $boards->first();
        }
        $statuses = Status::orderBy('order_no')->get();
        // Unique statuses that appear in any transition (for connected graph)
        $statusIdsInWorkflow = $workflow->transitions->pluck('from_status_id')->merge($workflow->transitions->pluck('to_status_id'))->unique()->values();
        $statusesInWorkflow = Status::whereIn('id', $statusIdsInWorkflow)->orderBy('order_no')->get()->keyBy('id');
        // Group transitions by from_status so one status can have multiple outgoing (e.g. To Do → In Progress, To Do → In QA)
        $transitionsByFrom = $workflow->transitions->groupBy('from_status_id');
        $transitionsForDiagram = $workflow->transitions->map(fn ($t) => [
            'id' => $t->id,
            'from_status_id' => $t->from_status_id,
            'to_status_id' => $t->to_status_id,
            'transition_name' => $t->transition_name,
            'from_status' => $t->fromStatus,
            'to_status' => $t->toStatus,
        ])->values()->all();
        $statusesForDiagram = $statusesInWorkflow->values()->all();

        if (request()->boolean('partial')) {
            return view('workflow-diagram._diagram_content', compact('workflow', 'statuses', 'statusesInWorkflow', 'transitionsByFrom', 'transitionsForDiagram', 'statusesForDiagram'));
        }
        return view('workflow-diagram.show', compact('workflow', 'boards', 'selectedBoard', 'statuses', 'statusesInWorkflow', 'transitionsByFrom', 'transitionsForDiagram', 'statusesForDiagram'));
    }

    public function storeTransition(Request $request)
    {
        $validated = $request->validate([
            'workflow_id' => 'required|exists:workflows,id',
            'from_status_id' => 'required|exists:statuses,id',
            'to_status_id' => 'required|exists:statuses,id',
            'transition_name' => 'nullable|string|max:150',
        ]);
        if ($validated['from_status_id'] === $validated['to_status_id']) {
            return response()->json(['success' => false, 'message' => 'From and To status must be different.'], 422);
        }
        $exists = WorkflowTransition::where('workflow_id', $validated['workflow_id'])
            ->where('from_status_id', $validated['from_status_id'])
            ->where('to_status_id', $validated['to_status_id'])
            ->exists();
        if ($exists) {
            return response()->json(['success' => false, 'message' => 'This transition already exists.'], 422);
        }
        $maxOrder = (int) WorkflowTransition::where('workflow_id', $validated['workflow_id'])->max('order');
        $validated['order'] = $maxOrder + 1;
        $t = WorkflowTransition::create($validated);
        return response()->json(['success' => true, 'transition' => $t->load(['fromStatus', 'toStatus'])]);
    }

    public function destroyTransition(WorkflowTransition $workflowTransition)
    {
        $workflowTransition->delete();
        return response()->json(['success' => true]);
    }

    public function reorderTransitions(Request $request, Workflow $workflow)
    {
        $validated = $request->validate([
            'order' => 'required|array',
            'order.*' => 'integer|exists:workflow_transitions,id',
        ]);
        $ids = $validated['order'];
        $transitions = WorkflowTransition::where('workflow_id', $workflow->id)->whereIn('id', $ids)->get()->keyBy('id');
        foreach ($ids as $position => $id) {
            if (isset($transitions[$id])) {
                $transitions[$id]->update(['order' => $position]);
            }
        }
        return response()->json(['success' => true]);
    }
}
