@extends('layouts.app')
@section('title', $sprint->name ?? 'Sprint')
@section('content')
<div class="setup-detail-page">
    <div class="d-flex justify-content-between align-items-center setup-detail-header">
        <h1 class="h4 mb-0 fw-600">{{ $sprint->name ?? 'Sprint' }}</h1>
        <div class="btn-group">
            <a href="{{ route('sprints.edit', $sprint) }}" class="btn btn-primary"><i class="bi bi-pencil me-1"></i> Edit</a>
            <a href="{{ route('sprints.index') }}" class="btn btn-outline-secondary"><i class="bi bi-arrow-left me-1"></i> Back</a>
        </div>
    </div>
    <div class="card setup-detail-card">
        <div class="card-header">Sprint details</div>
        <div class="card-body">
            <dl class="row mb-0">
                <dt class="col-sm-3">Board</dt><dd class="col-sm-9">{{ $sprint->board->project->name ?? $sprint->board->name ?? '-' }}</dd>
                <dt class="col-sm-3">Goal</dt><dd class="col-sm-9">{{ $sprint->goal ?? '-' }}</dd>
                <dt class="col-sm-3">Start date</dt><dd class="col-sm-9">{{ $sprint->start_date ? \Carbon\Carbon::parse($sprint->start_date)->format('Y-m-d') : '-' }}</dd>
                <dt class="col-sm-3">End date</dt><dd class="col-sm-9">{{ $sprint->end_date ? \Carbon\Carbon::parse($sprint->end_date)->format('Y-m-d') : '-' }}</dd>
                <dt class="col-sm-3">State</dt><dd class="col-sm-9"><span class="badge bg-secondary">{{ $sprint->state }}</span></dd>
            </dl>
            <div class="setup-detail-section">
                <div class="section-title">Issues in this sprint</div>
                <ul class="setup-detail-list">@forelse($sprint->issues as $i)<li><a href="{{ route('issues.show', $i) }}">{{ $i->issue_key }}</a></li>@empty<li class="empty">No issues.</li>@endforelse</ul>
            </div>
        </div>
    </div>
</div>
@endsection
