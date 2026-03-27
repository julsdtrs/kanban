@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
@php
    $todayLabel = now()->format('D, M d');
    $overdueDeltaClass = ($stats['overdue_issues'] ?? 0) > 0 ? 'text-danger' : 'text-success';
@endphp
<div class="dashboard-page dashboard-sneat">
    <div class="dashboard-page-header">
        <div>
            <div class="dashboard-page-title">Operations Dashboard</div>
            <div class="dashboard-page-subtitle">
                Delivery health, issue flow, and assignment balance for {{ $todayLabel }}.
            </div>
        </div>
        <div class="d-flex flex-wrap gap-2">
            <a href="{{ route('kanban.index') }}" class="btn btn-sm btn-primary">
                <i class="bi bi-kanban me-1"></i> Open Kanban board
            </a>
            <a href="{{ route('issues.create') }}" class="btn btn-sm btn-outline-secondary">
                <i class="bi bi-plus-circle me-1"></i> New issue
            </a>
        </div>
    </div>

    {{-- Row 1: Work overview (project/issue summary) + monitoring KPIs --}}
    <div class="row g-2 g-lg-3 mb-3">
        <div class="col-lg-7 col-12">
            <div class="card dashboard-overview dashboard-panel h-100">
                <div class="card-body">
                    <div class="overview-title">Work overview</div>
                    <div class="overview-stats">
                        <div><span class="overview-stat">{{ $stats['issues'] }}</span><div class="overview-stat-label">Total issues</div></div>
                        <div><span class="overview-stat">{{ $stats['my_issues'] }}</span><div class="overview-stat-label">Assigned to me</div></div>
                        @if($stats['overdue_issues'] > 0)<div><span class="overview-stat">{{ $stats['overdue_issues'] }}</span><div class="overview-stat-label">Overdue</div></div>@endif
                        @if(($stats['issues_needing_attention'] ?? 0) > 0)<div><span class="overview-stat">{{ $stats['issues_needing_attention'] }}</span><div class="overview-stat-label">Need attention</div></div>@endif
                    </div>
                    <div class="overview-meta mb-2">
                        <span>Active projects: {{ $stats['active_projects'] }}</span>
                        <span>Unassigned: {{ $stats['unassigned_issues'] }}</span>
                        <span>Due today: {{ $stats['issues_due_today'] }}</span>
                    </div>
                    <div class="d-flex flex-wrap gap-2 mb-1">
                        <a href="{{ route('kanban.index') }}" class="btn btn-overview"><i class="bi bi-kanban me-1"></i> Kanban</a>
                        <a href="{{ route('issues.index') }}" class="btn btn-overview"><i class="bi bi-ticket-perforated me-1"></i> All issues</a>
                        <a href="{{ route('issues.create') }}" class="btn btn-overview"><i class="bi bi-plus-lg me-1"></i> New issue</a>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-5">
            <div class="row g-2 h-100">
                <div class="col-6 col-lg-12">
                    <div class="card dashboard-kpi dashboard-panel h-100">
                        <div class="card-body d-flex align-items-center">
                            <div class="kpi-icon bg-primary bg-opacity-10 text-primary me-2"><i class="bi bi-folder"></i></div>
                            <div class="min-w-0">
                                <div class="text-muted small text-uppercase tracking">Projects</div>
                                <div class="fs-5 fw-semibold text-body">{{ $stats['projects'] }}</div>
                                <div class="kpi-secondary">Active: {{ $stats['active_projects'] }}</div>
                            </div>
                            <a href="{{ route('projects.index') }}" class="btn btn-link btn-sm p-0 ms-auto text-decoration-none">View</a>
                        </div>
                    </div>
                </div>
                <div class="col-6 col-lg-12">
                    <div class="card dashboard-kpi dashboard-panel h-100">
                        <div class="card-body d-flex align-items-center">
                            <div class="kpi-icon bg-success bg-opacity-10 text-success me-2"><i class="bi bi-ticket-perforated"></i></div>
                            <div class="min-w-0">
                                <div class="text-muted small text-uppercase tracking">Total issues</div>
                                <div class="fs-5 fw-semibold text-body">{{ $stats['issues'] }}</div>
                                <div class="kpi-secondary">Unassigned: {{ $stats['unassigned_issues'] }}</div>
                            </div>
                            <a href="{{ route('issues.index') }}" class="btn btn-link btn-sm p-0 ms-auto text-decoration-none">View</a>
                        </div>
                    </div>
                </div>
                <div class="col-6 col-lg-12">
                    <div class="card dashboard-kpi dashboard-panel h-100">
                        <div class="card-body d-flex align-items-center">
                            <div class="kpi-icon bg-info bg-opacity-10 text-info me-2"><i class="bi bi-person"></i></div>
                            <div class="min-w-0">
                                <div class="text-muted small text-uppercase tracking">My issues</div>
                                <div class="fs-5 fw-semibold text-body">{{ $stats['my_issues'] }}</div>
                                <div class="kpi-secondary">Open (no status): {{ $stats['my_open_issues'] }}</div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-6 col-lg-12">
                    <div class="card dashboard-kpi dashboard-panel h-100">
                        <div class="card-body d-flex align-items-center">
                            <div class="kpi-icon bg-danger bg-opacity-10 text-danger me-2"><i class="bi bi-exclamation-triangle"></i></div>
                            <div class="min-w-0">
                                <div class="text-muted small text-uppercase tracking">Attention needed</div>
                                <div class="fs-5 fw-semibold text-body">{{ $stats['overdue_issues'] }}</div>
                                <div class="kpi-secondary"><span class="{{ $overdueDeltaClass }}">Overdue</span> · Due today: {{ $stats['issues_due_today'] }}</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Row 2: Activity & deadlines (monitor project/issue health) --}}
    <div class="row g-2 mb-3">
        <div class="col-12">
            <div class="card dashboard-card dashboard-panel">
                <div class="card-header">
                    <span><i class="bi bi-activity me-2"></i>Activity &amp; deadlines</span>
                    <span class="subtitle d-none d-sm-inline">Monitor issues and project workload</span>
                </div>
                <div class="card-body py-2">
                    <div class="row g-2">
                        <div class="col-6 col-sm-4 col-lg-2">
                            <div class="d-flex align-items-center dashboard-activity-tile rounded-3 bg-primary bg-opacity-10">
                                <div class="flex-shrink-0 me-2"><i class="bi bi-plus-circle text-primary fs-5"></i></div>
                                <div>
                                    <div class="small text-muted">Created today</div>
                                    <div class="fs-5 fw-bold text-primary">{{ $stats['created_today'] ?? 0 }}</div>
                                </div>
                            </div>
                        </div>
                        <div class="col-6 col-sm-4 col-lg-2">
                            <div class="d-flex align-items-center dashboard-activity-tile rounded-3 bg-info bg-opacity-10">
                                <div class="flex-shrink-0 me-2"><i class="bi bi-pencil-square text-info fs-5"></i></div>
                                <div>
                                    <div class="small text-muted">Updated today</div>
                                    <div class="fs-5 fw-bold text-info">{{ $stats['updated_today'] ?? 0 }}</div>
                                </div>
                            </div>
                        </div>
                        <div class="col-6 col-sm-4 col-lg-2">
                            <div class="d-flex align-items-center dashboard-activity-tile rounded-3 bg-success bg-opacity-10">
                                <div class="flex-shrink-0 me-2"><i class="bi bi-check2-circle text-success fs-5"></i></div>
                                <div>
                                    <div class="small text-muted">Resolved this week</div>
                                    <div class="fs-5 fw-bold text-success">{{ $stats['resolved_this_week'] ?? 0 }}</div>
                                </div>
                            </div>
                        </div>
                        <div class="col-6 col-sm-4 col-lg-2">
                            <div class="d-flex align-items-center dashboard-activity-tile rounded-3 bg-warning bg-opacity-10">
                                <div class="flex-shrink-0 me-2"><i class="bi bi-calendar-event text-warning fs-5"></i></div>
                                <div>
                                    <div class="small text-muted">Due today</div>
                                    <div class="fs-5 fw-bold text-warning">{{ $stats['issues_due_today'] ?? 0 }}</div>
                                </div>
                            </div>
                        </div>
                        <div class="col-6 col-sm-4 col-lg-2">
                            <div class="d-flex align-items-center dashboard-activity-tile rounded-3 bg-danger bg-opacity-10">
                                <div class="flex-shrink-0 me-2"><i class="bi bi-exclamation-triangle text-danger fs-5"></i></div>
                                <div>
                                    <div class="small text-muted">Overdue</div>
                                    <div class="fs-5 fw-bold text-danger">{{ $stats['overdue_issues'] ?? 0 }}</div>
                                </div>
                            </div>
                        </div>
                        <div class="col-6 col-sm-4 col-lg-2">
                            <div class="d-flex align-items-center dashboard-activity-tile rounded-3 bg-secondary bg-opacity-10">
                                <div class="flex-shrink-0 me-2"><i class="bi bi-calendar-week text-secondary fs-5"></i></div>
                                <div>
                                    <div class="small text-muted">Due this week</div>
                                    <div class="fs-5 fw-bold text-secondary">{{ $stats['issues_due_this_week'] ?? 0 }}</div>
                                </div>
                            </div>
                        </div>
                        <div class="col-12 col-lg-12 mt-1">
                            <div class="d-flex align-items-center dashboard-activity-tile rounded-3 bg-light">
                                <div class="flex-shrink-0 me-2"><i class="bi bi-bar-chart-line text-body-secondary fs-5"></i></div>
                                <div class="min-w-0">
                                    <div class="small text-muted">Project with most issues</div>
                                    @if(isset($topProject) && $topProject)
                                        <a href="{{ route('projects.show', $topProject) }}" class="fw-semibold text-decoration-none">{{ $topProject->name }}</a>
                                        <span class="small text-muted"> · {{ $topProject->project_key ?? '' }} · {{ $topProjectIssueCount }} issue{{ $topProjectIssueCount === 1 ? '' : 's' }}</span>
                                    @else
                                        <span class="fw-semibold">No issues yet</span>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Row 3: Tickets by user + Board statistics --}}
    <div class="row g-2 g-lg-3 mb-3">
        <div class="col-lg-7">
            <div class="card dashboard-card dashboard-panel h-100">
                <div class="card-header d-flex align-items-center justify-content-between">
                    <div>
                        <span>Tickets by user</span>
                        <span class="subtitle d-none d-sm-inline">Who currently owns the most work</span>
                    </div>
                    <div class="dropdown">
                        <button class="btn btn-link text-body p-0 border-0" type="button" data-bs-toggle="dropdown" aria-label="Tickets by user quick actions"><i class="bi bi-three-dots-vertical"></i></button>
                        <ul class="dropdown-menu dropdown-menu-end"><li><a class="dropdown-item" href="{{ route('issues.index') }}">View all issues</a></li></ul>
                    </div>
                </div>
                <div class="card-body">
                    <div class="dashboard-chart-container">
                        <canvas id="dashboardBarChart"></canvas>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-5">
            <div class="card dashboard-card dashboard-panel h-100">
                <div class="card-header d-flex align-items-center justify-content-between flex-wrap gap-2">
                    <div>
                        <span>Board statistics</span>
                        <span class="subtitle d-none d-sm-inline">Status breakdown for a board</span>
                    </div>
                    @if(isset($projects) && $projects->isNotEmpty())
                    <div class="dropdown">
                        <button class="btn btn-sm btn-outline-secondary dropdown-toggle" type="button" id="dashboardBoardStatsDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                            <span id="dashboard-board-stats-label">{{ $projects->first()->name ?? 'Select board' }}</span>
                            <span class="badge bg-primary rounded-pill ms-1" id="dashboard-board-stats-key">{{ $projects->first()->project_key ?? '' }}</span>
                        </button>
                        <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="dashboardBoardStatsDropdown">
                            @foreach($projects as $p)
                            <li>
                                <a class="dashboard-board-stats-select dropdown-item d-flex justify-content-between align-items-center {{ isset($initialProjectId) && $p->id === $initialProjectId ? 'active' : '' }}" href="{{ route('dashboard.board-stats', $p) }}" data-project-id="{{ $p->id }}" data-project-name="{{ e($p->name) }}" data-project-key="{{ $p->project_key }}">
                                    <span>{{ $p->name }}</span>
                                    <span class="badge bg-primary rounded-pill">{{ $p->project_key }}</span>
                                </a>
                            </li>
                            @endforeach
                        </ul>
                    </div>
                    @endif
                </div>
                <div class="card-body" id="dashboard-board-stats-content">
                    @include('dashboard._board_stats_content')
                </div>
            </div>
        </div>
    </div>

    {{-- Row 4: Projects by issues + Status & priority overview --}}
    <div class="row g-2 g-lg-3 mb-3">
        <div class="col-lg-8">
            <div class="card dashboard-card dashboard-panel h-100">
                <div class="card-header d-flex align-items-center justify-content-between">
                    <div>
                        <span>Projects by issues</span>
                        <span class="subtitle d-none d-sm-inline">Where most tickets are concentrated</span>
                    </div>
                    <div class="dropdown">
                        <button class="btn btn-link text-body p-0 border-0" type="button" data-bs-toggle="dropdown" aria-label="Projects by issues quick actions"><i class="bi bi-three-dots-vertical"></i></button>
                        <ul class="dropdown-menu dropdown-menu-end">
                            <li><a class="dropdown-item" href="{{ route('projects.index') }}">View all projects</a></li>
                        </ul>
                    </div>
                </div>
                <div class="card-body">
                    <div class="dashboard-chart-container">
                        <canvas id="dashboardProjectIssuesChart"></canvas>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-4">
            <div class="card dashboard-card dashboard-panel h-100">
                <div class="card-header">
                    <span>Status &amp; priority overview</span>
                    <span class="subtitle d-none d-sm-inline">How work is distributed</span>
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <div class="small text-muted text-uppercase mb-2">Statuses</div>
                        @if($statusDistribution->isEmpty())
                            <div class="text-muted small">No statuses configured yet.</div>
                        @else
                            <ul class="list-unstyled small mb-0">
                                @foreach($statusDistribution as $status)
                                <li class="d-flex align-items-center justify-content-between py-1">
                                    <div class="d-flex align-items-center gap-2">
                                        <span class="d-inline-block rounded-circle" style="width: 10px; height: 10px; background: {{ $status->color ?? '#6c757d' }}"></span>
                                        <span>{{ $status->name }}</span>
                                    </div>
                                    <span class="text-muted">{{ $status->issues_count }}</span>
                                </li>
                                @endforeach
                            </ul>
                        @endif
                    </div>
                    <div>
                        <div class="small text-muted text-uppercase mb-2">Priorities</div>
                        @if($priorityDistribution->isEmpty())
                            <div class="text-muted small mb-0">No priorities configured yet.</div>
                        @else
                            <ul class="list-unstyled small mb-0">
                                @foreach($priorityDistribution as $priority)
                                <li class="d-flex align-items-center justify-content-between py-1">
                                    <div class="d-flex align-items-center gap-2">
                                        <span class="d-inline-block rounded-circle" style="width: 10px; height: 10px; background: {{ $priority->color ?? '#6c757d' }}"></span>
                                        <span>{{ $priority->name }}</span>
                                    </div>
                                    <span class="text-muted">{{ $priority->issues_count }}</span>
                                </li>
                                @endforeach
                            </ul>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Row 5: Recent issues --}}
    <div class="row g-2">
        <div class="col-12">
            <div class="card dashboard-card dashboard-panel">
                <div class="card-header d-flex align-items-center justify-content-between">
                    <span>Recent Issues</span>
                    <a href="{{ route('issues.index') }}" class="btn btn-sm btn-outline-primary">View all</a>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover align-middle mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th>Key</th>
                                    <th>Summary</th>
                                    <th>Project</th>
                                    <th>Status</th>
                                    <th>Assignee</th>
                                    <th class="text-end">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($recentIssues as $issue)
                                <tr>
                                    <td><a href="{{ route('issues.show', $issue) }}" class="text-decoration-none fw-medium">{{ $issue->issue_key }}</a></td>
                                    <td>{{ Str::limit($issue->summary, 40) }}</td>
                                    <td>{{ $issue->project->name ?? '-' }}</td>
                                    <td>@if($issue->status)<span class="badge" style="background:{{ $issue->status->color ?? '#6c757d' }}">{{ $issue->status->name }}</span>@else <span class="text-muted">Open</span> @endif</td>
                                    <td>{{ $issue->assignee->name ?? '-' }}</td>
                                    <td class="text-end"><a href="{{ route('issues.show', $issue) }}" class="btn btn-sm btn-outline-primary">View</a></td>
                                </tr>
                                @empty
                                <tr><td colspan="6" class="text-center text-muted py-4">No issues yet.</td></tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@push('styles')
<style>
.dashboard-sneat .dashboard-panel {
    border: 1px solid rgba(0,0,0,.06);
    box-shadow: 0 6px 16px -10px rgba(67, 89, 113, .35);
    transition: transform .2s ease, box-shadow .2s ease, border-color .2s ease;
    animation: dashboardCardIn .35s ease both;
}
.dashboard-sneat .dashboard-panel:hover {
    transform: translateY(-2px);
    box-shadow: 0 12px 24px -14px rgba(67, 89, 113, .45);
    border-color: rgba(105,108,255,.28);
}
.dashboard-sneat .dashboard-page-header {
    margin-bottom: .75rem;
    padding: .1rem 0 .45rem;
}
.dashboard-sneat .dashboard-page-title {
    font-size: 1.35rem;
    letter-spacing: -.015em;
}
.dashboard-sneat .dashboard-page-subtitle {
    font-size: .825rem;
}
.dashboard-sneat .dashboard-kpi .card-body {
    min-height: 84px;
}
.dashboard-sneat .dashboard-card .card-header {
    padding: .7rem 1rem;
}
.dashboard-sneat .dashboard-card .card-body {
    padding: .9rem 1rem;
}
.dashboard-sneat .dashboard-activity-tile {
    border: 1px solid rgba(0,0,0,.05);
    min-height: 64px;
}
.dashboard-sneat .dashboard-chart-container {
    height: 260px;
}
.dashboard-sneat .dashboard-donut-container {
    height: 210px;
}
.dashboard-sneat .table tbody td {
    padding-top: .62rem;
    padding-bottom: .62rem;
}
.dashboard-sneat .row > [class*="col-"] .dashboard-panel { animation-delay: .03s; }
.dashboard-sneat .row > [class*="col-"]:nth-child(2) .dashboard-panel { animation-delay: .07s; }
.dashboard-sneat .row > [class*="col-"]:nth-child(3) .dashboard-panel { animation-delay: .11s; }
@keyframes dashboardCardIn {
    from { opacity: 0; transform: translateY(8px); }
    to { opacity: 1; transform: translateY(0); }
}
</style>
@endpush

@push('scripts')
<script>
window.initBoardStatsChart = function() {
    var wrap = document.querySelector('#dashboard-board-stats-content .board-stats-inner');
    if (!wrap) return;
    var total = parseInt(wrap.getAttribute('data-total'), 10) || 0;
    var segmentsJson = wrap.getAttribute('data-segments');
    var segments = [];
    try { segments = JSON.parse(segmentsJson || '[]'); } catch (e) {}
    var canvas = document.getElementById('boardStatsDonutChart');
    if (!canvas || typeof Chart === 'undefined') return;
    if (window._boardStatsDonutChart) {
        window._boardStatsDonutChart.destroy();
        window._boardStatsDonutChart = null;
    }
    if (total === 0 || segments.length === 0) return;
    var labels = segments.map(function(s) { return s.label; });
    var data = segments.map(function(s) { return s.count; });
    var colors = segments.map(function(s) { return s.color; });
    window._boardStatsDonutChart = new Chart(canvas, {
        type: 'doughnut',
        data: {
            labels: labels,
            datasets: [{
                data: data,
                backgroundColor: colors,
                borderColor: '#fff',
                borderWidth: 2,
                hoverOffset: 4
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            cutout: '65%',
            animation: { duration: 520, easing: 'easeOutCubic' },
            plugins: { legend: { display: false } }
        }
    });
};

$(function() {
    // Bar chart: Tickets by user
    var barCtx = document.getElementById('dashboardBarChart');
    if (barCtx && typeof Chart !== 'undefined') {
        var barData = @json($userIssueStats->map(function($u) { return ['label' => $u->name ?? $u->username ?? 'User', 'count' => $u->assigned_issues_count]; })->values()->all());
        new Chart(barCtx, {
            type: 'bar',
            data: {
                labels: barData.map(function(d) { return d.label; }),
                datasets: [{
                    label: 'Assigned issues',
                    data: barData.map(function(d) { return d.count; }),
                    backgroundColor: 'rgba(105, 108, 255, 0.7)',
                    borderColor: 'rgb(105, 108, 255)',
                    borderWidth: 1,
                    borderRadius: 6
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                animation: { duration: 520, easing: 'easeOutCubic' },
                plugins: { legend: { display: false } },
                scales: {
                    y: { beginAtZero: true, ticks: { stepSize: 1 }, grid: { color: 'rgba(0,0,0,.06)' } },
                    x: { grid: { display: false } }
                }
            }
        });
    }

    // Bar chart: Projects by issues
    var projCtx = document.getElementById('dashboardProjectIssuesChart');
    if (projCtx && typeof Chart !== 'undefined') {
        var projData = @json(($projectIssueStats ?? collect())->map(function($p) {
            return ['label' => $p->name ?? $p->project_key ?? 'Project', 'count' => $p->issues_count];
        })->values()->all());
        if (projData.length > 0) {
            new Chart(projCtx, {
                type: 'bar',
                data: {
                    labels: projData.map(function(d) { return d.label; }),
                    datasets: [{
                        label: 'Issues',
                        data: projData.map(function(d) { return d.count; }),
                        backgroundColor: 'rgba(255, 159, 64, 0.8)',
                        borderColor: 'rgb(255, 159, 64)',
                        borderWidth: 1,
                        borderRadius: 6
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    animation: { duration: 520, easing: 'easeOutCubic' },
                    plugins: { legend: { display: false } },
                    scales: {
                        y: { beginAtZero: true, ticks: { stepSize: 1 }, grid: { color: 'rgba(0,0,0,.06)' } },
                        x: { grid: { display: false } }
                    }
                }
            });
        }
    }

    initBoardStatsChart();

    // Board stats dropdown: load via AJAX
    $(document).on('click', '.dashboard-board-stats-select', function(e) {
        e.preventDefault();
        var $a = $(this);
        if ($a.hasClass('active')) return;
        var url = $a.attr('href');
        var name = $a.data('project-name');
        var key = $a.data('project-key');
        $('#dashboard-board-stats-label').text(name);
        $('#dashboard-board-stats-key').text(key);
        $('.dashboard-board-stats-select').removeClass('active');
        $a.addClass('active');
        var $content = $('#dashboard-board-stats-content');
        $content.addClass('opacity-50');
        $.get(url).done(function(html) {
            $content.html(html).removeClass('opacity-50');
            if (typeof window.initBoardStatsChart === 'function') window.initBoardStatsChart();
        }).fail(function() {
            $content.removeClass('opacity-50');
            if (typeof TaskFlow !== 'undefined' && TaskFlow.toast) TaskFlow.toast('error', 'Failed to load board statistics.');
        });
    });
});
</script>
@endpush
@endsection
