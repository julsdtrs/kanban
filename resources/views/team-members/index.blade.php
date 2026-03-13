@extends('layouts.app')
@section('title', 'Team Members')
@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h1 class="h3 mb-0 page-title">Team Members</h1>
    <button type="button" class="btn btn-primary" id="btn-create-team-member"><i class="bi bi-plus-lg me-1"></i> Add Member</button>
</div>
<div class="card border-0 shadow-sm setup-list-card">
    <div class="card-header bg-transparent border-bottom py-3"><span class="fw-600 text-body">All team members</span></div>
    <div class="card-body p-0" id="team-members-table-container">
        @include('team-members._table', ['members' => $members, 'teams' => $teams])
    </div>
</div>
@include('partials.crud-modal-js', [
    'createButtonId' => 'btn-create-team-member',
    'createTitle' => 'Add Team Member',
    'createLoadUrl' => route('team-members.create'),
    'createSubmitUrl' => route('team-members.store'),
    'refreshUrl' => route('team-members.index', array_merge(request()->only('team_id'), ['partial' => 1])),
    'containerSelector' => '#team-members-table-container',
])
@endsection
