@extends('layouts.app')
@section('title', 'Workflow Transition')
@section('content')
<div class="setup-detail-page">
    <div class="d-flex justify-content-between align-items-center setup-detail-header">
        <h1 class="h4 mb-0 fw-600">{{ $workflowTransition->fromStatus->name ?? 'From' }} → {{ $workflowTransition->toStatus->name ?? 'To' }}</h1>
        <div class="btn-group">
            <a href="{{ route('workflow-transitions.edit', $workflowTransition) }}" class="btn btn-primary"><i class="bi bi-pencil me-1"></i> Edit</a>
            <a href="{{ route('workflow-transitions.index') }}" class="btn btn-outline-secondary"><i class="bi bi-arrow-left me-1"></i> Back</a>
        </div>
    </div>
    <div class="card setup-detail-card">
        <div class="card-header">Transition details</div>
        <div class="card-body">
            <dl class="row mb-0">
                <dt class="col-sm-3">Workflow</dt><dd class="col-sm-9">{{ $workflowTransition->workflow->name ?? '-' }}</dd>
                <dt class="col-sm-3">From status</dt><dd class="col-sm-9">{{ $workflowTransition->fromStatus->name ?? '-' }}</dd>
                <dt class="col-sm-3">To status</dt><dd class="col-sm-9">{{ $workflowTransition->toStatus->name ?? '-' }}</dd>
                <dt class="col-sm-3">Transition name</dt><dd class="col-sm-9">{{ $workflowTransition->transition_name ?? '-' }}</dd>
            </dl>
        </div>
    </div>
</div>
@endsection
