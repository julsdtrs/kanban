<?php

namespace App\Http\Controllers;

use App\Models\Role;
use Illuminate\Http\Request;

class RoleController extends Controller
{
    public function index(Request $request)
    {
        $roles = Role::withCount('users')->latest('id')->paginate(15);
        if ($request->filled('partial')) {
            return view('roles._table', compact('roles'));
        }
        return view('roles.index', compact('roles'));
    }

    public function create(Request $request)
    {
        $role = null;
        if ($request->ajax() || $request->filled('modal')) {
            return view('roles._form', compact('role'));
        }
        return view('roles.create', compact('role'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:100|unique:roles,name',
            'description' => 'nullable|string',
        ]);
        Role::create($validated);
        if ($request->ajax() || $request->wantsJson()) {
            return response()->json(['success' => true, 'message' => 'Role created.']);
        }
        return redirect()->route('roles.index')->with('success', 'Role created.');
    }

    public function show(Role $role)
    {
        $role->load(['permissions', 'users']);
        if (request()->filled('modal')) {
            return view('roles._show_modal', compact('role'));
        }
        return view('roles.show', compact('role'));
    }

    public function edit(Role $role)
    {
        if (request()->ajax() || request()->filled('modal')) {
            return view('roles._form', compact('role'));
        }
        return view('roles.edit', compact('role'));
    }

    public function update(Request $request, Role $role)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:100|unique:roles,name,' . $role->id,
            'description' => 'nullable|string',
        ]);
        $role->update($validated);
        if ($request->ajax() || $request->wantsJson()) {
            return response()->json(['success' => true, 'message' => 'Role updated.']);
        }
        return redirect()->route('roles.index')->with('success', 'Role updated.');
    }

    public function destroy(Request $request, Role $role)
    {
        $role->delete();
        if ($request->ajax() || $request->wantsJson()) {
            return response()->json(['success' => true, 'message' => 'Role deleted.']);
        }
        return redirect()->route('roles.index')->with('success', 'Role deleted.');
    }
}
