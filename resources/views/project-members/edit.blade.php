@extends('layouts.app')
@section('title', 'Edit Project Member')
@section('content')
<div class="d-flex justify-content-between align-items-center mb-4"><h1 class="h3 mb-0">Edit Project Member</h1><a href="{{ route('project-members.index') }}" class="btn btn-outline-secondary">Back</a></div>
<div class="card border-0 shadow-sm"><div class="card-body">
<form action="{{ route('project-members.update', $projectId . '-' . $userId) }}" method="POST">@csrf @method('PUT')
<div class="mb-3"><label class="form-label">Project *</label><select class="form-select @error('project_id') is-invalid @enderror" name="project_id" required>@foreach($projects as $p)<option value="{{ $p->id }}" {{ old('project_id', $item->project_id) == $p->id ? 'selected' : '' }}>{{ $p->name }}</option>@endforeach</select>@error('project_id')<div class="invalid-feedback">{{ $message }}</div>@enderror</div>
<div class="mb-3"><label class="form-label">User *</label><select class="form-select @error('user_id') is-invalid @enderror" name="user_id" required>@foreach($users as $u)<option value="{{ $u->id }}" {{ old('user_id', $item->user_id) == $u->id ? 'selected' : '' }}>{{ $u->display_name ?? $u->username }}</option>@endforeach</select>@error('user_id')<div class="invalid-feedback">{{ $message }}</div>@enderror</div>
<div class="mb-3"><label class="form-label">Role *</label><select class="form-select @error('role_id') is-invalid @enderror" name="role_id" required>@foreach($roles as $r)<option value="{{ $r->id }}" {{ old('role_id', $item->role_id) == $r->id ? 'selected' : '' }}>{{ $r->name }}</option>@endforeach</select>@error('role_id')<div class="invalid-feedback">{{ $message }}</div>@enderror</div>
<button type="submit" class="btn btn-primary">Update</button>
</form></div></div>
@endsection
