<div class="card setup-detail-card border-0 shadow-none mb-0">
    <div class="card-header">Status details</div>
    <div class="card-body">
        <dl class="row mb-0">
            <dt class="col-sm-3">Category</dt><dd class="col-sm-9"><span class="badge bg-secondary">{{ $status->category }}</span></dd>
            <dt class="col-sm-3">Color</dt><dd class="col-sm-9">@if($status->color)<span class="badge" style="background:{{ $status->color }}">{{ $status->color }}</span>@else—@endif</dd>
            <dt class="col-sm-3">Order</dt><dd class="col-sm-9">{{ $status->order_no }}</dd>
        </dl>
    </div>
</div>
