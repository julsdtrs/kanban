@extends('layouts.app')
@section('title', 'Issue Labels')
@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h1 class="h3 mb-0 page-title">Issue Labels</h1>
    <button type="button" class="btn btn-primary" id="btn-create-issue-label"><i class="bi bi-plus-lg me-1"></i> Add Label</button>
</div>
<div class="card border-0 shadow-sm setup-list-card">
    <div class="card-header bg-transparent border-bottom py-3"><span class="fw-600 text-body">All issue labels</span></div>
    <div class="card-body p-0" id="issue-labels-table-container">
        @include('issue-labels._table', ['issueLabels' => $issueLabels])
    </div>
</div>
@include('partials.crud-modal-js', [
    'createButtonId' => 'btn-create-issue-label',
    'createTitle' => 'Add Issue Label',
    'createLoadUrl' => route('issue-labels.create'),
    'createSubmitUrl' => route('issue-labels.store'),
    'refreshUrl' => route('issue-labels.index', ['partial' => 1]),
    'containerSelector' => '#issue-labels-table-container',
])
@endsection
