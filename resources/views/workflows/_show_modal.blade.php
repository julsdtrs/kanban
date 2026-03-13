<div class="card setup-detail-card border-0 shadow-none mb-0">
    <div class="card-header">Workflow details</div>
    <div class="card-body">
        <dl class="row mb-0">
            <dt class="col-sm-3">Board</dt><dd class="col-sm-9">{{ $workflow->board->name ?? '-' }} @if($workflow->board && $workflow->board->project)<span class="text-muted">({{ $workflow->board->project->name }})</span>@endif</dd>
        </dl>
        <div class="setup-detail-section">
            <div class="section-title">Transitions</div>
            <ul class="setup-detail-list">@forelse($workflow->transitions as $t)<li>{{ $t->fromStatus->name ?? '-' }} → {{ $t->toStatus->name ?? '-' }}@if($t->transition_name) <span class="text-muted">({{ $t->transition_name }})</span>@endif</li>@empty<li class="empty">No transitions defined.</li>@endforelse</ul>
        </div>
    </div>
</div>
