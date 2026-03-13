@extends('layouts.app')
@section('title', $team->name)
@section('content')
<div class="setup-detail-page">
    <div class="d-flex justify-content-between align-items-center setup-detail-header">
        <h1 class="h4 mb-0 fw-600">{{ $team->name }}</h1>
        <div class="btn-group">
            <a href="{{ route('teams.edit', $team) }}" class="btn btn-primary"><i class="bi bi-pencil me-1"></i> Edit</a>
            <a href="{{ route('teams.index') }}" class="btn btn-outline-secondary"><i class="bi bi-arrow-left me-1"></i> Back</a>
        </div>
    </div>
    <div class="card setup-detail-card">
        <div class="card-header">Team details</div>
        <div class="card-body">
            <dl class="row mb-0">
                <dt class="col-sm-3">Description</dt><dd class="col-sm-9">{{ $team->description ?? '-' }}</dd>
            </dl>
            <div class="setup-detail-section">
                <div class="section-title">Members</div>
                <ul class="setup-detail-list">@forelse(($team->members ?? collect()) as $m)<li>{{ $m->display_name ?? $m->username }}@if($m->pivot && $m->pivot->role_in_team) <span class="badge bg-secondary">{{ $m->pivot->role_in_team }}</span>@endif</li>@empty<li class="empty">No members.</li>@endforelse</ul>
            </div>
            @if(isset($team->projects) && $team->projects->isNotEmpty())
            <div class="setup-detail-section">
                <div class="section-title">Tagged projects</div>
                <ul class="setup-detail-list">@foreach($team->projects as $p)<li><a href="{{ route('projects.show', $p) }}">{{ $p->name }}</a> <span class="badge bg-primary rounded-pill">{{ $p->project_key }}</span></li>@endforeach</ul>
            </div>
            @endif
        </div>
    </div>
</div>
@endsection
