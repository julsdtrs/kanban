<?php

namespace App\Http\Controllers;

use App\Models\Issue;
use App\Models\Priority;
use App\Models\Project;
use App\Models\Status;
use App\Models\User;
use Illuminate\Http\Request;

use App\Http\Controllers\KanbanController;

class DashboardController extends Controller
{
    public function index()
    {
        $today = now()->startOfDay();
        $todayDate = $today->toDateString();
        $endOfWeek = now()->endOfWeek()->toDateString();
        $startOfWeek = now()->startOfWeek()->toDateString();

        $stats = [
            'projects' => Project::count(),
            'active_projects' => Project::where('is_active', true)->count(),
            'issues' => Issue::count(),
            'my_issues' => Issue::where('assignee_id', auth()->id())->count(),
            'open_issues' => Issue::whereNull('status_id')->count(),
            'created_today' => Issue::where('created_at', '>=', $today)->count(),
            'updated_today' => Issue::where('updated_at', '>=', $today)->count(),
            'unassigned_issues' => Issue::whereNull('assignee_id')->count(),
            'issues_due_today' => Issue::whereDate('due_date', $todayDate)->count(),
            'overdue_issues' => Issue::whereNotNull('due_date')
                ->where('due_date', '<', $todayDate)
                ->count(),
            'my_open_issues' => Issue::where('assignee_id', auth()->id())
                ->whereNull('status_id')
                ->count(),
            'issues_due_this_week' => Issue::whereNotNull('due_date')
                ->whereBetween('due_date', [$todayDate, $endOfWeek])
                ->count(),
            'resolved_this_week' => Issue::whereHas('status', fn ($q) => $q->where('category', 'done'))
                ->where('updated_at', '>=', $startOfWeek)
                ->count(),
            'issues_needing_attention' => Issue::whereNull('assignee_id')->count()
                + Issue::whereNotNull('due_date')->where('due_date', '<', $todayDate)->count(),
        ];

        // Project with the most issues (overall)
        $topProjectIssue = Issue::selectRaw('project_id, COUNT(*) as issue_count')
            ->whereNotNull('project_id')
            ->groupBy('project_id')
            ->orderByDesc('issue_count')
            ->first();
        $topProject = null;
        $topProjectIssueCount = 0;
        if ($topProjectIssue) {
            $topProject = Project::select('id', 'name', 'project_key')
                ->find($topProjectIssue->project_id);
            $topProjectIssueCount = (int) ($topProjectIssue->issue_count ?? 0);
        }
        $recentIssues = Issue::with(['project:id,name,project_key', 'status:id,name,color', 'assignee:id,username,display_name'])
            ->latest()
            ->take(10)
            ->get();

        $userIssueStats = User::query()
            ->withCount('assignedIssues')
            ->orderByDesc('assigned_issues_count')
            ->limit(25)
            ->get(['id', 'username', 'display_name'])
            ->filter(fn ($u) => $u->assigned_issues_count > 0)
            ->values();
        $maxIssues = $userIssueStats->max('assigned_issues_count') ?: 1;

        // Top projects by issue count (for graph)
        $projectIssueStats = Project::query()
            ->withCount('issues')
            ->orderByDesc('issues_count')
            ->limit(10)
            ->get(['id', 'name', 'project_key'])
            ->filter(fn ($p) => $p->issues_count > 0)
            ->values();

        $projects = Project::where('is_active', true)->orderBy('name')->get(['id', 'name', 'project_key']);
        $initialProject = $projects->first();
        $boardStats = $initialProject
            ? app(KanbanController::class)->boardStats($initialProject)
            : ['total' => 0, 'segments' => [['label' => 'Open issues', 'count' => 0, 'percentage' => 0, 'color' => '#6c757d']]];
        $initialProjectId = $initialProject?->id;

        // Global status and priority breakdowns
        $statusDistribution = Status::withCount('issues')
            ->orderBy('order_no')
            ->get(['id', 'name', 'category', 'color']);

        $priorityDistribution = Priority::withCount('issues')
            ->orderByDesc('level')
            ->get(['id', 'name', 'level', 'color']);

        return view('dashboard', compact(
            'stats',
            'recentIssues',
            'userIssueStats',
            'maxIssues',
            'projects',
            'boardStats',
            'initialProjectId',
            'topProject',
            'topProjectIssueCount',
            'projectIssueStats',
            'statusDistribution',
            'priorityDistribution'
        ));
    }

    public function boardStatsContent(Project $project)
    {
        $boardStats = app(KanbanController::class)->boardStats($project);
        return view('dashboard._board_stats_content', compact('boardStats'));
    }
}
