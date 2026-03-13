<div class="card setup-detail-card border-0 shadow-none mb-0">
    <div class="card-header">Priority details</div>
    <div class="card-body">
        <dl class="row mb-0">
            <dt class="col-sm-3">Level</dt><dd class="col-sm-9">{{ $priority->level }}</dd>
            <dt class="col-sm-3">Color</dt><dd class="col-sm-9">@if($priority->color)<span class="badge" style="background:{{ $priority->color }}">{{ $priority->color }}</span>@else—@endif</dd>
        </dl>
    </div>
</div>
