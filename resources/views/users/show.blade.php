@extends('layouts.app')
@section('title', $user->username)
@section('content')
<div class="setup-detail-page">
    <div class="d-flex justify-content-between align-items-center setup-detail-header">
        <h1 class="h4 mb-0 fw-600">{{ $user->display_name ?? $user->username }}</h1>
        <div class="btn-group">
            <a href="{{ route('users.edit', $user) }}" class="btn btn-primary"><i class="bi bi-pencil me-1"></i> Edit</a>
            <a href="{{ route('users.index') }}" class="btn btn-outline-secondary"><i class="bi bi-arrow-left me-1"></i> Back</a>
        </div>
    </div>
    <div class="card setup-detail-card">
        <div class="card-header">User details</div>
        <div class="card-body">
            <dl class="row mb-0">
                <dt class="col-sm-3">Username</dt><dd class="col-sm-9">{{ $user->username }}</dd>
                <dt class="col-sm-3">Email</dt><dd class="col-sm-9">{{ $user->email }}</dd>
                <dt class="col-sm-3">Display name</dt><dd class="col-sm-9">{{ $user->display_name ?? '-' }}</dd>
                <dt class="col-sm-3">Active</dt><dd class="col-sm-9">@if($user->is_active)<span class="badge bg-success">Yes</span>@else<span class="badge bg-secondary">No</span>@endif</dd>
            </dl>
        </div>
    </div>
</div>
@endsection
