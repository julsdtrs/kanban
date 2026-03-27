<?php

namespace App\Http\Controllers;

use App\Models\Project;
use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ProjectMemberController extends Controller
{
    public function index(Request $request)
    {
        $perPage = max(10, min(100, (int) $request->input('per_page', 10)));
        $query = DB::table('project_members')
            ->join('projects', 'project_members.project_id', '=', 'projects.id')
            ->join('users', 'project_members.user_id', '=', 'users.id')
            ->join('roles', 'project_members.role_id', '=', 'roles.id')
            ->select('project_members.*', 'projects.name as project_name', 'users.username', 'users.display_name', 'roles.name as role_name');
        if ($request->filled('project_id')) {
            $query->where('project_members.project_id', $request->project_id);
        }
        if ($request->filled('q')) {
            $term = trim((string) $request->input('q'));
            $query->where(function ($q) use ($term) {
                $q->where('projects.name', 'like', "%{$term}%")
                    ->orWhere('users.display_name', 'like', "%{$term}%")
                    ->orWhere('users.username', 'like', "%{$term}%")
                    ->orWhere('roles.name', 'like', "%{$term}%");
            });
        }
        $items = $query->paginate($perPage);
        $projects = Project::where('is_active', true)->orderBy('name')->get();
        if ($request->filled('partial')) {
            return view('project-members._table', compact('items', 'projects'));
        }
        return view('project-members.index', compact('items', 'projects'));
    }

    public function create(Request $request)
    {
        $item = null;
        $projectId = null;
        $userId = null;
        $projects = Project::where('is_active', true)->orderBy('name')->get();
        $users = User::where('is_active', true)->orderBy('display_name')->get();
        $roles = Role::orderBy('name')->get();
        if ($request->ajax() || $request->filled('modal')) {
            return view('project-members._form', compact('item', 'projects', 'users', 'roles', 'projectId', 'userId'));
        }
        return view('project-members.create', compact('projects', 'users', 'roles'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'project_id' => 'required|exists:projects,id',
            'user_id' => 'required|exists:users,id',
            'role_id' => 'required|exists:roles,id',
        ]);
        DB::table('project_members')->updateOrInsert(
            ['project_id' => $validated['project_id'], 'user_id' => $validated['user_id']],
            ['role_id' => $validated['role_id']]
        );
        if ($request->ajax() || $request->wantsJson()) {
            return response()->json(['success' => true, 'message' => 'Project member added.']);
        }
        return redirect()->route('project-members.index')->with('success', 'Project member added.');
    }

    public function edit(Request $request, string $projectMember)
    {
        [$projectId, $userId] = explode('-', $projectMember);
        $item = DB::table('project_members')->where('project_id', $projectId)->where('user_id', $userId)->first();
        if (!$item) {
            abort(404);
        }
        $projects = Project::where('is_active', true)->orderBy('name')->get();
        $users = User::where('is_active', true)->orderBy('display_name')->get();
        $roles = Role::orderBy('name')->get();
        if ($request->ajax() || $request->filled('modal')) {
            return view('project-members._form', compact('item', 'projects', 'users', 'roles', 'projectId', 'userId'));
        }
        return view('project-members.edit', compact('item', 'projects', 'users', 'roles', 'projectId', 'userId'));
    }

    public function update(Request $request, string $projectMember)
    {
        [$projectId, $userId] = explode('-', $projectMember);
        $validated = $request->validate([
            'project_id' => 'required|exists:projects,id',
            'user_id' => 'required|exists:users,id',
            'role_id' => 'required|exists:roles,id',
        ]);
        DB::table('project_members')->where('project_id', $projectId)->where('user_id', $userId)->delete();
        DB::table('project_members')->insert($validated);
        if ($request->ajax() || $request->wantsJson()) {
            return response()->json(['success' => true, 'message' => 'Project member updated.']);
        }
        return redirect()->route('project-members.index')->with('success', 'Project member updated.');
    }

    public function destroy(Request $request, string $projectMember)
    {
        [$projectId, $userId] = explode('-', $projectMember);
        DB::table('project_members')->where('project_id', $projectId)->where('user_id', $userId)->delete();
        if ($request->ajax() || $request->wantsJson()) {
            return response()->json(['success' => true, 'message' => 'Project member removed.']);
        }
        return redirect()->route('project-members.index')->with('success', 'Project member removed.');
    }
}
