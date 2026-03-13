@extends('layouts.app')
@section('title', $issueType->name)
@section('content')
<div class="setup-detail-page">
    <div class="d-flex justify-content-between align-items-center setup-detail-header">
        <h1 class="h4 mb-0 fw-600 d-flex align-items-center gap-2">
            @if($issueType->icon)<i class="bi bi-{{ $issueType->icon }} text-primary"></i>@endif
            {{ $issueType->name }}
        </h1>
        <div class="btn-group">
            <a href="{{ route('issue-types.edit', $issueType) }}" class="btn btn-primary"><i class="bi bi-pencil me-1"></i> Edit</a>
            <a href="{{ route('issue-types.index') }}" class="btn btn-outline-secondary"><i class="bi bi-arrow-left me-1"></i> Back</a>
        </div>
    </div>
    <div class="card setup-detail-card">
        <div class="card-header">Issue type details</div>
        <div class="card-body">
            <dl class="row mb-0">
                <dt class="col-sm-3">Icon</dt><dd class="col-sm-9">{{ $issueType->icon ?? '-' }}</dd>
                <dt class="col-sm-3">Color</dt><dd class="col-sm-9">@if($issueType->color)<span class="badge" style="background:{{ $issueType->color }}">{{ $issueType->color }}</span>@else—@endif</dd>
            </dl>
        </div>
    </div>
</div>
@endsection
