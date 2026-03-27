<?php

namespace App\Http\Controllers;

use App\Models\Permission;
use App\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class RolePermissionController extends Controller
{
    public function index(Request $request)
    {
        $perPage = max(10, min(100, (int) $request->input('per_page', 10)));
        $query = DB::table('role_permissions')
            ->join('roles', 'role_permissions.role_id', '=', 'roles.id')
            ->join('permissions', 'role_permissions.permission_id', '=', 'permissions.id')
            ->select('role_permissions.*', 'roles.name as role_name', 'permissions.code as permission_code');
        if ($request->filled('role_id')) {
            $query->where('role_permissions.role_id', $request->role_id);
        }
        if ($request->filled('q')) {
            $term = trim((string) $request->input('q'));
            $query->where(function ($q) use ($term) {
                $q->where('roles.name', 'like', "%{$term}%")
                    ->orWhere('permissions.code', 'like', "%{$term}%");
            });
        }
        $items = $query->paginate($perPage);
        $roles = Role::orderBy('name')->get();
        if ($request->filled('partial')) {
            return view('role-permissions._table', compact('items', 'roles'));
        }
        return view('role-permissions.index', compact('items', 'roles'));
    }

    public function create(Request $request)
    {
        $item = null;
        $roles = Role::orderBy('name')->get();
        $permissions = Permission::orderBy('code')->get();
        if ($request->ajax() || $request->filled('modal')) {
            return view('role-permissions._form', compact('item', 'roles', 'permissions'));
        }
        return view('role-permissions.create', compact('roles', 'permissions'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'role_id' => 'required|exists:roles,id',
            'permission_id' => 'required|exists:permissions,id',
        ]);
        $exists = DB::table('role_permissions')
            ->where('role_id', $validated['role_id'])
            ->where('permission_id', $validated['permission_id'])
            ->exists();
        if ($exists) {
            if ($request->ajax() || $request->wantsJson()) {
                return response()->json(['success' => false, 'message' => 'This role already has this permission.'], 422);
            }
            return back()->withErrors(['permission_id' => 'This role already has this permission.'])->withInput();
        }
        DB::table('role_permissions')->insert($validated);
        if ($request->ajax() || $request->wantsJson()) {
            return response()->json(['success' => true, 'message' => 'Role permission added.']);
        }
        return redirect()->route('role-permissions.index')->with('success', 'Role permission added.');
    }

    public function edit(Request $request, string $rolePermission)
    {
        [$roleId, $permissionId] = explode('-', $rolePermission);
        $item = DB::table('role_permissions')->where('role_id', $roleId)->where('permission_id', $permissionId)->first();
        if (!$item) {
            abort(404);
        }
        $roles = Role::orderBy('name')->get();
        $permissions = Permission::orderBy('code')->get();
        if ($request->ajax() || $request->filled('modal')) {
            return view('role-permissions._form', compact('item', 'roles', 'permissions', 'roleId', 'permissionId'));
        }
        return view('role-permissions.edit', compact('item', 'roles', 'permissions', 'roleId', 'permissionId'));
    }

    public function update(Request $request, string $rolePermission)
    {
        [$roleId, $permissionId] = explode('-', $rolePermission);
        $validated = $request->validate([
            'role_id' => 'required|exists:roles,id',
            'permission_id' => 'required|exists:permissions,id',
        ]);
        DB::table('role_permissions')->where('role_id', $roleId)->where('permission_id', $permissionId)->delete();
        DB::table('role_permissions')->insert($validated);
        if ($request->ajax() || $request->wantsJson()) {
            return response()->json(['success' => true, 'message' => 'Role permission updated.']);
        }
        return redirect()->route('role-permissions.index')->with('success', 'Role permission updated.');
    }

    public function destroy(Request $request, string $rolePermission)
    {
        [$roleId, $permissionId] = explode('-', $rolePermission);
        DB::table('role_permissions')->where('role_id', $roleId)->where('permission_id', $permissionId)->delete();
        if ($request->ajax() || $request->wantsJson()) {
            return response()->json(['success' => true, 'message' => 'Role permission removed.']);
        }
        return redirect()->route('role-permissions.index')->with('success', 'Role permission removed.');
    }
}
