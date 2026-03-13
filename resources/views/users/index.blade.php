@extends('layouts.app')
@section('title', 'Users')
@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h1 class="h3 mb-0 page-title">Users</h1>
    <button type="button" class="btn btn-primary" id="btn-create-user"><i class="bi bi-plus-lg me-1"></i> Add User</button>
</div>
<div class="card border-0 shadow-sm setup-list-card">
    <div class="card-header bg-transparent border-bottom py-3">
        <span class="fw-600 text-body">All users</span>
    </div>
    <div class="card-body p-0" id="users-table-container">
        @include('users._table', ['users' => $users])
    </div>
</div>
@include('partials.crud-modal-js', [
    'createButtonId' => 'btn-create-user',
    'createTitle' => 'Add User',
    'createLoadUrl' => route('users.create'),
    'createSubmitUrl' => route('users.store'),
    'refreshUrl' => route('users.index', ['partial' => 1]),
    'containerSelector' => '#users-table-container',
])
@endsection
