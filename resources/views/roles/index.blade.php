@extends('layouts.app')
@section('title', 'Roles')
@section('content')
<div class="d-flex justify-content-between align-items-start mb-4 flex-wrap gap-2">
    <div>
        <h1 class="h3 mb-1 page-title">Roles</h1>
        <div class="text-muted small">Define reusable permission bundles that you can assign to users.</div>
    </div>
    <div class="d-flex flex-column align-items-end gap-1">
        <button type="button" class="btn btn-primary" id="btn-create-role">
            <i class="bi bi-plus-lg me-1"></i> Add Role
        </button>
        <div class="text-muted small">
            Typical flow: create roles → map permissions → assign to users.
        </div>
    </div>
</div>
<div class="card border-0 shadow-sm setup-list-card">
    <div class="card-header bg-transparent border-bottom py-3">
        <span class="fw-600 text-body">All roles</span>
    </div>
    <div class="card-body p-0" id="roles-table-container">
        @include('roles._table', ['roles' => $roles])
    </div>
</div>
@include('partials.crud-modal-js', [
    'createButtonId' => 'btn-create-role',
    'createTitle' => 'Add Role',
    'createLoadUrl' => route('roles.create'),
    'createSubmitUrl' => route('roles.store'),
    'refreshUrl' => route('roles.index', ['partial' => 1]),
    'containerSelector' => '#roles-table-container',
])
@endsection
