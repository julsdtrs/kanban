<?php

namespace App\Http\Controllers;

use App\Models\Board;
use App\Models\Workflow;
use Illuminate\Http\Request;

class WorkflowController extends Controller
{
    public function index(Request $request)
    {
        $workflows = Workflow::with(['board:id,name,project_id', 'board.project:id,name,project_key'])->latest('id')->paginate(15);
        if ($request->filled('partial')) {
            return view('workflows._table', compact('workflows'));
        }
        return view('workflows.index', compact('workflows'));
    }

    public function create(Request $request)
    {
        $workflow = null;
        $boards = Board::with('project:id,name,project_key')->orderBy('name')->get();
        if ($request->ajax() || $request->filled('modal')) {
            return view('workflows._form', compact('workflow', 'boards'));
        }
        return view('workflows.create', compact('boards'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:150',
            'board_id' => 'required|exists:boards,id',
        ]);
        $board = Board::find($validated['board_id']);
        Workflow::create([
            'name' => $validated['name'],
            'board_id' => $validated['board_id'],
            'project_id' => $board ? $board->project_id : null,
        ]);
        if ($request->ajax() || $request->wantsJson()) {
            return response()->json(['success' => true, 'message' => 'Workflow created.']);
        }
        return redirect()->route('workflows.index')->with('success', 'Workflow created.');
    }

    public function show(Workflow $workflow)
    {
        $workflow->load(['board', 'board.project', 'transitions.fromStatus', 'transitions.toStatus']);
        if (request()->filled('modal')) {
            return view('workflows._show_modal', compact('workflow'));
        }
        return view('workflows.show', compact('workflow'));
    }

    public function edit(Workflow $workflow)
    {
        $workflow->load('board');
        $boards = Board::with('project:id,name,project_key')->orderBy('name')->get();
        if (request()->ajax() || request()->filled('modal')) {
            return view('workflows._form', compact('workflow', 'boards'));
        }
        return view('workflows.edit', compact('workflow', 'boards'));
    }

    public function update(Request $request, Workflow $workflow)
    {
        $request->validate(['name' => 'required|string|max:150']);
        $boardId = $request->input('board_id');
        $name = $request->input('name');
        if (! $boardId || ! Board::where('id', $boardId)->exists()) {
            if ($request->ajax() || $request->wantsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Please select a board.',
                    'errors' => ['board_id' => ['The selected board is invalid.']],
                ], 422);
            }
            return redirect()->back()->withErrors(['board_id' => 'Please select a board.'])->withInput();
        }
        $board = Board::find($boardId);
        $workflow->update([
            'name' => $name,
            'board_id' => $boardId,
            'project_id' => $board ? $board->project_id : null,
        ]);
        if ($request->ajax() || $request->wantsJson()) {
            return response()->json(['success' => true, 'message' => 'Workflow updated.']);
        }
        return redirect()->route('workflows.index')->with('success', 'Workflow updated.');
    }

    public function destroy(Request $request, Workflow $workflow)
    {
        $workflow->delete();
        if ($request->ajax() || $request->wantsJson()) {
            return response()->json(['success' => true, 'message' => 'Workflow deleted.']);
        }
        return redirect()->route('workflows.index')->with('success', 'Workflow deleted.');
    }
}
