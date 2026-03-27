@extends('layouts.app')
@section('title', $issue->issue_key)
@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h1 class="h3 mb-0">{{ $issue->issue_key }} — {{ $issue->summary }}</h1>
    <div>
        <a href="{{ route('issues.edit', $issue) }}" class="btn btn-primary">Edit</a>
        <a href="{{ route('issues.index') }}" class="btn btn-outline-secondary">Back</a>
    </div>
</div>
<div class="card border-0 shadow-sm mb-4"><div class="card-body">
<dl class="row mb-0">
    <dt class="col-sm-3">Project</dt><dd class="col-sm-9"><a href="{{ route('projects.show', $issue->project) }}">{{ $issue->project->name ?? '—' }}</a></dd>
    <dt class="col-sm-3">Type</dt><dd class="col-sm-9">{{ $issue->issueType->name ?? '—' }}</dd>
    <dt class="col-sm-3">Status</dt><dd class="col-sm-9">{{ $issue->status->name ?? '—' }}</dd>
    <dt class="col-sm-3">Priority</dt><dd class="col-sm-9">{{ $issue->priority->name ?? '—' }}</dd>
    <dt class="col-sm-3">Reporter</dt><dd class="col-sm-9">{{ $issue->reporter->display_name ?? $issue->reporter->username ?? '—' }}</dd>
    <dt class="col-sm-3">Assignee</dt><dd class="col-sm-9">{{ $issue->assignee->display_name ?? $issue->assignee->username ?? '—' }}</dd>
    <dt class="col-sm-3">Story points</dt><dd class="col-sm-9">{{ $issue->story_points !== null ? $issue->story_points : '—' }}</dd>
    <dt class="col-sm-3">Due date</dt><dd class="col-sm-9">{{ $issue->due_date ? $issue->due_date->format('Y-m-d') : '—' }}</dd>
    <dt class="col-sm-3">Sprints</dt><dd class="col-sm-9">@if(($issue->sprints ?? collect())->isNotEmpty()){{ $issue->sprints->pluck('name')->filter()->join(', ') }}@else—@endif</dd>
    <dt class="col-sm-3">Parent</dt><dd class="col-sm-9">@if($issue->parent)<a href="{{ route('issues.show', $issue->parent) }}">{{ $issue->parent->issue_key }}</a>@else—@endif</dd>
    <dt class="col-sm-3">Subtasks</dt><dd class="col-sm-9">@if(($issue->subtasks ?? collect())->isNotEmpty())<ul class="mb-0 ps-3">@foreach($issue->subtasks as $st)<li><a href="{{ route('issues.show', $st) }}">{{ $st->issue_key }}</a> — {{ $st->summary }}</li>@endforeach</ul>@else—@endif</dd>
    <dt class="col-sm-3">Labels</dt><dd class="col-sm-9">@forelse($issue->labels ?? [] as $l)<span class="badge bg-secondary me-1">{{ $l->name }}</span>@empty—@endforelse</dd>
    <dt class="col-sm-3">Watchers</dt><dd class="col-sm-9">@if(($issue->watchers ?? collect())->isNotEmpty()){{ $issue->watchers->map(fn ($u) => $u->display_name ?? $u->username)->filter()->join(', ') }}@else—@endif</dd>
    <dt class="col-sm-3">Attachments</dt><dd class="col-sm-9">@if(($issue->attachments ?? collect())->isNotEmpty())<ul class="mb-0 ps-3">@foreach($issue->attachments as $att)<li class="text-break">{{ $att->file_name ?? 'File' }}@if($att->file_size) <span class="text-muted">({{ number_format((int) $att->file_size / 1024, 1) }} KB)</span>@endif</li>@endforeach</ul>@else—@endif</dd>
    <dt class="col-sm-3">Created</dt><dd class="col-sm-9">{{ $issue->created_at ? $issue->created_at->format('Y-m-d H:i') : '—' }}</dd>
    <dt class="col-sm-3">Updated</dt><dd class="col-sm-9">{{ $issue->updated_at ? $issue->updated_at->format('Y-m-d H:i') : '—' }}</dd>
    <dt class="col-sm-3">Description</dt><dd class="col-sm-9 issue-modal-description">@if($issue->description){!! $issue->description !!}@else—@endif</dd>
</dl>
</div></div>
<h6 class="mb-2">Comments</h6>
<div class="card border-0 shadow-sm">
    <div class="card-body">
        @forelse($issue->comments ?? [] as $comment)
        <div class="border-start border-3 border-light ps-3 mb-3">
            <strong>{{ $comment->user->display_name ?? $comment->user->username ?? 'User' }}</strong>
            <span class="text-muted small">{{ $comment->created_at ? $comment->created_at->format('Y-m-d H:i') : '' }}</span>
            <div class="mt-1">{{ $comment->comment_text ?? '-' }}</div>
        </div>
        @empty
        <p class="text-muted mb-0">No comments yet.</p>
        @endforelse
    </div>
</div>
@endsection
