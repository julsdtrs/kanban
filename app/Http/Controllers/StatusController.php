<?php

namespace App\Http\Controllers;

use App\Models\Status;
use Illuminate\Http\Request;

class StatusController extends Controller
{
    public function index(Request $request)
    {
        $statuses = Status::orderBy('order_no')->orderBy('id')->get();
        if ($request->filled('partial')) {
            return view('statuses._table', compact('statuses'));
        }
        return view('statuses.index', compact('statuses'));
    }

    public function reorder(Request $request)
    {
        $validated = $request->validate([
            'order' => 'required|array',
            'order.*' => 'integer|exists:statuses,id',
        ]);
        $ids = $validated['order'];
        $statuses = Status::whereIn('id', $ids)->get()->keyBy('id');
        foreach ($ids as $position => $id) {
            if (isset($statuses[$id])) {
                $statuses[$id]->update(['order_no' => $position]);
            }
        }
        if ($request->wantsJson() || $request->ajax()) {
            return response()->json(['success' => true, 'message' => 'Sequence updated.']);
        }
        return redirect()->route('statuses.index')->with('success', 'Sequence updated.');
    }

    public function create(Request $request)
    {
        $status = null;
        if ($request->ajax() || $request->filled('modal')) {
            return view('statuses._form', compact('status'));
        }
        return view('statuses.create', compact('status'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:50',
            'color' => 'nullable|string|max:20',
            'order_no' => 'nullable|integer',
        ]);
        $validated['order_no'] = $validated['order_no'] ?? 0;
        // Default newly created statuses to "todo" category; category is not editable from the UI.
        $validated['category'] = 'todo';
        Status::create($validated);
        if ($request->ajax() || $request->wantsJson()) {
            return response()->json(['success' => true, 'message' => 'Status created.']);
        }
        return redirect()->route('statuses.index')->with('success', 'Status created.');
    }

    public function show(Status $status)
    {
        if (request()->filled('modal')) {
            return view('statuses._show_modal', compact('status'));
        }
        return view('statuses.show', compact('status'));
    }

    public function edit(Status $status)
    {
        if (request()->ajax() || request()->filled('modal')) {
            return view('statuses._form', compact('status'));
        }
        return view('statuses.edit', compact('status'));
    }

    public function update(Request $request, Status $status)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:50',
            'color' => 'nullable|string|max:20',
            'order_no' => 'nullable|integer',
        ]);
        $validated['order_no'] = $validated['order_no'] ?? 0;
        // Preserve existing category; it is controlled via seeding/system rules, not the form.
        $validated['category'] = $status->category;
        $status->update($validated);
        if ($request->ajax() || $request->wantsJson()) {
            return response()->json(['success' => true, 'message' => 'Status updated.']);
        }
        return redirect()->route('statuses.index')->with('success', 'Status updated.');
    }

    public function destroy(Request $request, Status $status)
    {
        $status->delete();
        if ($request->ajax() || $request->wantsJson()) {
            return response()->json(['success' => true, 'message' => 'Status deleted.']);
        }
        return redirect()->route('statuses.index')->with('success', 'Status deleted.');
    }
}
