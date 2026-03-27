<?php

namespace App\Http\Controllers;

use App\Models\Permission;
use Illuminate\Http\Request;

class PermissionController extends Controller
{
    public function index(Request $request)
    {
        $perPage = max(10, min(100, (int) $request->input('per_page', 10)));
        $query = Permission::query();
        if ($request->filled('q')) {
            $term = trim((string) $request->input('q'));
            $query->where(function ($q) use ($term) {
                $q->where('code', 'like', "%{$term}%")
                    ->orWhere('description', 'like', "%{$term}%");
            });
        }
        $permissions = $query->latest('id')->paginate($perPage);
        if ($request->filled('partial')) {
            return view('permissions._table', compact('permissions'));
        }
        return view('permissions.index', compact('permissions'));
    }

    public function create(Request $request)
    {
        $permission = null;
        if ($request->ajax() || $request->filled('modal')) {
            return view('permissions._form', compact('permission'));
        }
        return view('permissions.create', compact('permission'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'code' => 'required|string|max:100|unique:permissions,code',
            'description' => 'nullable|string',
        ]);
        Permission::create($validated);
        if ($request->ajax() || $request->wantsJson()) {
            return response()->json(['success' => true, 'message' => 'Permission created.']);
        }
        return redirect()->route('permissions.index')->with('success', 'Permission created.');
    }

    public function show(Permission $permission)
    {
        if (request()->filled('modal')) {
            return view('permissions._show_modal', compact('permission'));
        }
        return view('permissions.show', compact('permission'));
    }

    public function edit(Permission $permission)
    {
        if (request()->ajax() || request()->filled('modal')) {
            return view('permissions._form', compact('permission'));
        }
        return view('permissions.edit', compact('permission'));
    }

    public function update(Request $request, Permission $permission)
    {
        $validated = $request->validate([
            'code' => 'required|string|max:100|unique:permissions,code,' . $permission->id,
            'description' => 'nullable|string',
        ]);
        $permission->update($validated);
        if ($request->ajax() || $request->wantsJson()) {
            return response()->json(['success' => true, 'message' => 'Permission updated.']);
        }
        return redirect()->route('permissions.index')->with('success', 'Permission updated.');
    }

    public function destroy(Request $request, Permission $permission)
    {
        $permission->delete();
        if ($request->ajax() || $request->wantsJson()) {
            return response()->json(['success' => true, 'message' => 'Permission deleted.']);
        }
        return redirect()->route('permissions.index')->with('success', 'Permission deleted.');
    }
}
