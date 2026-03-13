@extends('layouts.app')
@section('title', 'Workflow Transitions')
@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h1 class="h3 mb-0 page-title">Workflow Transitions</h1>
    <button type="button" class="btn btn-primary" id="btn-create-transition"><i class="bi bi-plus-lg me-1"></i> Add Transition</button>
</div>
<div class="card border-0 shadow-sm setup-list-card">
    <div class="card-header bg-transparent border-bottom py-3"><span class="fw-600 text-body">All workflow transitions</span></div>
    <div class="card-body p-0" id="workflow-transitions-table-container">
        @include('workflow-transitions._table', ['transitions' => $transitions, 'workflows' => $workflows])
    </div>
</div>
@include('partials.crud-modal-js', [
    'createButtonId' => 'btn-create-transition',
    'createTitle' => 'Add Transition',
    'createLoadUrl' => route('workflow-transitions.create'),
    'createSubmitUrl' => route('workflow-transitions.store'),
    'refreshUrl' => route('workflow-transitions.index', array_merge(request()->only('workflow_id'), ['partial' => 1])),
    'containerSelector' => '#workflow-transitions-table-container',
])
@endsection
