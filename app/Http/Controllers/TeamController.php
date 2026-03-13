<?php

namespace App\Http\Controllers;

use App\Models\Project;
use App\Models\Team;
use Illuminate\Http\Request;

class TeamController extends Controller
{
    public function index(Request $request)
    {
        $teams = Team::withCount(['members', 'projects'])->orderByDesc('id')->paginate(15);
        if ($request->filled('partial')) {
            return view('teams._table', compact('teams'));
        }
        return view('teams.index', compact('teams'));
    }

    public function create(Request $request)
    {
        $team = null;
        $projects = Project::where('is_active', true)->orderBy('name')->get(['id', 'name', 'project_key']);
        if ($request->ajax() || $request->filled('modal')) {
            return view('teams._form', compact('team', 'projects'));
        }
        return view('teams.create', compact('team', 'projects'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:150',
            'description' => 'nullable|string',
            'project_ids' => 'nullable|array',
            'project_ids.*' => 'exists:projects,id',
        ]);
        $team = Team::create([
            'name' => $validated['name'],
            'description' => $validated['description'] ?? null,
        ]);
        $team->projects()->sync($validated['project_ids'] ?? []);
        if ($request->ajax() || $request->wantsJson()) {
            return response()->json(['success' => true, 'message' => 'Team created.']);
        }
        return redirect()->route('teams.index')->with('success', 'Team created.');
    }

    public function show(Team $team)
    {
        $team->load(['members', 'projects']);
        if (request()->filled('modal')) {
            return view('teams._show_modal', compact('team'));
        }
        return view('teams.show', compact('team'));
    }

    public function edit(Team $team)
    {
        $team->load('projects');
        $projects = Project::where('is_active', true)->orderBy('name')->get(['id', 'name', 'project_key']);
        if (request()->ajax() || request()->filled('modal')) {
            return view('teams._form', compact('team', 'projects'));
        }
        return view('teams.edit', compact('team', 'projects'));
    }

    public function update(Request $request, Team $team)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:150',
            'description' => 'nullable|string',
            'project_ids' => 'nullable|array',
            'project_ids.*' => 'exists:projects,id',
        ]);
        $team->update([
            'name' => $validated['name'],
            'description' => $validated['description'] ?? null,
        ]);
        $team->projects()->sync($validated['project_ids'] ?? []);
        if ($request->ajax() || $request->wantsJson()) {
            return response()->json(['success' => true, 'message' => 'Team updated.']);
        }
        return redirect()->route('teams.index')->with('success', 'Team updated.');
    }

    public function destroy(Request $request, Team $team)
    {
        $team->delete();
        if ($request->ajax() || $request->wantsJson()) {
            return response()->json(['success' => true, 'message' => 'Team deleted.']);
        }
        return redirect()->route('teams.index')->with('success', 'Team deleted.');
    }
}
