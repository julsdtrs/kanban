@extends('layouts.app')
@section('title', $permission->code)
@section('content')
<div class="setup-detail-page">
    <div class="d-flex justify-content-between align-items-center setup-detail-header">
        <h1 class="h4 mb-0 fw-600"><code class="text-primary">{{ $permission->code }}</code></h1>
        <div class="btn-group">
            <a href="{{ route('permissions.edit', $permission) }}" class="btn btn-primary"><i class="bi bi-pencil me-1"></i> Edit</a>
            <a href="{{ route('permissions.index') }}" class="btn btn-outline-secondary"><i class="bi bi-arrow-left me-1"></i> Back</a>
        </div>
    </div>
    <div class="card setup-detail-card">
        <div class="card-header">Permission details</div>
        <div class="card-body">
            <dl class="row mb-0">
                <dt class="col-sm-3">Description</dt><dd class="col-sm-9">{{ $permission->description ?? '-' }}</dd>
            </dl>
        </div>
    </div>
</div>
@endsection
