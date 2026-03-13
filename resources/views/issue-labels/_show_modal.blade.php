<div class="card setup-detail-card border-0 shadow-none mb-0">
    <div class="card-header">Label details</div>
    <div class="card-body">
        <dl class="row mb-0">
            <dt class="col-sm-3">Color</dt><dd class="col-sm-9">@if($issueLabel->color)<span class="badge" style="background:{{ $issueLabel->color }}">{{ $issueLabel->color }}</span>@else—@endif</dd>
        </dl>
        <div class="setup-detail-section">
            <div class="section-title">Issues with this label</div>
            <ul class="setup-detail-list">@forelse($issueLabel->issues as $i)<li>{{ $i->issue_key }}</li>@empty<li class="empty">No issues.</li>@endforelse</ul>
        </div>
    </div>
</div>
