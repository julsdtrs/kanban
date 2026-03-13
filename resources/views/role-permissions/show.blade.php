@extends('layouts.app')
@section('title', 'Role Permission')
@section('content')
<div class="setup-detail-page">
    <div class="d-flex justify-content-between align-items-center setup-detail-header">
        <h1 class="h4 mb-0 fw-600">Role Permission</h1>
        <div class="btn-group">
            <a href="{{ route('role-permissions.edit', $item->role_id . '-' . $item->permission_id) }}" class="btn btn-primary"><i class="bi bi-pencil me-1"></i> Edit</a>
            <a href="{{ route('role-permissions.index') }}" class="btn btn-outline-secondary"><i class="bi bi-arrow-left me-1"></i> Back</a>
        </div>
    </div>
    <div class="card setup-detail-card">
        <div class="card-header">Details</div>
        <div class="card-body">
            <dl class="row mb-0">
                <dt class="col-sm-3">Role</dt><dd class="col-sm-9">{{ $item->role_name ?? $item->role_id }}</dd>
                <dt class="col-sm-3">Permission</dt><dd class="col-sm-9">{{ $item->permission_code ?? $item->permission_id }}</dd>
            </dl>
        </div>
    </div>
</div>
@endsection
