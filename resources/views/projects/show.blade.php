@extends('layouts.app')
@section('title', $project->name)
@section('content')
<div class="setup-detail-page">
    <div class="d-flex justify-content-between align-items-center setup-detail-header">
        <h1 class="h4 mb-0 fw-600">{{ $project->name }}</h1>
        <div class="btn-group">
            <a href="{{ route('projects.edit', $project) }}" class="btn btn-primary"><i class="bi bi-pencil me-1"></i> Edit</a>
            <a href="{{ route('projects.index') }}" class="btn btn-outline-secondary"><i class="bi bi-arrow-left me-1"></i> Back</a>
        </div>
    </div>
    <div class="card setup-detail-card">
        <div class="card-header">Project details</div>
        <div class="card-body">
            <dl class="row mb-0">
                <dt class="col-sm-3">Project key</dt><dd class="col-sm-9"><code class="text-primary">{{ $project->project_key }}</code></dd>
                <dt class="col-sm-3">Organization</dt><dd class="col-sm-9">{{ $project->organization->name ?? '-' }}</dd>
                <dt class="col-sm-3">Description</dt><dd class="col-sm-9">{{ $project->description ?? '-' }}</dd>
                <dt class="col-sm-3">Lead</dt><dd class="col-sm-9">{{ $project->lead->display_name ?? $project->lead->username ?? '-' }}</dd>
                <dt class="col-sm-3">Type</dt><dd class="col-sm-9">{{ $project->project_type }}</dd>
                <dt class="col-sm-3">Active</dt><dd class="col-sm-9">@if($project->is_active)<span class="badge bg-success">Yes</span>@else<span class="badge bg-secondary">No</span>@endif</dd>
            </dl>
            <div class="setup-detail-section">
                <div class="section-title">Recent issues</div>
                <ul class="setup-detail-list">@forelse($project->issues->take(10) as $issue)<li><a href="{{ route('issues.show', $issue) }}">{{ $issue->issue_key }}</a> — {{ Str::limit($issue->summary, 40) }}</li>@empty<li class="empty">No issues yet.</li>@endforelse</ul>
            </div>
        </div>
    </div>
</div>
@endsection
