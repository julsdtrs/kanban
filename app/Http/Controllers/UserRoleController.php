<?php

namespace App\Http\Controllers;

use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class UserRoleController extends Controller
{
    public function index(Request $request)
    {
        $perPage = max(10, min(100, (int) $request->input('per_page', 10)));
        $query = DB::table('user_roles')
            ->join('users', 'user_roles.user_id', '=', 'users.id')
            ->join('roles', 'user_roles.role_id', '=', 'roles.id')
            ->select('user_roles.*', 'users.username', 'users.display_name', 'roles.name as role_name');
        if ($request->filled('user_id')) {
            $query->where('user_roles.user_id', $request->user_id);
        }
        if ($request->filled('q')) {
            $term = trim((string) $request->input('q'));
            $query->where(function ($q) use ($term) {
                $q->where('users.display_name', 'like', "%{$term}%")
                    ->orWhere('users.username', 'like', "%{$term}%")
                    ->orWhere('roles.name', 'like', "%{$term}%");
            });
        }
        $items = $query->paginate($perPage);
        $users = User::where('is_active', true)->orderBy('username')->get();
        if ($request->filled('partial')) {
            return view('user-roles._table', compact('items', 'users'));
        }
        return view('user-roles.index', compact('items', 'users'));
    }

    public function create(Request $request)
    {
        $item = null;
        $userId = null;
        $roleId = null;
        $users = User::where('is_active', true)->orderBy('username')->get();
        $roles = Role::orderBy('name')->get();
        if ($request->ajax() || $request->filled('modal')) {
            return view('user-roles._form', compact('item', 'users', 'roles', 'userId', 'roleId'));
        }
        return view('user-roles.create', compact('users', 'roles'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'user_id' => 'required|exists:users,id',
            'role_id' => 'required|exists:roles,id',
        ]);
        $exists = DB::table('user_roles')
            ->where('user_id', $validated['user_id'])
            ->where('role_id', $validated['role_id'])
            ->exists();
        if ($exists) {
            if ($request->ajax() || $request->wantsJson()) {
                return response()->json(['success' => false, 'message' => 'This user already has this role.'], 422);
            }
            return back()->withErrors(['role_id' => 'This user already has this role.'])->withInput();
        }
        DB::table('user_roles')->insert($validated);
        if ($request->ajax() || $request->wantsJson()) {
            return response()->json(['success' => true, 'message' => 'User role assigned.']);
        }
        return redirect()->route('user-roles.index')->with('success', 'User role assigned.');
    }

    public function edit(Request $request, string $userRole)
    {
        [$userId, $roleId] = explode('-', $userRole);
        $item = DB::table('user_roles')->where('user_id', $userId)->where('role_id', $roleId)->first();
        if (!$item) {
            abort(404);
        }
        $users = User::where('is_active', true)->orderBy('username')->get();
        $roles = Role::orderBy('name')->get();
        if ($request->ajax() || $request->filled('modal')) {
            return view('user-roles._form', compact('item', 'users', 'roles', 'userId', 'roleId'));
        }
        return view('user-roles.edit', compact('item', 'users', 'roles', 'userId', 'roleId'));
    }

    public function update(Request $request, string $userRole)
    {
        [$userId, $roleId] = explode('-', $userRole);
        $validated = $request->validate([
            'user_id' => 'required|exists:users,id',
            'role_id' => 'required|exists:roles,id',
        ]);
        DB::table('user_roles')->where('user_id', $userId)->where('role_id', $roleId)->delete();
        DB::table('user_roles')->insert($validated);
        if ($request->ajax() || $request->wantsJson()) {
            return response()->json(['success' => true, 'message' => 'User role updated.']);
        }
        return redirect()->route('user-roles.index')->with('success', 'User role updated.');
    }

    public function destroy(Request $request, string $userRole)
    {
        [$userId, $roleId] = explode('-', $userRole);
        DB::table('user_roles')->where('user_id', $userId)->where('role_id', $roleId)->delete();
        if ($request->ajax() || $request->wantsJson()) {
            return response()->json(['success' => true, 'message' => 'User role removed.']);
        }
        return redirect()->route('user-roles.index')->with('success', 'User role removed.');
    }
}
