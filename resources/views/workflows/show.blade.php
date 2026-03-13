@extends('layouts.app')
@section('title', $workflow->name)
@section('content')
<div class="setup-detail-page">
    <div class="d-flex justify-content-between align-items-center setup-detail-header">
        <h1 class="h4 mb-0 fw-600">{{ $workflow->name }}</h1>
        <div class="btn-group">
            <a href="{{ route('workflows.edit', $workflow) }}" class="btn btn-primary"><i class="bi bi-pencil me-1"></i> Edit</a>
            <a href="{{ route('workflows.index') }}" class="btn btn-outline-secondary"><i class="bi bi-arrow-left me-1"></i> Back</a>
        </div>
    </div>
    <div class="card setup-detail-card">
        <div class="card-header">Workflow details</div>
        <div class="card-body">
            <dl class="row mb-0">
                <dt class="col-sm-3">Board</dt><dd class="col-sm-9">{{ $workflow->board->name ?? '-' }} @if($workflow->board && $workflow->board->project)<span class="text-muted">({{ $workflow->board->project->name }})</span>@endif</dd>
            </dl>
            <div class="setup-detail-section">
                <div class="section-title">Transitions</div>
                <ul class="setup-detail-list">@forelse($workflow->transitions as $t)<li>{{ $t->fromStatus->name ?? '-' }} → {{ $t->toStatus->name ?? '-' }}@if($t->transition_name) <span class="text-muted">({{ $t->transition_name }})</span>@endif</li>@empty<li class="empty">No transitions defined.</li>@endforelse</ul>
            </div>
        </div>
    </div>
</div>
@endsection
