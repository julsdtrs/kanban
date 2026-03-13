@extends('layouts.app')
@section('title', 'Workflows')
@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h1 class="h3 mb-0 page-title">Workflows</h1>
    <button type="button" class="btn btn-primary" id="btn-create-workflow"><i class="bi bi-plus-lg me-1"></i> Add Workflow</button>
</div>
<div class="card border-0 shadow-sm setup-list-card">
    <div class="card-header bg-transparent border-bottom py-3"><span class="fw-600 text-body">All workflows</span></div>
    <div class="card-body p-0" id="workflows-table-container">
        @include('workflows._table', ['workflows' => $workflows])
    </div>
</div>
@include('partials.crud-modal-js', [
    'createButtonId' => 'btn-create-workflow',
    'createTitle' => 'Add Workflow',
    'createLoadUrl' => route('workflows.create'),
    'createSubmitUrl' => route('workflows.store'),
    'refreshUrl' => route('workflows.index', ['partial' => 1]),
    'containerSelector' => '#workflows-table-container',
])
@endsection
