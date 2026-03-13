<div class="card setup-detail-card border-0 shadow-none mb-0">
    <div class="card-header">Issue type details</div>
    <div class="card-body">
        <dl class="row mb-0">
            <dt class="col-sm-3">Icon</dt><dd class="col-sm-9">{{ $issueType->icon ?? '-' }}</dd>
            <dt class="col-sm-3">Color</dt><dd class="col-sm-9">@if($issueType->color)<span class="badge" style="background:{{ $issueType->color }}">{{ $issueType->color }}</span>@else—@endif</dd>
        </dl>
    </div>
</div>
