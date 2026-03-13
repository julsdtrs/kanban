@extends('layouts.app')
@section('title', 'Edit User Role')
@section('content')
<div class="d-flex justify-content-between align-items-center mb-4"><h1 class="h3 mb-0">Edit User Role</h1><a href="{{ route('user-roles.index') }}" class="btn btn-outline-secondary">Back</a></div>
<div class="card border-0 shadow-sm"><div class="card-body">
<form action="{{ route('user-roles.update', $userId . '-' . $roleId) }}" method="POST">@csrf @method('PUT')
<div class="mb-3"><label class="form-label">User *</label><select class="form-select @error('user_id') is-invalid @enderror" name="user_id" required>@foreach($users as $u)<option value="{{ $u->id }}" {{ old('user_id', $item->user_id) == $u->id ? 'selected' : '' }}>{{ $u->display_name ?? $u->username }}</option>@endforeach</select>@error('user_id')<div class="invalid-feedback">{{ $message }}</div>@enderror</div>
<div class="mb-3"><label class="form-label">Role *</label><select class="form-select @error('role_id') is-invalid @enderror" name="role_id" required>@foreach($roles as $r)<option value="{{ $r->id }}" {{ old('role_id', $item->role_id) == $r->id ? 'selected' : '' }}>{{ $r->name }}</option>@endforeach</select>@error('role_id')<div class="invalid-feedback">{{ $message }}</div>@enderror</div>
<button type="submit" class="btn btn-primary">Update</button>
</form></div></div>
@endsection
