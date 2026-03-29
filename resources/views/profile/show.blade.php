@extends('layouts.app')
@section('title', 'My profile')
@php
    $displayRole = $user->roles->pluck('name')->join(', ') ?: 'Member';
@endphp

@section('content')
<div class="profile-dashboard-page">
    <div class="profile-hero card border-0 shadow-sm overflow-hidden mb-3">
        <div class="profile-hero-banner" aria-hidden="true"></div>
        <div class="profile-hero-body card-body">
            <div class="profile-hero-main">
                <div class="profile-hero-avatar-wrap">
                    @if($user->avatar)
                        <img class="profile-hero-avatar" src="{{ \Illuminate\Support\Str::startsWith($user->avatar, ['http://', 'https://']) ? $user->avatar : asset($user->avatar) }}" alt="">
                    @else
                        <div class="profile-hero-avatar profile-hero-avatar--placeholder" aria-hidden="true">{{ strtoupper(substr($user->name, 0, 1)) }}</div>
                    @endif
                </div>
                <div class="profile-hero-text flex-grow-1 min-w-0">
                    <h1 class="profile-hero-name h4 mb-1">{{ $user->name }}</h1>
                    <div class="profile-hero-meta d-flex flex-wrap align-items-center gap-2">
                        <span class="d-inline-flex align-items-center gap-1 text-muted small"><i class="bi bi-person-badge text-primary"></i>{{ $displayRole }}</span>
                        <span class="d-inline-flex align-items-center gap-1 text-muted small"><i class="bi bi-at text-primary"></i>{{ $user->username }}</span>
                        <span class="d-inline-flex align-items-center gap-1 text-muted small"><i class="bi bi-calendar3 text-primary"></i>Joined {{ $user->created_at?->format('M Y') ?? '—' }}</span>
                    </div>
                </div>
                <div class="profile-hero-actions flex-shrink-0">
                    <a class="btn btn-primary btn-sm d-inline-flex align-items-center gap-2" href="{{ route('users.edit', $user) }}">
                        <i class="bi bi-pencil-square"></i> Edit profile
                    </a>
                </div>
            </div>
        </div>
    </div>

    <ul class="nav nav-pills profile-tabs gap-2 flex-wrap mb-3" id="profileTabs" role="tablist">
        <li class="nav-item" role="presentation">
            <button class="nav-link active d-inline-flex align-items-center gap-2" id="tab-profile-btn" data-bs-toggle="pill" data-bs-target="#tab-profile" type="button" role="tab" aria-controls="tab-profile" aria-selected="true">
                <i class="bi bi-person"></i> Profile
            </button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link d-inline-flex align-items-center gap-2" id="tab-teams-btn" data-bs-toggle="pill" data-bs-target="#tab-teams" type="button" role="tab" aria-controls="tab-teams" aria-selected="false">
                <i class="bi bi-people"></i> Teams
            </button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link d-inline-flex align-items-center gap-2" id="tab-projects-btn" data-bs-toggle="pill" data-bs-target="#tab-projects" type="button" role="tab" aria-controls="tab-projects" aria-selected="false">
                <i class="bi bi-folder"></i> Projects
            </button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link d-inline-flex align-items-center gap-2" id="tab-connections-btn" data-bs-toggle="pill" data-bs-target="#tab-connections" type="button" role="tab" aria-controls="tab-connections" aria-selected="false">
                <i class="bi bi-diagram-3"></i> Connections
            </button>
        </li>
    </ul>

    <div class="tab-content" id="profileTabsContent">
        <div class="tab-pane fade show active" id="tab-profile" role="tabpanel" aria-labelledby="tab-profile-btn" tabindex="0">
            <div class="row g-3">
                <div class="col-lg-3">
                    <div class="card border-0 shadow-sm h-100">
                        <div class="card-body profile-card-compact">
                            <p class="profile-card-kicker mb-2">About</p>
                            <ul class="profile-info-list list-unstyled mb-0">
                                <li><i class="bi bi-person"></i><span class="label">Full name</span><span class="value">{{ $user->display_name ?? $user->username }}</span></li>
                                <li><i class="bi bi-lightning-charge"></i><span class="label">Status</span><span class="value">@if($user->is_active)<span class="badge bg-success-subtle text-success rounded-pill">Active</span>@else<span class="badge bg-secondary rounded-pill">Inactive</span>@endif</span></li>
                                <li><i class="bi bi-shield-check"></i><span class="label">Roles</span><span class="value">{{ $user->roles->isEmpty() ? '—' : $user->roles->pluck('name')->join(', ') }}</span></li>
                                <li><i class="bi bi-hash"></i><span class="label">Username</span><span class="value text-break">{{ $user->username }}</span></li>
                            </ul>
                            <p class="profile-card-kicker profile-card-kicker--spaced mb-2">Contacts</p>
                            <ul class="profile-info-list list-unstyled mb-0">
                                <li><i class="bi bi-envelope"></i><span class="label">Email</span><span class="value text-break"><a href="mailto:{{ $user->email }}">{{ $user->email }}</a></span></li>
                            </ul>
                            <p class="profile-card-kicker profile-card-kicker--spaced mb-2">Teams</p>
                            <ul class="profile-team-chips list-unstyled mb-0">
                                @forelse($user->teams as $team)
                                    <li class="d-flex justify-content-between align-items-center gap-2">
                                        <span>{{ $team->name }}</span>
                                        <span class="text-muted small">@if(isset($team->members_count)){{ $team->members_count }} {{ Str::plural('member', $team->members_count) }}@else—@endif</span>
                                    </li>
                                @empty
                                    <li class="text-muted small">Not on any team yet.</li>
                                @endforelse
                            </ul>
                            <hr class="profile-card-divider my-2 my-md-3">
                            <p class="profile-card-kicker mb-2">Overview</p>
                            <p class="profile-overview-subkicker mb-2">Your assignments</p>
                            <div class="profile-stat-grid profile-stat-grid--issues mb-3">
                                <div class="profile-stat"><i class="bi bi-inboxes text-primary"></i><span class="profile-stat-value">{{ $stats['assigned'] }}</span><span class="profile-stat-label">Total assigned</span></div>
                                <div class="profile-stat"><i class="bi bi-check-circle text-success"></i><span class="profile-stat-value">{{ $stats['assigned_resolved'] }}</span><span class="profile-stat-label">Resolved</span></div>
                                <div class="profile-stat"><i class="bi bi-hourglass-split text-warning"></i><span class="profile-stat-value">{{ $stats['assigned_pending'] }}</span><span class="profile-stat-label">Pending</span></div>
                            </div>
                            <p class="profile-overview-subkicker mb-2">Workspace</p>
                            <div class="profile-stat-grid profile-stat-grid--workspace">
                                <div class="profile-stat"><i class="bi bi-folder text-primary"></i><span class="profile-stat-value">{{ $stats['projects'] }}</span><span class="profile-stat-label">Projects</span></div>
                                <div class="profile-stat"><i class="bi bi-people text-primary"></i><span class="profile-stat-value">{{ $stats['teams'] }}</span><span class="profile-stat-label">Teams</span></div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-9">
                    <div class="card border-0 shadow-sm mb-3">
                        <div class="card-body profile-card-compact">
                            <div class="d-flex align-items-center justify-content-between mb-2">
                                <h2 class="h6 mb-0 fw-semibold">Activity</h2>
                            </div>
                            @if($timeline->isEmpty())
                                <p class="text-muted small mb-0">No recent comments or issue updates yet.</p>
                            @else
                                <ul class="profile-timeline list-unstyled mb-0">
                                    @foreach($timeline as $idx => $item)
                                        @php
                                            $dotClass = ['profile-timeline-dot--a', 'profile-timeline-dot--b', 'profile-timeline-dot--c'][$idx % 3];
                                        @endphp
                                        @if($item['kind'] === 'comment')
                                            @php $c = $item['comment']; $issue = $c->issue; @endphp
                                            <li class="profile-timeline-item">
                                                <span class="profile-timeline-dot {{ $dotClass }}" aria-hidden="true"></span>
                                                <div>
                                                    <p class="mb-1 fw-medium">Comment @if($issue)on <a href="{{ route('issues.show', $issue) }}">{{ $issue->issue_key }}</a>@endif</p>
                                                    <p class="small text-muted mb-0">{{ Str::limit($c->comment_text, 160) }}</p>
                                                    <span class="profile-timeline-time">{{ $item['at']->diffForHumans() }}</span>
                                                </div>
                                            </li>
                                        @else
                                            @php $issue = $item['issue']; @endphp
                                            <li class="profile-timeline-item">
                                                <span class="profile-timeline-dot {{ $dotClass }}" aria-hidden="true"></span>
                                                <div>
                                                    <p class="mb-1 fw-medium">Issue updated: <a href="{{ route('issues.show', $issue) }}">{{ $issue->issue_key }}</a></p>
                                                    <p class="small text-muted mb-0">{{ Str::limit($issue->summary, 120) }}</p>
                                                    @if($issue->status)
                                                        <span class="badge rounded-pill bg-light text-dark border mt-1">{{ $issue->status->name }}</span>
                                                    @endif
                                                    <span class="profile-timeline-time">{{ $item['at']->diffForHumans() }}</span>
                                                </div>
                                            </li>
                                        @endif
                                    @endforeach
                                </ul>
                            @endif
                        </div>
                    </div>
                    <div class="row g-3">
                        <div class="col-md-6">
                            <div class="card border-0 shadow-sm h-100">
                                <div class="card-body profile-card-compact">
                                    <h3 class="h6 fw-semibold mb-2">Connections</h3>
                                    <p class="small text-muted mb-2">People who share a team with you.</p>
                                    <ul class="list-unstyled mb-0 profile-connections-list">
                                        @forelse($connectionUsers as $cuser)
                                            <li class="d-flex align-items-center gap-2">
                                                <div class="profile-mini-avatar">{{ strtoupper(substr($cuser->name, 0, 1)) }}</div>
                                                <div class="flex-grow-1 min-w-0">
                                                    <div class="small fw-medium text-truncate">{{ $cuser->display_name ?? $cuser->username }}</div>
                                                    <div class="text-muted" style="font-size: .75rem;">{{ $cuser->teams_count ?? 0 }} shared {{ Str::plural('team', $cuser->teams_count ?? 0) }}</div>
                                                </div>
                                                <a class="btn btn-sm btn-outline-primary flex-shrink-0 profile-sq-btn" href="{{ route('users.show', $cuser) }}" title="View user"><i class="bi bi-person"></i></a>
                                            </li>
                                        @empty
                                            <li class="text-muted small">No teammates found yet.</li>
                                        @endforelse
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="card border-0 shadow-sm h-100">
                                <div class="card-body profile-card-compact">
                                    <h3 class="h6 fw-semibold mb-2">Teams</h3>
                                    <ul class="list-unstyled mb-0 profile-teams-list">
                                        @forelse($user->teams as $team)
                                            <li class="d-flex align-items-center justify-content-between gap-2">
                                                <div class="d-flex align-items-center gap-2 min-w-0">
                                                    <span class="profile-team-icon"><i class="bi bi-people-fill"></i></span>
                                                    <div class="min-w-0">
                                                        <div class="small fw-medium text-truncate">{{ $team->name }}</div>
                                                        <div class="text-muted" style="font-size: .75rem;">@if(isset($team->members_count)){{ $team->members_count }} {{ Str::plural('member', $team->members_count) }}@endif</div>
                                                    </div>
                                                </div>
                                                @if($team->pivot && $team->pivot->role_in_team)
                                                    <span class="badge rounded-pill profile-team-badge">{{ $team->pivot->role_in_team }}</span>
                                                @endif
                                            </li>
                                        @empty
                                            <li class="text-muted small">No teams yet.</li>
                                        @endforelse
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="tab-pane fade" id="tab-teams" role="tabpanel" aria-labelledby="tab-teams-btn" tabindex="0">
            <div class="card border-0 shadow-sm">
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover align-middle mb-0">
                            <thead class="table-light"><tr><th>Name</th><th>Members</th><th>Your role</th><th></th></tr></thead>
                            <tbody>
                                @forelse($user->teams as $team)
                                    <tr>
                                        <td class="fw-medium">{{ $team->name }}</td>
                                        <td>{{ $team->members_count ?? '—' }}</td>
                                        <td>{{ $team->pivot->role_in_team ?? '—' }}</td>
                                        <td class="text-end"><a class="btn btn-sm btn-outline-primary" href="{{ route('teams.show', $team) }}">View</a></td>
                                    </tr>
                                @empty
                                    <tr><td colspan="4" class="text-muted">You are not assigned to any teams.</td></tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <div class="tab-pane fade" id="tab-projects" role="tabpanel" aria-labelledby="tab-projects-btn" tabindex="0">
            <div class="card border-0 shadow-sm">
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover align-middle mb-0">
                            <thead class="table-light"><tr><th>Project</th><th>Key</th><th></th></tr></thead>
                            <tbody>
                                @forelse($user->projectMemberships as $proj)
                                    <tr>
                                        <td class="fw-medium">{{ $proj->name ?? ('Project #'.$proj->id) }}</td>
                                        <td><span class="badge bg-primary-subtle text-primary rounded-pill">{{ $proj->project_key ?? '—' }}</span></td>
                                        <td class="text-end"><a class="btn btn-sm btn-outline-primary" href="{{ route('projects.show', $proj) }}">View</a></td>
                                    </tr>
                                @empty
                                    <tr><td colspan="3" class="text-muted">No project memberships yet.</td></tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <div class="tab-pane fade" id="tab-connections" role="tabpanel" aria-labelledby="tab-connections-btn" tabindex="0">
            <div class="card border-0 shadow-sm">
                <div class="card-body">
                    <div class="row g-3">
                        @forelse($connectionUsers as $cuser)
                            <div class="col-md-6 col-xl-4">
                                <div class="card profile-connection-card border h-100">
                                    <div class="card-body d-flex align-items-center gap-3">
                                        <div class="profile-mini-avatar profile-mini-avatar--lg">{{ strtoupper(substr($cuser->name, 0, 1)) }}</div>
                                        <div class="flex-grow-1 min-w-0">
                                            <div class="fw-medium text-truncate">{{ $cuser->display_name ?? $cuser->username }}</div>
                                            <div class="text-muted small">{{ $cuser->teams_count ?? 0 }} shared {{ Str::plural('team', $cuser->teams_count ?? 0) }}</div>
                                        </div>
                                        <a class="btn btn-primary btn-sm" href="{{ route('users.show', $cuser) }}">View</a>
                                    </div>
                                </div>
                            </div>
                        @empty
                            <div class="col-12 text-muted">No connections yet — join a team to see teammates here.</div>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
    /* Full width within main column — no capped max-width */
    .profile-dashboard-page {
        width: 100%;
        max-width: none;
        margin: 0;
    }
    .profile-hero {
        border-radius: var(--radius-lg, 0.5rem);
        position: relative;
        isolation: isolate;
    }
    /* Background layer only — must stay below .profile-hero-body (negative margin overlap). */
    .profile-hero-banner {
        position: relative;
        z-index: 0;
        height: 88px;
        background: repeating-linear-gradient(
            -24deg,
            #7ee8db 0px, #7ee8db 18px,
            #fff3cd 18px, #fff3cd 36px,
            #fcd4e8 36px, #fcd4e8 54px,
            #e8eaff 54px, #e8eaff 72px
        );
        pointer-events: none;
    }
    .profile-hero-body {
        position: relative;
        z-index: 1;
        padding-top: 0;
        padding-bottom: 0.85rem;
        padding-left: 1rem;
        padding-right: 1rem;
        background: var(--input-bg, #fff);
    }
    .profile-hero-main {
        position: relative;
        z-index: 1;
        display: flex;
        flex-wrap: wrap;
        align-items: center;
        gap: 0.85rem 1rem;
        margin-top: -2.5rem;
    }
    @media (min-width: 768px) {
        .profile-hero-actions { margin-left: auto; }
        .profile-hero-main { flex-wrap: nowrap; }
    }
    .profile-hero-avatar-wrap { flex-shrink: 0; }
    .profile-hero-avatar {
        width: 88px;
        height: 88px;
        object-fit: cover;
        border-radius: var(--radius-lg, 0.5rem);
        border: 3px solid var(--header-bg, #fff);
        box-shadow: var(--shadow-sm, 0 1px 2px rgba(0,0,0,.06));
        background: var(--input-bg, #fff);
    }
    .profile-hero-avatar--placeholder {
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.85rem;
        font-weight: 700;
        color: #fff;
        background: linear-gradient(135deg, var(--primary, #5b5fef) 0%, color-mix(in srgb, var(--primary, #5b5fef) 65%, #a855f7) 100%);
    }
    .profile-hero-name { color: var(--text-body); font-weight: 700; }
    .profile-hero-meta { margin-top: 0.15rem; }
    .profile-hero-actions { margin-top: 0; }
    .profile-card-compact { padding: 1rem 1.125rem !important; }
    .profile-card-divider {
        border: 0;
        border-top: 1px solid var(--border-light);
        opacity: 1;
    }
    .profile-tabs .nav-link {
        border-radius: var(--radius-lg, 0.5rem);
        color: var(--text-muted);
        font-weight: 600;
        font-size: 0.8125rem;
        padding: 0.4rem 0.85rem;
        transition: background 0.2s ease, color 0.2s ease;
    }
    .profile-tabs .nav-link:hover { color: var(--text-body); background: color-mix(in srgb, var(--primary) 10%, transparent); }
    .profile-tabs .nav-link.active {
        background: var(--primary);
        color: #fff;
    }
    .profile-tabs .nav-link.active i { color: inherit; }
    html[data-theme="ocean"] .profile-tabs .nav-link.active { background: var(--primary); color: #fff; }
    .profile-card-kicker {
        font-size: 0.65rem;
        text-transform: uppercase;
        letter-spacing: 0.08em;
        font-weight: 700;
        color: var(--text-muted);
        margin-bottom: 0.5rem;
    }
    .profile-card-kicker--spaced { margin-top: 0.85rem; }
    .profile-info-list li {
        display: grid;
        grid-template-columns: 1.125rem 5rem minmax(0, 1fr);
        gap: 0.35rem 0.5rem;
        align-items: start;
        padding: 0.28rem 0;
        border-bottom: 1px solid var(--border-light);
        font-size: 0.8125rem;
    }
    .profile-info-list li:last-child { border-bottom: 0; }
    .profile-info-list .label { color: var(--text-muted); font-size: 0.75rem; }
    .profile-info-list .value { color: var(--text-body); font-weight: 500; }
    .profile-info-list i { color: var(--primary); margin-top: 0.1rem; font-size: 0.9rem; }
    .profile-team-chips li { padding: 0.28rem 0; font-size: 0.8125rem; border-bottom: 1px solid var(--border-light); }
    .profile-team-chips li:last-child { border-bottom: 0; }
    .profile-overview-subkicker {
        font-size: 0.7rem;
        font-weight: 600;
        color: var(--text-muted);
        text-transform: none;
        letter-spacing: 0.02em;
    }
    .profile-stat-grid {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 0.5rem;
    }
    .profile-stat-grid--workspace {
        grid-template-columns: repeat(2, 1fr);
    }
    @media (max-width: 480px) {
        .profile-stat-grid,
        .profile-stat-grid--workspace { grid-template-columns: 1fr; }
    }
    .profile-stat {
        background: color-mix(in srgb, var(--body-bg) 80%, var(--input-bg));
        border: 1px solid var(--border-light);
        border-radius: var(--radius-lg);
        padding: 0.5rem 0.4rem;
        text-align: center;
    }
    .profile-stat i { font-size: 0.95rem; margin-bottom: 0.15rem; display: block; }
    .profile-stat-value { display: block; font-size: 1.15rem; font-weight: 700; color: var(--text-body); line-height: 1.15; }
    .profile-stat-label { font-size: 0.62rem; text-transform: uppercase; letter-spacing: 0.05em; color: var(--text-muted); line-height: 1.2; }
    .profile-timeline { position: relative; padding-left: 0.35rem; }
    .profile-timeline::before {
        content: "";
        position: absolute;
        left: 0.45rem;
        top: 0.25rem;
        bottom: 0.25rem;
        width: 2px;
        background: var(--border-color);
        border-radius: 1px;
        opacity: 0.45;
    }
    .profile-timeline-item { position: relative; padding-left: 1.5rem; padding-bottom: 1rem; }
    .profile-timeline-item:last-child { padding-bottom: 0; }
    .profile-timeline-dot {
        position: absolute;
        left: 0;
        top: 0.3rem;
        width: 12px;
        height: 12px;
        border-radius: 50%;
        border: 2px solid var(--input-bg);
        box-shadow: 0 0 0 2px color-mix(in srgb, var(--primary) 25%, transparent);
    }
    .profile-timeline-dot--a { background: var(--primary); }
    .profile-timeline-dot--b { background: #22c55e; }
    .profile-timeline-dot--c { background: #0ea5e9; }
    .profile-timeline-time { font-size: 0.72rem; color: var(--text-muted); display: block; margin-top: 0.25rem; }
    .profile-mini-avatar {
        width: 38px;
        height: 38px;
        border-radius: 50%;
        background: linear-gradient(135deg, var(--primary), color-mix(in srgb, var(--primary) 70%, #6366f1));
        color: #fff;
        font-weight: 700;
        font-size: 0.875rem;
        display: flex;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
    }
    .profile-mini-avatar--lg { width: 48px; height: 48px; font-size: 1.05rem; }
    .profile-sq-btn {
        width: 2.25rem;
        height: 2.25rem;
        padding: 0;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        border-radius: var(--radius);
    }
    .profile-connections-list li { padding: 0.35rem 0; border-bottom: 1px solid var(--border-light); }
    .profile-connections-list li:last-child { border-bottom: 0; }
    .profile-team-icon {
        width: 2.25rem;
        height: 2.25rem;
        border-radius: var(--radius);
        background: color-mix(in srgb, var(--primary) 12%, transparent);
        color: var(--primary);
        display: flex;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
    }
    .profile-teams-list li { padding: 0.45rem 0; border-bottom: 1px solid var(--border-light); }
    .profile-teams-list li:last-child { border-bottom: 0; }
    .profile-team-badge {
        font-size: 0.7rem;
        font-weight: 600;
        background: color-mix(in srgb, #fb923c 18%, var(--input-bg)) !important;
        color: #c2410c !important;
        border: 1px solid color-mix(in srgb, #fb923c 35%, transparent);
    }
    html[data-theme="ocean"] .profile-team-badge {
        background: color-mix(in srgb, var(--primary) 16%, var(--input-bg)) !important;
        color: var(--primary-hover) !important;
        border-color: color-mix(in srgb, var(--primary) 28%, transparent);
    }
    .profile-connection-card { border-radius: var(--radius-lg); background: var(--input-bg); }
    html[data-theme="dark"] .profile-hero-banner {
        filter: saturate(0.82) brightness(0.72);
    }
    html[data-theme="dark"] .profile-hero-avatar { border-color: var(--sidebar-bg); }
    html[data-theme="dark"] .profile-tabs .nav-link.active { color: #0b0f1a; }
</style>
@endpush
