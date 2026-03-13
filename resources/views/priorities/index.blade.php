@extends('layouts.app')
@section('title', 'Priorities')
@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h1 class="h3 mb-0 page-title">Priorities</h1>
    <button type="button" class="btn btn-primary" id="btn-create-priority"><i class="bi bi-plus-lg me-1"></i> Add Priority</button>
</div>
<div class="card border-0 shadow-sm setup-list-card">
    <div class="card-header bg-transparent border-bottom py-3"><span class="fw-600 text-body">All priorities</span></div>
    <div class="card-body p-0" id="priorities-table-container">
        @include('priorities._table', ['priorities' => $priorities])
    </div>
</div>
@include('partials.crud-modal-js', [
    'createButtonId' => 'btn-create-priority',
    'createTitle' => 'Add Priority',
    'createLoadUrl' => route('priorities.create'),
    'createSubmitUrl' => route('priorities.store'),
    'refreshUrl' => route('priorities.index', ['partial' => 1]),
    'containerSelector' => '#priorities-table-container',
])
@endsection
