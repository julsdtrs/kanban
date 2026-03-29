<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\Issue;
use App\Models\User;
use Illuminate\View\View;

class ProfileController extends Controller
{
    public function show(): View
    {
        $user = auth()->user();
        $user->load([
            'roles',
            'teams' => fn ($q) => $q->withCount('members'),
            'projectMemberships',
        ]);

        $teamIds = $user->teams->pluck('id');

        $connectionUsers = collect();
        if ($teamIds->isNotEmpty()) {
            $connectionUsers = User::query()
                ->where('id', '!=', $user->id)
                ->whereHas('teams', fn ($q) => $q->whereIn('teams.id', $teamIds))
                ->with(['teams' => fn ($q) => $q->whereIn('teams.id', $teamIds)])
                ->withCount([
                    'teams' => fn ($q) => $q->whereIn('teams.id', $teamIds),
                ])
                ->orderBy('username')
                ->take(8)
                ->get();
        }

        $timeline = collect();
        foreach (Comment::query()->where('user_id', $user->id)->with(['issue.project', 'issue.status'])->latest()->take(6)->get() as $comment) {
            $timeline->push(['kind' => 'comment', 'at' => $comment->created_at, 'comment' => $comment]);
        }
        foreach (Issue::query()
            ->where(function ($q) use ($user) {
                $q->where('assignee_id', $user->id)->orWhere('reporter_id', $user->id);
            })
            ->with(['project', 'status'])
            ->latest('updated_at')
            ->take(8)
            ->get() as $issue) {
            $timeline->push(['kind' => 'issue', 'at' => $issue->updated_at, 'issue' => $issue]);
        }

        $timeline = $timeline
            ->sortByDesc('at')
            ->unique(fn (array $item) => $item['kind'] === 'comment' ? 'c-'.$item['comment']->id : 'i-'.$item['issue']->id)
            ->take(10)
            ->values();

        $assignedTotal = Issue::where('assignee_id', $user->id)->count();
        $assignedResolved = Issue::where('assignee_id', $user->id)
            ->whereHas('status', fn ($q) => $q->where('category', 'done'))
            ->count();
        $assignedPending = max(0, $assignedTotal - $assignedResolved);

        $stats = [
            'teams' => $user->teams->count(),
            'projects' => $user->projectMemberships->count(),
            'assigned' => $assignedTotal,
            'assigned_resolved' => $assignedResolved,
            'assigned_pending' => $assignedPending,
            'reported' => $user->reportedIssues()->count(),
            'comments' => $user->comments()->count(),
        ];

        return view('profile.show', [
            'user' => $user,
            'connectionUsers' => $connectionUsers,
            'timeline' => $timeline,
            'stats' => $stats,
        ]);
    }
}
