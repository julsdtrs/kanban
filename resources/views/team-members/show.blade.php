@extends('layouts.app')
@section('title', 'Team Member')
@section('content')
<div class="setup-detail-page">
    <div class="d-flex justify-content-between align-items-center setup-detail-header">
        <h1 class="h4 mb-0 fw-600">Team Member</h1>
        <div class="btn-group">
            <a href="{{ route('team-members.edit', $member->team_id . '-' . $member->user_id) }}" class="btn btn-primary"><i class="bi bi-pencil me-1"></i> Edit</a>
            <a href="{{ route('team-members.index') }}" class="btn btn-outline-secondary"><i class="bi bi-arrow-left me-1"></i> Back</a>
        </div>
    </div>
    <div class="card setup-detail-card">
        <div class="card-header">Details</div>
        <div class="card-body">
            <dl class="row mb-0">
                <dt class="col-sm-3">Team</dt><dd class="col-sm-9">{{ $member->team_name ?? $member->team_id }}</dd>
                <dt class="col-sm-3">User</dt><dd class="col-sm-9">{{ $member->display_name ?? $member->username ?? $member->user_id }}</dd>
                <dt class="col-sm-3">Role in team</dt><dd class="col-sm-9">{{ $member->role_in_team ?? '-' }}</dd>
            </dl>
        </div>
    </div>
</div>
@endsection
