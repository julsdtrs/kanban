<div class="card setup-detail-card border-0 shadow-none mb-0">
    <div class="card-header">Board details</div>
    <div class="card-body">
        <dl class="row mb-0">
            <dt class="col-sm-3">Project</dt><dd class="col-sm-9">{{ $board->project->name ?? '-' }}</dd>
            <dt class="col-sm-3">Board type</dt><dd class="col-sm-9">{{ $board->board_type }}</dd>
        </dl>
        <div class="setup-detail-section">
            <div class="section-title">Sprints</div>
            <ul class="setup-detail-list">@forelse($board->sprints as $s)<li>{{ $s->name ?? 'Sprint #' . $s->id }} <span class="badge bg-secondary">{{ $s->state }}</span></li>@empty<li class="empty">No sprints.</li>@endforelse</ul>
        </div>
    </div>
</div>
