@extends('layouts.app')
@section('title', 'User Role')
@section('content')
<div class="setup-detail-page">
    <div class="d-flex justify-content-between align-items-center setup-detail-header">
        <h1 class="h4 mb-0 fw-600">User Role</h1>
        <div class="btn-group">
            <a href="{{ route('user-roles.edit', $item->user_id . '-' . $item->role_id) }}" class="btn btn-primary"><i class="bi bi-pencil me-1"></i> Edit</a>
            <a href="{{ route('user-roles.index') }}" class="btn btn-outline-secondary"><i class="bi bi-arrow-left me-1"></i> Back</a>
        </div>
    </div>
    <div class="card setup-detail-card">
        <div class="card-header">Details</div>
        <div class="card-body">
            <dl class="row mb-0">
                <dt class="col-sm-3">User</dt><dd class="col-sm-9">{{ $item->display_name ?? $item->username ?? $item->user_id }}</dd>
                <dt class="col-sm-3">Role</dt><dd class="col-sm-9">{{ $item->role_name ?? $item->role_id }}</dd>
            </dl>
        </div>
    </div>
</div>
@endsection
