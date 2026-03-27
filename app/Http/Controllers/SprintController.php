<?php

namespace App\Http\Controllers;

use App\Models\Board;
use App\Models\Sprint;
use Illuminate\Http\Request;

class SprintController extends Controller
{
    public function index(Request $request)
    {
        $perPage = max(10, min(100, (int) $request->input('per_page', 10)));
        $query = Sprint::with('board.project');
        if ($request->filled('board_id')) {
            $query->where('board_id', $request->board_id);
        }
        if ($request->filled('q')) {
            $term = trim((string) $request->input('q'));
            $query->where(function ($q) use ($term) {
                $q->where('name', 'like', "%{$term}%")
                    ->orWhere('goal', 'like', "%{$term}%")
                    ->orWhere('state', 'like', "%{$term}%");
            });
        }
        $sprints = $query->latest('id')->paginate($perPage);
        $boards = Board::with('project:id,name')->orderBy('name')->get();
        if ($request->filled('partial')) {
            return view('sprints._table', compact('sprints', 'boards'));
        }
        return view('sprints.index', compact('sprints', 'boards'));
    }

    public function create(Request $request)
    {
        $sprint = null;
        $boards = Board::with('project:id,name')->orderBy('name')->get();
        if ($request->ajax() || $request->filled('modal')) {
            return view('sprints._form', compact('sprint', 'boards'));
        }
        return view('sprints.create', compact('boards'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'board_id' => 'required|exists:boards,id',
            'name' => 'nullable|string|max:150',
            'goal' => 'nullable|string',
            'start_date' => 'nullable|date',
            'end_date' => 'nullable|date',
            'state' => 'required|in:planned,active,closed',
        ]);
        Sprint::create($validated);
        if ($request->ajax() || $request->wantsJson()) {
            return response()->json(['success' => true, 'message' => 'Sprint created.']);
        }
        return redirect()->route('sprints.index')->with('success', 'Sprint created.');
    }

    public function show(Sprint $sprint)
    {
        $sprint->load(['board.project', 'issues']);
        if (request()->filled('modal')) {
            return view('sprints._show_modal', compact('sprint'));
        }
        return view('sprints.show', compact('sprint'));
    }

    public function edit(Sprint $sprint)
    {
        $boards = Board::with('project:id,name')->orderBy('name')->get();
        if (request()->ajax() || request()->filled('modal')) {
            return view('sprints._form', compact('sprint', 'boards'));
        }
        return view('sprints.edit', compact('sprint', 'boards'));
    }

    public function update(Request $request, Sprint $sprint)
    {
        $validated = $request->validate([
            'board_id' => 'required|exists:boards,id',
            'name' => 'nullable|string|max:150',
            'goal' => 'nullable|string',
            'start_date' => 'nullable|date',
            'end_date' => 'nullable|date',
            'state' => 'required|in:planned,active,closed',
        ]);
        $sprint->update($validated);
        if ($request->ajax() || $request->wantsJson()) {
            return response()->json(['success' => true, 'message' => 'Sprint updated.']);
        }
        return redirect()->route('sprints.index')->with('success', 'Sprint updated.');
    }

    public function destroy(Request $request, Sprint $sprint)
    {
        $sprint->delete();
        if ($request->ajax() || $request->wantsJson()) {
            return response()->json(['success' => true, 'message' => 'Sprint deleted.']);
        }
        return redirect()->route('sprints.index')->with('success', 'Sprint deleted.');
    }
}
