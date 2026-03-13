<?php

namespace App\Http\Controllers;

use App\Models\Organization;
use App\Models\Project;
use App\Models\User;
use Illuminate\Http\Request;

class ProjectController extends Controller
{
    public function index(Request $request)
    {
        $projects = Project::with(['organization:id,name', 'lead:id,username,display_name'])->latest('id')->paginate(15);
        if ($request->filled('partial')) {
            return view('projects._table', compact('projects'));
        }
        return view('projects.index', compact('projects'));
    }

    public function create(Request $request)
    {
        $project = null;
        $organizations = Organization::orderBy('name')->get();
        $users = User::where('is_active', true)->orderBy('display_name')->get();
        if ($request->ajax() || $request->filled('modal')) {
            return view('projects._form', compact('project', 'organizations', 'users'));
        }
        return view('projects.create', compact('organizations', 'users'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'organization_id' => 'required|exists:organizations,id',
            'project_key' => 'required|string|max:20|unique:projects,project_key',
            'name' => 'required|string|max:150',
            'description' => 'nullable|string',
            'lead_user_id' => 'nullable|exists:users,id',
            'project_type' => 'required|in:scrum,kanban',
            'is_active' => 'nullable',
        ]);
        $validated['is_active'] = $request->boolean('is_active', true);
        Project::create($validated);
        if ($request->ajax() || $request->wantsJson()) {
            return response()->json(['success' => true, 'message' => 'Project created.']);
        }
        return redirect()->route('projects.index')->with('success', 'Project created.');
    }

    public function show(Project $project)
    {
        $project->load(['organization', 'lead', 'issues' => fn($q) => $q->take(20)]);
        if (request()->filled('modal')) {
            return view('projects._show_modal', compact('project'));
        }
        return view('projects.show', compact('project'));
    }

    public function edit(Project $project)
    {
        $organizations = Organization::orderBy('name')->get();
        $users = User::where('is_active', true)->orderBy('display_name')->get();
        if (request()->ajax() || request()->filled('modal')) {
            return view('projects._form', compact('project', 'organizations', 'users'));
        }
        return view('projects.edit', compact('project', 'organizations', 'users'));
    }

    public function update(Request $request, Project $project)
    {
        $validated = $request->validate([
            'organization_id' => 'required|exists:organizations,id',
            'project_key' => 'required|string|max:20|unique:projects,project_key,' . $project->id,
            'name' => 'required|string|max:150',
            'description' => 'nullable|string',
            'lead_user_id' => 'nullable|exists:users,id',
            'project_type' => 'required|in:scrum,kanban',
            'is_active' => 'nullable',
        ]);
        $validated['is_active'] = $request->boolean('is_active', true);
        $project->update($validated);
        if ($request->ajax() || $request->wantsJson()) {
            return response()->json(['success' => true, 'message' => 'Project updated.']);
        }
        return redirect()->route('projects.index')->with('success', 'Project updated.');
    }

    public function destroy(Request $request, Project $project)
    {
        $project->delete();
        if ($request->ajax() || $request->wantsJson()) {
            return response()->json(['success' => true, 'message' => 'Project deleted.']);
        }
        return redirect()->route('projects.index')->with('success', 'Project deleted.');
    }
}
