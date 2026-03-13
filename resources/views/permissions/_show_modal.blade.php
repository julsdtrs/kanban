<div class="card setup-detail-card border-0 shadow-none mb-0">
    <div class="card-header">Permission details</div>
    <div class="card-body">
        <dl class="row mb-0">
            <dt class="col-sm-3">Code</dt><dd class="col-sm-9"><code class="text-primary">{{ $permission->code }}</code></dd>
            <dt class="col-sm-3">Description</dt><dd class="col-sm-9">{{ $permission->description ?? '-' }}</dd>
        </dl>
    </div>
</div>
