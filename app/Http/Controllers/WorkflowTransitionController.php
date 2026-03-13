<?php

namespace App\Http\Controllers;

use App\Models\Status;
use App\Models\Workflow;
use App\Models\WorkflowTransition;
use Illuminate\Http\Request;

class WorkflowTransitionController extends Controller
{
    public function index(Request $request)
    {
        $query = WorkflowTransition::with(['workflow.project', 'fromStatus', 'toStatus']);
        if ($request->filled('workflow_id')) {
            $query->where('workflow_id', $request->workflow_id);
        }
        $transitions = $query->latest('id')->paginate(15);
        $workflows = Workflow::with('project:id,name')->orderBy('name')->get(['id', 'name', 'project_id']);
        if ($request->filled('partial')) {
            return view('workflow-transitions._table', compact('transitions', 'workflows'));
        }
        return view('workflow-transitions.index', compact('transitions', 'workflows'));
    }

    public function create(Request $request)
    {
        $workflowTransition = null;
        $workflows = Workflow::with('project:id,name')->orderBy('name')->get(['id', 'name', 'project_id']);
        $statuses = Status::orderBy('order_no')->get();
        if ($request->ajax() || $request->filled('modal')) {
            return view('workflow-transitions._form', compact('workflowTransition', 'workflows', 'statuses'));
        }
        return view('workflow-transitions.create', compact('workflows', 'statuses'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'workflow_id' => 'required|exists:workflows,id',
            'from_status_id' => 'required|exists:statuses,id',
            'to_status_id' => 'required|exists:statuses,id',
            'transition_name' => 'nullable|string|max:150',
        ]);
        WorkflowTransition::create($validated);
        if ($request->ajax() || $request->wantsJson()) {
            return response()->json(['success' => true, 'message' => 'Transition created.']);
        }
        return redirect()->route('workflow-transitions.index')->with('success', 'Transition created.');
    }

    public function show(WorkflowTransition $workflowTransition)
    {
        $workflowTransition->load(['workflow.project', 'fromStatus', 'toStatus']);
        if (request()->filled('modal')) {
            return view('workflow-transitions._show_modal', compact('workflowTransition'));
        }
        return view('workflow-transitions.show', compact('workflowTransition'));
    }

    public function edit(WorkflowTransition $workflowTransition)
    {
        $workflows = Workflow::with('project:id,name')->orderBy('name')->get(['id', 'name', 'project_id']);
        $statuses = Status::orderBy('order_no')->get();
        if (request()->ajax() || request()->filled('modal')) {
            return view('workflow-transitions._form', compact('workflowTransition', 'workflows', 'statuses'));
        }
        return view('workflow-transitions.edit', compact('workflowTransition', 'workflows', 'statuses'));
    }

    public function update(Request $request, WorkflowTransition $workflowTransition)
    {
        $validated = $request->validate([
            'workflow_id' => 'required|exists:workflows,id',
            'from_status_id' => 'required|exists:statuses,id',
            'to_status_id' => 'required|exists:statuses,id',
            'transition_name' => 'nullable|string|max:150',
        ]);
        $workflowTransition->update($validated);
        if ($request->ajax() || $request->wantsJson()) {
            return response()->json(['success' => true, 'message' => 'Transition updated.']);
        }
        return redirect()->route('workflow-transitions.index')->with('success', 'Transition updated.');
    }

    public function destroy(Request $request, WorkflowTransition $workflowTransition)
    {
        $workflowTransition->delete();
        if ($request->ajax() || $request->wantsJson()) {
            return response()->json(['success' => true, 'message' => 'Transition deleted.']);
        }
        return redirect()->route('workflow-transitions.index')->with('success', 'Transition deleted.');
    }
}
