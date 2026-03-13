@extends('layouts.app')
@section('title', 'Project Members')
@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h1 class="h3 mb-0 page-title">Project Members</h1>
    <button type="button" class="btn btn-primary" id="btn-create-project-member"><i class="bi bi-plus-lg me-1"></i> Add Member</button>
</div>
<div class="card border-0 shadow-sm setup-list-card">
    <div class="card-header bg-transparent border-bottom py-3"><span class="fw-600 text-body">All project members</span></div>
    <div class="card-body p-0" id="project-members-table-container">
        @include('project-members._table', ['items' => $items, 'projects' => $projects])
    </div>
</div>
@include('partials.crud-modal-js', [
    'createButtonId' => 'btn-create-project-member',
    'createTitle' => 'Add Project Member',
    'createLoadUrl' => route('project-members.create'),
    'createSubmitUrl' => route('project-members.store'),
    'refreshUrl' => route('project-members.index', array_merge(request()->only('project_id'), ['partial' => 1])),
    'containerSelector' => '#project-members-table-container',
])
@endsection
