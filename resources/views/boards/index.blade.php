@extends('layouts.app')
@section('title', 'Boards')
@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h1 class="h3 mb-0 page-title">Boards</h1>
    <button type="button" class="btn btn-primary" id="btn-create-board"><i class="bi bi-plus-lg me-1"></i> Add Board</button>
</div>
<div class="card border-0 shadow-sm setup-list-card">
    <div class="card-header bg-transparent border-bottom py-3"><span class="fw-600 text-body">All boards</span></div>
    <div class="card-body p-0" id="boards-table-container">
        @include('boards._table', ['boards' => $boards])
    </div>
</div>
@include('partials.crud-modal-js', [
    'createButtonId' => 'btn-create-board',
    'createTitle' => 'Add Board',
    'createLoadUrl' => route('boards.create'),
    'createSubmitUrl' => route('boards.store'),
    'refreshUrl' => route('boards.index', ['partial' => 1]),
    'containerSelector' => '#boards-table-container',
])
@endsection
