<div class="card setup-detail-card border-0 shadow-none mb-0">
    <div class="card-header">Organization details</div>
    <div class="card-body">
        <dl class="row mb-0">
            <dt class="col-sm-3">Description</dt><dd class="col-sm-9">{{ $organization->description ?? '-' }}</dd>
        </dl>
        <div class="setup-detail-section">
            <div class="section-title">Projects</div>
            <ul class="setup-detail-list">@forelse($organization->projects as $p)<li>{{ $p->name }}</li>@empty<li class="empty">No projects.</li>@endforelse</ul>
        </div>
    </div>
</div>
