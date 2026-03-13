<div class="card setup-detail-card border-0 shadow-none mb-0">
    <div class="card-header">Team details</div>
    <div class="card-body">
        <dl class="row mb-0">
            <dt class="col-sm-3">Description</dt><dd class="col-sm-9">{{ $team->description ?? '-' }}</dd>
        </dl>
        <div class="setup-detail-section">
            <div class="section-title">Members</div>
            <ul class="setup-detail-list">@forelse(($team->members ?? collect()) as $m)<li>{{ $m->display_name ?? $m->username }}@if($m->pivot && $m->pivot->role_in_team) <span class="badge bg-secondary">{{ $m->pivot->role_in_team }}</span>@endif</li>@empty<li class="empty">No members.</li>@endforelse</ul>
        </div>
        @if(isset($team->projects) && $team->projects->isNotEmpty())
        <div class="setup-detail-section">
            <div class="section-title">Tagged projects</div>
            <ul class="setup-detail-list">@foreach($team->projects as $p)<li>{{ $p->name }} <span class="badge bg-primary rounded-pill">{{ $p->project_key }}</span></li>@endforeach</ul>
        </div>
        @endif
    </div>
</div>
