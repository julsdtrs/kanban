@extends('layouts.app')
@section('title', 'Add Team Member')
@section('content')
<div class="d-flex justify-content-between align-items-center mb-4"><h1 class="h3 mb-0">Add Team Member</h1><a href="{{ route('team-members.index') }}" class="btn btn-outline-secondary">Back</a></div>
<div class="card border-0 shadow-sm"><div class="card-body">
<form action="{{ route('team-members.store') }}" method="POST">@csrf
<div class="mb-3"><label class="form-label">Team *</label><select class="form-select @error('team_id') is-invalid @enderror" name="team_id" required>@foreach($teams as $t)<option value="{{ $t->id }}" {{ old('team_id') == $t->id ? 'selected' : '' }}>{{ $t->name }}</option>@endforeach</select>@error('team_id')<div class="invalid-feedback">{{ $message }}</div>@enderror</div>
<div class="mb-3"><label class="form-label">User *</label><select class="form-select @error('user_id') is-invalid @enderror" name="user_id" required>@foreach($users as $u)<option value="{{ $u->id }}" {{ old('user_id') == $u->id ? 'selected' : '' }}>{{ $u->display_name ?? $u->username }}</option>@endforeach</select>@error('user_id')<div class="invalid-feedback">{{ $message }}</div>@enderror</div>
<div class="mb-3"><label class="form-label">Role in team</label><input type="text" class="form-control @error('role_in_team') is-invalid @enderror" name="role_in_team" value="{{ old('role_in_team') }}" maxlength="100">@error('role_in_team')<div class="invalid-feedback">{{ $message }}</div>@enderror</div>
<button type="submit" class="btn btn-primary">Create</button>
</form></div></div>
@endsection
