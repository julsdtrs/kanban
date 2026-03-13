@extends('layouts.app')
@section('title', $board->name ?? 'Board')
@section('content')
<div class="setup-detail-page">
    <div class="d-flex justify-content-between align-items-center setup-detail-header">
        <h1 class="h4 mb-0 fw-600">{{ $board->name ?? $board->project->name ?? 'Board' }}</h1>
        <div class="btn-group">
            <a href="{{ route('boards.edit', $board) }}" class="btn btn-primary"><i class="bi bi-pencil me-1"></i> Edit</a>
            <a href="{{ route('boards.index') }}" class="btn btn-outline-secondary"><i class="bi bi-arrow-left me-1"></i> Back</a>
        </div>
    </div>
    <div class="card setup-detail-card">
        <div class="card-header">Board details</div>
        <div class="card-body">
            <dl class="row mb-0">
                <dt class="col-sm-3">Project</dt><dd class="col-sm-9">{{ $board->project->name ?? '-' }}</dd>
                <dt class="col-sm-3">Board type</dt><dd class="col-sm-9">{{ $board->board_type }}</dd>
            </dl>
            <div class="setup-detail-section">
                <div class="section-title">Sprints</div>
                <ul class="setup-detail-list">@forelse($board->sprints as $s)<li><a href="{{ route('sprints.show', $s) }}">{{ $s->name ?? 'Sprint #' . $s->id }}</a> <span class="badge bg-secondary">{{ $s->state }}</span></li>@empty<li class="empty">No sprints.</li>@endforelse</ul>
            </div>
        </div>
    </div>
</div>
@endsection
