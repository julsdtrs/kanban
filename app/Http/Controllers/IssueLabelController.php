<?php

namespace App\Http\Controllers;

use App\Models\IssueLabel;
use Illuminate\Http\Request;

class IssueLabelController extends Controller
{
    public function index(Request $request)
    {
        $issueLabels = IssueLabel::withCount('issues')->latest('id')->paginate(15);
        if ($request->filled('partial')) {
            return view('issue-labels._table', compact('issueLabels'));
        }
        return view('issue-labels.index', compact('issueLabels'));
    }

    public function create(Request $request)
    {
        $issueLabel = null;
        if ($request->ajax() || $request->filled('modal')) {
            return view('issue-labels._form', compact('issueLabel'));
        }
        return view('issue-labels.create', compact('issueLabel'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:100',
            'color' => 'nullable|string|max:20',
        ]);
        IssueLabel::create($validated);
        if ($request->ajax() || $request->wantsJson()) {
            return response()->json(['success' => true, 'message' => 'Issue label created.']);
        }
        return redirect()->route('issue-labels.index')->with('success', 'Issue label created.');
    }

    public function show(IssueLabel $issueLabel)
    {
        $issueLabel->load('issues');
        if (request()->filled('modal')) {
            return view('issue-labels._show_modal', compact('issueLabel'));
        }
        return view('issue-labels.show', compact('issueLabel'));
    }

    public function edit(IssueLabel $issueLabel)
    {
        if (request()->ajax() || request()->filled('modal')) {
            return view('issue-labels._form', compact('issueLabel'));
        }
        return view('issue-labels.edit', compact('issueLabel'));
    }

    public function update(Request $request, IssueLabel $issueLabel)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:100',
            'color' => 'nullable|string|max:20',
        ]);
        $issueLabel->update($validated);
        if ($request->ajax() || $request->wantsJson()) {
            return response()->json(['success' => true, 'message' => 'Issue label updated.']);
        }
        return redirect()->route('issue-labels.index')->with('success', 'Issue label updated.');
    }

    public function destroy(Request $request, IssueLabel $issueLabel)
    {
        $issueLabel->delete();
        if ($request->ajax() || $request->wantsJson()) {
            return response()->json(['success' => true, 'message' => 'Issue label deleted.']);
        }
        return redirect()->route('issue-labels.index')->with('success', 'Issue label deleted.');
    }
}
