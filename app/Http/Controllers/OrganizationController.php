<?php

namespace App\Http\Controllers;

use App\Models\Organization;
use Illuminate\Http\Request;

class OrganizationController extends Controller
{
    public function index(Request $request)
    {
        $perPage = max(10, min(100, (int) $request->input('per_page', 10)));
        $query = Organization::withCount('projects');
        if ($request->filled('q')) {
            $term = trim((string) $request->input('q'));
            $query->where(function ($q) use ($term) {
                $q->where('name', 'like', "%{$term}%")
                    ->orWhere('description', 'like', "%{$term}%");
            });
        }
        $organizations = $query->orderByDesc('id')->paginate($perPage);
        if ($request->filled('partial')) {
            return view('organizations._table', compact('organizations'));
        }
        return view('organizations.index', compact('organizations'));
    }

    public function create(Request $request)
    {
        $organization = null;
        if ($request->ajax() || $request->filled('modal')) {
            return view('organizations._form', compact('organization'));
        }
        return view('organizations.create', compact('organization'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:150',
            'description' => 'nullable|string',
        ]);
        Organization::create($validated);
        if ($request->ajax() || $request->wantsJson()) {
            return response()->json(['success' => true, 'message' => 'Organization created.']);
        }
        return redirect()->route('organizations.index')->with('success', 'Organization created.');
    }

    public function show(Organization $organization)
    {
        $organization->load('projects');
        if (request()->filled('modal')) {
            return view('organizations._show_modal', compact('organization'));
        }
        return view('organizations.show', compact('organization'));
    }

    public function edit(Organization $organization)
    {
        if (request()->ajax() || request()->filled('modal')) {
            return view('organizations._form', compact('organization'));
        }
        return view('organizations.edit', compact('organization'));
    }

    public function update(Request $request, Organization $organization)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:150',
            'description' => 'nullable|string',
        ]);
        $organization->update($validated);
        if ($request->ajax() || $request->wantsJson()) {
            return response()->json(['success' => true, 'message' => 'Organization updated.']);
        }
        return redirect()->route('organizations.index')->with('success', 'Organization updated.');
    }

    public function destroy(Request $request, Organization $organization)
    {
        $organization->delete();
        if ($request->ajax() || $request->wantsJson()) {
            return response()->json(['success' => true, 'message' => 'Organization deleted.']);
        }
        return redirect()->route('organizations.index')->with('success', 'Organization deleted.');
    }
}
