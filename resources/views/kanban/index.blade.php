@extends('layouts.app')
@section('title', 'Kanban Board')
@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h1 class="h3 mb-0">Kanban Board</h1>
</div>
<div class="card border-0 shadow-sm">
    <div class="card-body">
        <p class="text-muted mb-3">Select a project to open its Kanban board.</p>
        <div class="list-group">
            @forelse($projects as $project)
            <a href="{{ route('kanban.board', $project) }}" class="list-group-item list-group-item-action d-flex justify-content-between align-items-center">
                <span><i class="bi bi-folder me-2"></i>{{ $project->name }}</span>
                <span class="badge bg-primary rounded-pill">{{ $project->project_key }}</span>
            </a>
            @empty
            <p class="text-muted mb-0">No projects. <a href="{{ route('projects.create') }}">Create a project</a> first.</p>
            @endforelse
        </div>
    </div>
</div>
@endsection
