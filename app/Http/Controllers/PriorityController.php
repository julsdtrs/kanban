<?php

namespace App\Http\Controllers;

use App\Models\Priority;
use Illuminate\Http\Request;

class PriorityController extends Controller
{
    public function index(Request $request)
    {
        $perPage = max(10, min(100, (int) $request->input('per_page', 10)));
        $query = Priority::query();
        if ($request->filled('q')) {
            $term = trim((string) $request->input('q'));
            $query->where('name', 'like', "%{$term}%");
        }
        $priorities = $query->orderBy('level')->paginate($perPage);
        if ($request->filled('partial')) {
            return view('priorities._table', compact('priorities'));
        }
        return view('priorities.index', compact('priorities'));
    }

    public function create(Request $request)
    {
        $priority = null;
        if ($request->ajax() || $request->filled('modal')) {
            return view('priorities._form', compact('priority'));
        }
        return view('priorities.create', compact('priority'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:50',
            'level' => 'nullable|integer',
            'color' => 'nullable|string|max:20',
        ]);
        $validated['level'] = $validated['level'] ?? 0;
        Priority::create($validated);
        if ($request->ajax() || $request->wantsJson()) {
            return response()->json(['success' => true, 'message' => 'Priority created.']);
        }
        return redirect()->route('priorities.index')->with('success', 'Priority created.');
    }

    public function show(Priority $priority)
    {
        if (request()->filled('modal')) {
            return view('priorities._show_modal', compact('priority'));
        }
        return view('priorities.show', compact('priority'));
    }

    public function edit(Priority $priority)
    {
        if (request()->ajax() || request()->filled('modal')) {
            return view('priorities._form', compact('priority'));
        }
        return view('priorities.edit', compact('priority'));
    }

    public function update(Request $request, Priority $priority)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:50',
            'level' => 'nullable|integer',
            'color' => 'nullable|string|max:20',
        ]);
        $validated['level'] = $validated['level'] ?? 0;
        $priority->update($validated);
        if ($request->ajax() || $request->wantsJson()) {
            return response()->json(['success' => true, 'message' => 'Priority updated.']);
        }
        return redirect()->route('priorities.index')->with('success', 'Priority updated.');
    }

    public function destroy(Request $request, Priority $priority)
    {
        $priority->delete();
        if ($request->ajax() || $request->wantsJson()) {
            return response()->json(['success' => true, 'message' => 'Priority deleted.']);
        }
        return redirect()->route('priorities.index')->with('success', 'Priority deleted.');
    }
}
