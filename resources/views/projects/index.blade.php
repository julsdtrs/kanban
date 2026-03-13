@extends('layouts.app')
@section('title', 'Projects')
@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h1 class="h3 mb-0 page-title">Projects</h1>
    <button type="button" class="btn btn-primary" id="btn-create-project"><i class="bi bi-plus-lg me-1"></i> Add Project</button>
</div>
<div class="card border-0 shadow-sm setup-list-card">
    <div class="card-header bg-transparent border-bottom py-3"><span class="fw-600 text-body">All projects</span></div>
    <div class="card-body p-0" id="projects-table-container">
        @include('projects._table', ['projects' => $projects])
    </div>
</div>
@include('partials.crud-modal-js', [
    'createButtonId' => 'btn-create-project',
    'createTitle' => 'Add Project',
    'createLoadUrl' => route('projects.create'),
    'createSubmitUrl' => route('projects.store'),
    'refreshUrl' => route('projects.index', ['partial' => 1]),
    'containerSelector' => '#projects-table-container',
])
@endsection
