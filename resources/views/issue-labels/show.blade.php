@extends('layouts.app')
@section('title', $issueLabel->name)
@section('content')
<div class="setup-detail-page">
    <div class="d-flex justify-content-between align-items-center setup-detail-header">
        <h1 class="h4 mb-0 fw-600 d-flex align-items-center gap-2">
            @if($issueLabel->color)<span class="badge rounded-pill" style="background:{{ $issueLabel->color }}; width:12px; height:12px; padding:0;"></span>@endif
            {{ $issueLabel->name }}
        </h1>
        <div class="btn-group">
            <a href="{{ route('issue-labels.edit', $issueLabel) }}" class="btn btn-primary"><i class="bi bi-pencil me-1"></i> Edit</a>
            <a href="{{ route('issue-labels.index') }}" class="btn btn-outline-secondary"><i class="bi bi-arrow-left me-1"></i> Back</a>
        </div>
    </div>
    <div class="card setup-detail-card">
        <div class="card-header">Label details</div>
        <div class="card-body">
            <dl class="row mb-0">
                <dt class="col-sm-3">Color</dt><dd class="col-sm-9">@if($issueLabel->color)<span class="badge" style="background:{{ $issueLabel->color }}">{{ $issueLabel->color }}</span>@else—@endif</dd>
            </dl>
            <div class="setup-detail-section">
                <div class="section-title">Issues with this label</div>
                <ul class="setup-detail-list">@forelse($issueLabel->issues as $i)<li><a href="{{ route('issues.show', $i) }}">{{ $i->issue_key }}</a></li>@empty<li class="empty">No issues.</li>@endforelse</ul>
            </div>
        </div>
    </div>
</div>
@endsection
