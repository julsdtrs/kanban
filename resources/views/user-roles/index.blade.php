@extends('layouts.app')
@section('title', 'User Roles')
@section('content')
<div class="d-flex justify-content-between align-items-start mb-4 flex-wrap gap-2">
    <div>
        <h1 class="h3 mb-1 page-title">User Roles</h1>
        <div class="text-muted small">Assign one or more roles to each active user.</div>
    </div>
    <div class="d-flex flex-column align-items-end gap-1">
        <button type="button" class="btn btn-primary" id="btn-create-user-role">
            <i class="bi bi-plus-lg me-1"></i> Assign Role
        </button>
        <div class="text-muted small">
            Tip: filter by user to review their access.
        </div>
    </div>
</div>
<div class="card border-0 shadow-sm setup-list-card">
    <div class="card-header bg-transparent border-bottom py-3"><span class="fw-600 text-body">All user roles</span></div>
    <div class="card-body p-0" id="user-roles-table-container">
        @include('user-roles._table', ['items' => $items, 'users' => $users])
    </div>
</div>
@include('partials.crud-modal-js', [
    'createButtonId' => 'btn-create-user-role',
    'createTitle' => 'Assign User Role',
    'createLoadUrl' => route('user-roles.create'),
    'createSubmitUrl' => route('user-roles.store'),
    'refreshUrl' => route('user-roles.index', array_merge(request()->only('user_id'), ['partial' => 1])),
    'containerSelector' => '#user-roles-table-container',
])
@endsection
