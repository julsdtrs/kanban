<div class="card setup-detail-card border-0 shadow-none mb-0">
    <div class="card-header">User details</div>
    <div class="card-body">
        <dl class="row mb-0">
            <dt class="col-sm-3">Username</dt><dd class="col-sm-9">{{ $user->username }}</dd>
            <dt class="col-sm-3">Email</dt><dd class="col-sm-9">{{ $user->email }}</dd>
            <dt class="col-sm-3">Display name</dt><dd class="col-sm-9">{{ $user->display_name ?? '-' }}</dd>
            <dt class="col-sm-3">Active</dt><dd class="col-sm-9">@if($user->is_active)<span class="badge bg-success">Yes</span>@else<span class="badge bg-secondary">No</span>@endif</dd>
        </dl>
    </div>
</div>
