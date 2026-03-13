@extends('layouts.app')
@section('title', 'Edit Role Permission')
@section('content')
<div class="d-flex justify-content-between align-items-center mb-4"><h1 class="h3 mb-0">Edit Role Permission</h1><a href="{{ route('role-permissions.index') }}" class="btn btn-outline-secondary">Back</a></div>
<div class="card border-0 shadow-sm"><div class="card-body">
<form action="{{ route('role-permissions.update', $roleId . '-' . $permissionId) }}" method="POST">@csrf @method('PUT')
<div class="mb-3"><label class="form-label">Role *</label><select class="form-select @error('role_id') is-invalid @enderror" name="role_id" required>@foreach($roles as $r)<option value="{{ $r->id }}" {{ old('role_id', $item->role_id) == $r->id ? 'selected' : '' }}>{{ $r->name }}</option>@endforeach</select>@error('role_id')<div class="invalid-feedback">{{ $message }}</div>@enderror</div>
<div class="mb-3"><label class="form-label">Permission *</label><select class="form-select @error('permission_id') is-invalid @enderror" name="permission_id" required>@foreach($permissions as $p)<option value="{{ $p->id }}" {{ old('permission_id', $item->permission_id) == $p->id ? 'selected' : '' }}>{{ $p->code }}</option>@endforeach</select>@error('permission_id')<div class="invalid-feedback">{{ $message }}</div>@enderror</div>
<button type="submit" class="btn btn-primary">Update</button>
</form></div></div>
@endsection
