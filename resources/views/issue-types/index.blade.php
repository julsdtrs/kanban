@extends('layouts.app')
@section('title', 'Issue Types')
@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h1 class="h3 mb-0 page-title">Issue Types</h1>
    <button type="button" class="btn btn-primary" id="btn-create-issue-type"><i class="bi bi-plus-lg me-1"></i> Add Issue Type</button>
</div>
<div class="card border-0 shadow-sm setup-list-card">
    <div class="card-header bg-transparent border-bottom py-3"><span class="fw-600 text-body">All issue types</span></div>
    <div class="card-body p-0" id="issue-types-table-container">
        @include('issue-types._table', ['issueTypes' => $issueTypes])
    </div>
</div>
@include('partials.crud-modal-js', [
    'createButtonId' => 'btn-create-issue-type',
    'createTitle' => 'Add Issue Type',
    'createLoadUrl' => route('issue-types.create'),
    'createSubmitUrl' => route('issue-types.store'),
    'refreshUrl' => route('issue-types.index', ['partial' => 1]),
    'containerSelector' => '#issue-types-table-container',
])
@endsection
