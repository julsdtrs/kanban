@extends('layouts.app')
@section('title', 'Teams')
@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h1 class="h3 mb-0 page-title">Teams</h1>
    <button type="button" class="btn btn-primary" id="btn-create-team"><i class="bi bi-plus-lg me-1"></i> Add Team</button>
</div>
<div class="card border-0 shadow-sm setup-list-card">
    <div class="card-header bg-transparent border-bottom py-3"><span class="fw-600 text-body">All teams</span></div>
    <div class="card-body p-0" id="teams-table-container">
        @include('teams._table', ['teams' => $teams])
    </div>
</div>
@include('partials.crud-modal-js', [
    'createButtonId' => 'btn-create-team',
    'createTitle' => 'Add Team',
    'createLoadUrl' => route('teams.create'),
    'createSubmitUrl' => route('teams.store'),
    'refreshUrl' => route('teams.index', ['partial' => 1]),
    'containerSelector' => '#teams-table-container',
])
@endsection
