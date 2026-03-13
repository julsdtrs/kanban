@extends('layouts.app')
@section('title', 'Permissions')
@section('content')
<div class="d-flex justify-content-between align-items-start mb-4 flex-wrap gap-2">
    <div>
        <h1 class="h3 mb-1 page-title">Permissions</h1>
        <div class="text-muted small">Fine-grained capabilities that you later group into roles.</div>
    </div>
    <div class="d-flex flex-column align-items-end gap-1">
        <button type="button" class="btn btn-primary" id="btn-create-permission">
            <i class="bi bi-plus-lg me-1"></i> Add Permission
        </button>
        <div class="text-muted small">
            Use a clear naming pattern, e.g. <code>issues.view</code>, <code>issues.edit</code>.
        </div>
    </div>
</div>
<div class="card border-0 shadow-sm setup-list-card">
    <div class="card-header bg-transparent border-bottom py-3"><span class="fw-600 text-body">All permissions</span></div>
    <div class="card-body p-0" id="permissions-table-container">
        @include('permissions._table', ['permissions' => $permissions])
    </div>
</div>
@include('partials.crud-modal-js', [
    'createButtonId' => 'btn-create-permission',
    'createTitle' => 'Add Permission',
    'createLoadUrl' => route('permissions.create'),
    'createSubmitUrl' => route('permissions.store'),
    'refreshUrl' => route('permissions.index', ['partial' => 1]),
    'containerSelector' => '#permissions-table-container',
])
@endsection
