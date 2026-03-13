<div class="card setup-detail-card border-0 shadow-none mb-0">
    <div class="card-header">Sprint details</div>
    <div class="card-body">
        <dl class="row mb-0">
            <dt class="col-sm-3">Board</dt><dd class="col-sm-9">{{ $sprint->board->project->name ?? $sprint->board->name ?? '-' }}</dd>
            <dt class="col-sm-3">Goal</dt><dd class="col-sm-9">{{ $sprint->goal ?? '-' }}</dd>
            <dt class="col-sm-3">Start date</dt><dd class="col-sm-9">{{ $sprint->start_date ? \Carbon\Carbon::parse($sprint->start_date)->format('Y-m-d') : '-' }}</dd>
            <dt class="col-sm-3">End date</dt><dd class="col-sm-9">{{ $sprint->end_date ? \Carbon\Carbon::parse($sprint->end_date)->format('Y-m-d') : '-' }}</dd>
            <dt class="col-sm-3">State</dt><dd class="col-sm-9"><span class="badge bg-secondary">{{ $sprint->state }}</span></dd>
        </dl>
        <div class="setup-detail-section">
            <div class="section-title">Issues in this sprint</div>
            <ul class="setup-detail-list">@forelse($sprint->issues as $i)<li>{{ $i->issue_key }}</li>@empty<li class="empty">No issues.</li>@endforelse</ul>
        </div>
    </div>
</div>
