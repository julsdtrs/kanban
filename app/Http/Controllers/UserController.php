<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index(Request $request)
    {
        $perPage = max(10, min(100, (int) $request->input('per_page', 10)));
        $query = User::query();
        if ($request->filled('q')) {
            $term = trim((string) $request->input('q'));
            $query->where(function ($q) use ($term) {
                $q->where('username', 'like', "%{$term}%")
                    ->orWhere('email', 'like', "%{$term}%")
                    ->orWhere('display_name', 'like', "%{$term}%");
            });
        }
        $users = $query->latest('id')->paginate($perPage);
        if ($request->filled('partial')) {
            return view('users._table', compact('users'));
        }
        return view('users.index', compact('users'));
    }

    public function create(Request $request)
    {
        $user = null;
        if ($request->ajax() || $request->filled('modal')) {
            return view('users._form', compact('user'));
        }
        return view('users.create', compact('user'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'username' => 'required|string|max:100|unique:users,username',
            'email' => 'required|string|email|max:150|unique:users,email',
            'password' => 'required|string|min:8',
            'display_name' => 'nullable|string|max:150',
            'avatar' => 'nullable|string|max:255',
            'is_active' => 'nullable',
        ]);
        $user = new User();
        $user->username = $validated['username'];
        $user->email = $validated['email'];
        $user->display_name = $validated['display_name'] ?? null;
        $user->avatar = $validated['avatar'] ?? null;
        $user->is_active = $request->boolean('is_active', true);
        $user->password = $validated['password'];
        $user->save();
        if ($request->ajax() || $request->wantsJson()) {
            return response()->json(['success' => true, 'message' => 'User created.']);
        }
        return redirect()->route('users.index')->with('success', 'User created.');
    }

    public function show(User $user)
    {
        if (request()->filled('modal')) {
            return view('users._show_modal', compact('user'));
        }
        return view('users.show', compact('user'));
    }

    public function edit(User $user)
    {
        if (request()->ajax() || request()->filled('modal')) {
            return view('users._form', compact('user'));
        }
        return view('users.edit', compact('user'));
    }

    public function update(Request $request, User $user)
    {
        $validated = $request->validate([
            'username' => 'required|string|max:100|unique:users,username,' . $user->id,
            'email' => 'required|string|email|max:150|unique:users,email,' . $user->id,
            'password' => 'nullable|string|min:8',
            'display_name' => 'nullable|string|max:150',
            'avatar' => 'nullable|string|max:255',
            'is_active' => 'nullable',
        ]);
        $user->username = $validated['username'];
        $user->email = $validated['email'];
        $user->display_name = $validated['display_name'] ?? null;
        $user->avatar = $validated['avatar'] ?? null;
        $user->is_active = $request->boolean('is_active', true);
        if (!empty($validated['password'])) {
            $user->password = $validated['password'];
        }
        $user->save();
        if ($request->ajax() || $request->wantsJson()) {
            return response()->json(['success' => true, 'message' => 'User updated.']);
        }
        return redirect()->route('users.index')->with('success', 'User updated.');
    }

    public function destroy(Request $request, User $user)
    {
        $user->delete();
        if ($request->ajax() || $request->wantsJson()) {
            return response()->json(['success' => true, 'message' => 'User deleted.']);
        }
        return redirect()->route('users.index')->with('success', 'User deleted.');
    }
}
