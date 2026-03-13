@extends('layouts.app')
@section('title', 'Sprints')
@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h1 class="h3 mb-0 page-title">Sprints</h1>
    <button type="button" class="btn btn-primary" id="btn-create-sprint"><i class="bi bi-plus-lg me-1"></i> Add Sprint</button>
</div>
<div class="card border-0 shadow-sm setup-list-card">
    <div class="card-header bg-transparent border-bottom py-3"><span class="fw-600 text-body">All sprints</span></div>
    <div class="card-body p-0" id="sprints-table-container">
        @include('sprints._table', ['sprints' => $sprints, 'boards' => $boards])
    </div>
</div>
@include('partials.crud-modal-js', [
    'createButtonId' => 'btn-create-sprint',
    'createTitle' => 'Add Sprint',
    'createLoadUrl' => route('sprints.create'),
    'createSubmitUrl' => route('sprints.store'),
    'refreshUrl' => route('sprints.index', array_merge(request()->only('board_id'), ['partial' => 1])),
    'containerSelector' => '#sprints-table-container',
])
@endsection
