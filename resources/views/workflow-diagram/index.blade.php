@extends('layouts.app')
@section('title', 'Workflow Diagram')
@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h1 class="h3 mb-0">Workflow Diagram</h1>
</div>
<div class="card border-0 shadow-sm">
    <div class="card-body">
        <p class="text-muted mb-3">Select a workflow to view or edit its diagram (statuses and transitions).</p>
        <div class="list-group">
            @forelse($workflows as $wf)
            <a href="{{ route('workflows.diagram.show', $wf) }}" class="list-group-item list-group-item-action d-flex justify-content-between align-items-center">
                <span><i class="bi bi-arrow-left-right me-2"></i>{{ $wf->name }}</span>
                <span class="badge bg-secondary">{{ $wf->project->name ?? '' }}</span>
            </a>
            @empty
            <p class="text-muted mb-0">No workflows. <a href="{{ route('workflows.create') }}">Create a workflow</a> first.</p>
            @endforelse
        </div>
    </div>
</div>
@endsection
