<div class="card setup-detail-card border-0 shadow-none mb-0">
    <div class="card-header">Role details</div>
    <div class="card-body">
        <dl class="row mb-0">
            <dt class="col-sm-3">Description</dt><dd class="col-sm-9">{{ $role->description ?? '-' }}</dd>
        </dl>
        <div class="setup-detail-section">
            <div class="section-title">Permissions</div>
            <ul class="setup-detail-list">@forelse($role->permissions as $p)<li>{{ $p->code }}</li>@empty<li class="empty">No permissions assigned.</li>@endforelse</ul>
        </div>
        <div class="setup-detail-section">
            <div class="section-title">Users with this role</div>
            <ul class="setup-detail-list">@forelse($role->users as $u)<li>{{ $u->display_name ?? $u->username }}</li>@empty<li class="empty">No users assigned.</li>@endforelse</ul>
        </div>
    </div>
</div>
