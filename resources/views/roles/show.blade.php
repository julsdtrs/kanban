@extends('layouts.app')
@section('title', $role->name)
@section('content')
<div class="setup-detail-page">
    <div class="d-flex justify-content-between align-items-center setup-detail-header">
        <h1 class="h4 mb-0 fw-600">{{ $role->name }}</h1>
        <div class="btn-group">
            <a href="{{ route('roles.edit', $role) }}" class="btn btn-primary"><i class="bi bi-pencil me-1"></i> Edit</a>
            <a href="{{ route('roles.index') }}" class="btn btn-outline-secondary"><i class="bi bi-arrow-left me-1"></i> Back</a>
        </div>
    </div>
    <div class="card setup-detail-card">
        <div class="card-header">Role details</div>
        <div class="card-body">
            <dl class="row mb-0">
                <dt class="col-sm-3">Description</dt><dd class="col-sm-9">{{ $role->description ?? '-' }}</dd>
            </dl>
            <div class="setup-detail-section">
                <div class="section-title">Permissions</div>
                <ul class="setup-detail-list">@forelse($role->permissions as $p)<li>{{ $p->code }}</li>@empty<li class="empty">No permissions assigned.</li>@endforelse</ul>
            </div>
            <div class="setup-detail-section">
                <div class="section-title">Users with this role</div>
                <ul class="setup-detail-list">@forelse($role->users as $u)<li>{{ $u->display_name ?? $u->username }}</li>@empty<li class="empty">No users assigned.</li>@endforelse</ul>
            </div>
        </div>
    </div>
</div>
@endsection
