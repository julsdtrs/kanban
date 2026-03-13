@extends('layouts.app')
@section('title', 'Organizations')
@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h1 class="h3 mb-0 page-title">Organizations</h1>
    <button type="button" class="btn btn-primary" id="btn-create-organization"><i class="bi bi-plus-lg me-1"></i> Add Organization</button>
</div>
<div class="card border-0 shadow-sm setup-list-card">
    <div class="card-header bg-transparent border-bottom py-3"><span class="fw-600 text-body">All organizations</span></div>
    <div class="card-body p-0" id="organizations-table-container">
        @include('organizations._table', ['organizations' => $organizations])
    </div>
</div>
@include('partials.crud-modal-js', [
    'createButtonId' => 'btn-create-organization',
    'createTitle' => 'Add Organization',
    'createLoadUrl' => route('organizations.create'),
    'createSubmitUrl' => route('organizations.store'),
    'refreshUrl' => route('organizations.index', ['partial' => 1]),
    'containerSelector' => '#organizations-table-container',
])
@endsection
