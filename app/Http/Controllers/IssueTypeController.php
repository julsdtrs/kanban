<?php

namespace App\Http\Controllers;

use App\Models\IssueType;
use Illuminate\Http\Request;

class IssueTypeController extends Controller
{
    public function index(Request $request)
    {
        $issueTypes = IssueType::latest('id')->paginate(15);
        if ($request->filled('partial')) {
            return view('issue-types._table', compact('issueTypes'));
        }
        return view('issue-types.index', compact('issueTypes'));
    }

    public function create(Request $request)
    {
        $issueType = null;
        if ($request->ajax() || $request->filled('modal')) {
            return view('issue-types._form', compact('issueType'));
        }
        return view('issue-types.create', compact('issueType'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:50',
            'icon' => 'nullable|string|max:100',
            'color' => 'nullable|string|max:20',
        ]);
        IssueType::create($validated);
        if ($request->ajax() || $request->wantsJson()) {
            return response()->json(['success' => true, 'message' => 'Issue type created.']);
        }
        return redirect()->route('issue-types.index')->with('success', 'Issue type created.');
    }

    public function show(IssueType $issueType)
    {
        if (request()->filled('modal')) {
            return view('issue-types._show_modal', compact('issueType'));
        }
        return view('issue-types.show', compact('issueType'));
    }

    public function edit(IssueType $issueType)
    {
        if (request()->ajax() || request()->filled('modal')) {
            return view('issue-types._form', compact('issueType'));
        }
        return view('issue-types.edit', compact('issueType'));
    }

    public function update(Request $request, IssueType $issueType)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:50',
            'icon' => 'nullable|string|max:100',
            'color' => 'nullable|string|max:20',
        ]);
        $issueType->update($validated);
        if ($request->ajax() || $request->wantsJson()) {
            return response()->json(['success' => true, 'message' => 'Issue type updated.']);
        }
        return redirect()->route('issue-types.index')->with('success', 'Issue type updated.');
    }

    public function destroy(Request $request, IssueType $issueType)
    {
        $issueType->delete();
        if ($request->ajax() || $request->wantsJson()) {
            return response()->json(['success' => true, 'message' => 'Issue type deleted.']);
        }
        return redirect()->route('issue-types.index')->with('success', 'Issue type deleted.');
    }
}
