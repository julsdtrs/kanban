@extends('layouts.app')
@section('title', 'Role Permissions')
@section('content')
<div class="d-flex justify-content-between align-items-start mb-4 flex-wrap gap-2">
    <div>
        <h1 class="h3 mb-1 page-title">Role Permissions</h1>
        <div class="text-muted small">Connect roles to the low-level permissions they grant.</div>
    </div>
    <div class="d-flex flex-column align-items-end gap-1">
        <button type="button" class="btn btn-primary" id="btn-create-role-permission">
            <i class="bi bi-plus-lg me-1"></i> Add Role Permission
        </button>
        <div class="text-muted small">
            Tip: filter by role, then add all relevant permissions.
        </div>
    </div>
</div>
<div class="card border-0 shadow-sm setup-list-card">
    <div class="card-header bg-transparent border-bottom py-3"><span class="fw-600 text-body">All role permissions</span></div>
    <div class="card-body p-0" id="role-permissions-table-container">
        @include('role-permissions._table', ['items' => $items, 'roles' => $roles])
    </div>
</div>
@include('partials.crud-modal-js', [
    'createButtonId' => 'btn-create-role-permission',
    'createTitle' => 'Add Role Permission',
    'createLoadUrl' => route('role-permissions.create'),
    'createSubmitUrl' => route('role-permissions.store'),
    'refreshUrl' => route('role-permissions.index', array_merge(request()->only('role_id'), ['partial' => 1])),
    'containerSelector' => '#role-permissions-table-container',
])
@endsection
