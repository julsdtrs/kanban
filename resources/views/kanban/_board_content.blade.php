<div class="d-flex flex-wrap justify-content-between align-items-center gap-2 mb-2 flex-shrink-0">
    <div class="d-flex align-items-center gap-2 flex-wrap">
        @if(isset($sprints) && $sprints->isNotEmpty())
        <div class="dropdown">
            <button class="btn btn-outline-secondary dropdown-toggle d-flex align-items-center gap-2" type="button" id="kanbanSprintDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                <i class="bi bi-lightning-charge"></i>
                <span id="kanban-sprint-label">{{ $sprint ? ($sprint->name ?? 'Sprint #'.$sprint->id) : 'All sprints' }}</span>
            </button>
            <ul class="dropdown-menu" aria-labelledby="kanbanSprintDropdown">
                @php
                    $sprintBaseUrl = (isset($currentBoard) && $currentBoard ? route('kanban.board.show', $currentBoard) : route('kanban.board', $project));
                @endphp
                <li><a class="kanban-sprint-select dropdown-item {{ !$sprint ? 'active' : '' }}" href="{{ $sprintBaseUrl }}">All sprints</a></li>
                @foreach($sprints as $s)
                <li><a class="kanban-sprint-select dropdown-item {{ $sprint && $sprint->id === $s->id ? 'active' : '' }}" href="{{ $sprintBaseUrl }}?sprint_id={{ $s->id }}">{{ $s->name ?? 'Sprint #'.$s->id }}</a></li>
                @endforeach
            </ul>
        </div>
        @endif
        <div class="dropdown">
            <button class="btn btn-outline-secondary dropdown-toggle d-flex align-items-center gap-2" type="button" id="kanbanBoardDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                <i class="bi bi-grid-3x3-gap"></i>
                <span id="kanban-board-label">@if(isset($currentBoard) && $currentBoard){{ $currentBoard->name ?? 'Board' }}@else{{ $project->name }}@endif</span>
                @if(isset($currentBoard) && $currentBoard)<span class="badge bg-secondary rounded-pill" id="kanban-board-key">{{ $currentBoard->board_type ?? 'kanban' }}</span>@else<span class="badge bg-primary rounded-pill" id="kanban-board-key">{{ $project->project_key }}</span>@endif
            </button>
            <ul class="dropdown-menu" aria-labelledby="kanbanBoardDropdown">
                @if(($boards ?? collect())->isNotEmpty())
                    @foreach($boards as $b)
                    <li>
                        <a class="kanban-board-select dropdown-item d-flex justify-content-between align-items-center {{ (isset($currentBoard) && $currentBoard && $currentBoard->id === $b->id) ? 'active' : '' }}" href="{{ route('kanban.board.show', $b) }}{{ request()->has('sprint_id') ? '?sprint_id='.request('sprint_id') : '' }}" data-board-id="{{ $b->id }}" data-board-name="{{ e($b->name ?? 'Board #'.$b->id) }}"><span><i class="bi bi-grid-3x3-gap me-2"></i>{{ $b->name ?? 'Board #'.$b->id }}</span><span class="badge bg-secondary rounded-pill">{{ $b->board_type ?? 'kanban' }}</span></a>
                    </li>
                    @endforeach
                @else
                    @foreach($projects ?? [] as $p)
                    <li>
                        <a class="kanban-board-select dropdown-item d-flex justify-content-between align-items-center {{ $p->id === $project->id ? 'active' : '' }}" href="{{ route('kanban.board', $p) }}" data-project-id="{{ $p->id }}" data-project-name="{{ e($p->name) }}" data-project-key="{{ $p->project_key ?? '' }}"><span><i class="bi bi-folder me-2"></i>{{ $p->name }}</span><span class="badge bg-primary rounded-pill">{{ $p->project_key ?? '' }}</span></a>
                    </li>
                    @endforeach
                @endif
            </ul>
        </div>
    </div>
    <a id="kanban-new-issue-btn" href="{{ route('issues.create', ['project_id' => $project->id]) }}" class="btn btn-primary"><i class="bi bi-plus-lg"></i> New issue</a>
</div>
@php
    $transitionMap = [];
    if (isset($workflow) && $workflow && $workflow->relationLoaded('transitions')) {
        foreach ($workflow->transitions as $t) {
            $fromId = (string) $t->from_status_id;
            $toId = (int) $t->to_status_id;
            $transitionMap[$fromId] = $transitionMap[$fromId] ?? [];
            if (! in_array($toId, $transitionMap[$fromId], true)) {
                $transitionMap[$fromId][] = $toId;
            }
        }
    }
@endphp
<div class="kanban-board-wrapper" data-project-id="{{ $project->id }}" data-transitions='@json($transitionMap)'>
<div class="kanban-board pb-3">
    @foreach($statuses as $status)
    <div class="kanban-column flex-shrink-0" data-status-id="{{ $status->id }}">
        <div class="kanban-column-header d-flex justify-content-between align-items-center" style="background: {{ $status->color ?? '#e9ecef' }}20;">
            <span>{{ $status->name }}</span>
            <span class="badge bg-secondary">{{ isset($issuesByStatus[$status->id]) ? $issuesByStatus[$status->id]->count() : 0 }}</span>
        </div>
        <div class="kanban-dropszone d-flex flex-column gap-2">
            @if(isset($issuesByStatus[$status->id]))
                @foreach($issuesByStatus[$status->id] as $issue)
                <div class="kanban-card card cursor-grab" data-issue-id="{{ $issue->id }}" data-issue-url="{{ route('issues.show', $issue) }}?modal=1" data-issue-title="{{ $issue->issue_key }}" draggable="true">
                    <div class="card-body">
                        <div class="d-flex align-items-center gap-1 flex-wrap">
                            <span class="text-decoration-none text-dark fw-medium small">{{ $issue->issue_key }}</span>
                            @if(isset($boardProjects) && $boardProjects->isNotEmpty() && $boardProjects->count() > 1 && $issue->relationLoaded('project') && $issue->project)<span class="badge bg-light text-dark border small">{{ $issue->project->project_key }}</span>@endif
                        </div>
                        <p class="mb-0 small text-muted mt-1">{{ Str::limit($issue->summary, 50) }}</p>
                        <div class="d-flex justify-content-between align-items-center mt-2 flex-wrap gap-1">
                            @if($issue->priority)<span class="badge" style="background:{{ $issue->priority->color ?? '#6c757d' }}20; color: {{ $issue->priority->color ?? '#6c757d' }};">{{ $issue->priority->name }}</span>@endif
                            @if($issue->assignee)<span class="small text-muted">{{ $issue->assignee->name }}</span>@endif
                        </div>
                    </div>
                </div>
                @endforeach
            @endif
            <a href="{{ route('issues.create', ['project_id' => $project->id, 'status_id' => $status->id]) }}" class="btn kanban-add-item text-start w-100 mt-1"><i class="bi bi-plus-lg me-1"></i> Add new item</a>
        </div>
    </div>
    @endforeach
    <div class="kanban-column flex-shrink-0" data-status-id="">
        <div class="kanban-column-header d-flex justify-content-between align-items-center bg-secondary bg-opacity-25">
            <span>Backlog</span>
            <span class="badge bg-secondary">{{ $backlog->count() }}</span>
        </div>
        <div class="kanban-dropszone d-flex flex-column gap-2">
            @foreach($backlog as $issue)
            <div class="kanban-card card cursor-grab" data-issue-id="{{ $issue->id }}" data-issue-url="{{ route('issues.show', $issue) }}?modal=1" data-issue-title="{{ $issue->issue_key }}" draggable="true">
                <div class="card-body">
                    <div class="d-flex align-items-center gap-1 flex-wrap">
                        <span class="text-decoration-none text-dark fw-medium small">{{ $issue->issue_key }}</span>
                        @if(isset($boardProjects) && $boardProjects->isNotEmpty() && $boardProjects->count() > 1 && $issue->relationLoaded('project') && $issue->project)<span class="badge bg-light text-dark border small">{{ $issue->project->project_key }}</span>@endif
                    </div>
                    <p class="mb-0 small text-muted mt-1">{{ Str::limit($issue->summary, 50) }}</p>
                    <div class="d-flex justify-content-between align-items-center mt-2 flex-wrap gap-1">
                        @if($issue->priority)<span class="badge" style="background:{{ $issue->priority->color ?? '#6c757d' }}20; color: {{ $issue->priority->color ?? '#6c757d' }};">{{ $issue->priority->name }}</span>@endif
                        @if($issue->assignee)<span class="small text-muted">{{ $issue->assignee->name }}</span>@endif
                    </div>
                </div>
            </div>
            @endforeach
            <a href="{{ route('issues.create', ['project_id' => $project->id]) }}" class="btn kanban-add-item text-start w-100 mt-1"><i class="bi bi-plus-lg me-1"></i> Add new item</a>
        </div>
    </div>
</div>
</div>
