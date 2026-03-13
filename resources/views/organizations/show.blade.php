@extends('layouts.app')
@section('title', $organization->name)
@section('content')
<div class="setup-detail-page">
    <div class="d-flex justify-content-between align-items-center setup-detail-header">
        <h1 class="h4 mb-0 fw-600">{{ $organization->name }}</h1>
        <div class="btn-group">
            <a href="{{ route('organizations.edit', $organization) }}" class="btn btn-primary"><i class="bi bi-pencil me-1"></i> Edit</a>
            <a href="{{ route('organizations.index') }}" class="btn btn-outline-secondary"><i class="bi bi-arrow-left me-1"></i> Back</a>
        </div>
    </div>
    <div class="card setup-detail-card">
        <div class="card-header">Organization details</div>
        <div class="card-body">
            <dl class="row mb-0">
                <dt class="col-sm-3">Description</dt><dd class="col-sm-9">{{ $organization->description ?? '-' }}</dd>
            </dl>
            <div class="setup-detail-section">
                <div class="section-title">Projects</div>
                <ul class="setup-detail-list">@forelse($organization->projects as $p)<li><a href="{{ route('projects.show', $p) }}">{{ $p->name }}</a></li>@empty<li class="empty">No projects.</li>@endforelse</ul>
            </div>
        </div>
    </div>
</div>
@endsection
