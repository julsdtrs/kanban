<?php

namespace App\Http\Controllers;

use App\Models\Team;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TeamMemberController extends Controller
{
    public function index(Request $request)
    {
        $perPage = max(10, min(100, (int) $request->input('per_page', 10)));
        $query = DB::table('team_members')
            ->join('teams', 'team_members.team_id', '=', 'teams.id')
            ->join('users', 'team_members.user_id', '=', 'users.id')
            ->select('team_members.*', 'teams.name as team_name', 'users.display_name', 'users.username');
        if ($request->filled('team_id')) {
            $query->where('team_members.team_id', $request->team_id);
        }
        if ($request->filled('q')) {
            $term = trim((string) $request->input('q'));
            $query->where(function ($q) use ($term) {
                $q->where('teams.name', 'like', "%{$term}%")
                    ->orWhere('users.display_name', 'like', "%{$term}%")
                    ->orWhere('users.username', 'like', "%{$term}%")
                    ->orWhere('team_members.role_in_team', 'like', "%{$term}%");
            });
        }
        $members = $query->paginate($perPage);
        $teams = Team::orderBy('name')->get();
        if ($request->filled('partial')) {
            return view('team-members._table', compact('members', 'teams'));
        }
        return view('team-members.index', compact('members', 'teams'));
    }

    public function create(Request $request)
    {
        $member = null;
        $teamId = null;
        $userId = null;
        $teams = Team::orderBy('name')->get();
        $users = User::where('is_active', true)->orderBy('display_name')->get();
        if ($request->ajax() || $request->filled('modal')) {
            return view('team-members._form', compact('member', 'teams', 'users', 'teamId', 'userId'));
        }
        return view('team-members.create', compact('teams', 'users'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'team_id' => 'required|exists:teams,id',
            'user_id' => 'required|exists:users,id',
            'role_in_team' => 'nullable|string|max:100',
        ], [], [
            'team_id' => 'team',
            'user_id' => 'user',
        ]);
        $exists = DB::table('team_members')
            ->where('team_id', $validated['team_id'])
            ->where('user_id', $validated['user_id'])
            ->exists();
        if ($exists) {
            if ($request->ajax() || $request->wantsJson()) {
                return response()->json(['success' => false, 'message' => 'This user is already in the team.'], 422);
            }
            return back()->withErrors(['user_id' => 'This user is already in the team.'])->withInput();
        }
        DB::table('team_members')->insert([
            'team_id' => $validated['team_id'],
            'user_id' => $validated['user_id'],
            'role_in_team' => $validated['role_in_team'] ?? null,
        ]);
        if ($request->ajax() || $request->wantsJson()) {
            return response()->json(['success' => true, 'message' => 'Team member added.']);
        }
        return redirect()->route('team-members.index')->with('success', 'Team member added.');
    }

    public function edit(Request $request, string $teamMember)
    {
        [$teamId, $userId] = explode('-', $teamMember);
        $member = DB::table('team_members')->where('team_id', $teamId)->where('user_id', $userId)->first();
        if (!$member) {
            abort(404);
        }
        $teams = Team::orderBy('name')->get();
        $users = User::where('is_active', true)->orderBy('display_name')->get();
        if ($request->ajax() || $request->filled('modal')) {
            return view('team-members._form', compact('member', 'teams', 'users', 'teamId', 'userId'));
        }
        return view('team-members.edit', compact('member', 'teams', 'users', 'teamId', 'userId'));
    }

    public function update(Request $request, string $teamMember)
    {
        [$teamId, $userId] = explode('-', $teamMember);
        $validated = $request->validate([
            'team_id' => 'required|exists:teams,id',
            'user_id' => 'required|exists:users,id',
            'role_in_team' => 'nullable|string|max:100',
        ]);
        DB::table('team_members')->where('team_id', $teamId)->where('user_id', $userId)->delete();
        DB::table('team_members')->insert([
            'team_id' => $validated['team_id'],
            'user_id' => $validated['user_id'],
            'role_in_team' => $validated['role_in_team'] ?? null,
        ]);
        if ($request->ajax() || $request->wantsJson()) {
            return response()->json(['success' => true, 'message' => 'Team member updated.']);
        }
        return redirect()->route('team-members.index')->with('success', 'Team member updated.');
    }

    public function destroy(Request $request, string $teamMember)
    {
        [$teamId, $userId] = explode('-', $teamMember);
        DB::table('team_members')->where('team_id', $teamId)->where('user_id', $userId)->delete();
        if ($request->ajax() || $request->wantsJson()) {
            return response()->json(['success' => true, 'message' => 'Team member removed.']);
        }
        return redirect()->route('team-members.index')->with('success', 'Team member removed.');
    }
}
