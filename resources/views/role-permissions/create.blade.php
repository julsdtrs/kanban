@extends('layouts.app')
@section('title', 'Add Role Permission')
@section('content')
<div class="d-flex justify-content-between align-items-center mb-4"><h1 class="h3 mb-0">Add Role Permission</h1><a href="{{ route('role-permissions.index') }}" class="btn btn-outline-secondary">Back</a></div>
<div class="card border-0 shadow-sm"><div class="card-body">
<form action="{{ route('role-permissions.store') }}" method="POST">@csrf
<div class="mb-3"><label class="form-label">Role *</label><select class="form-select @error('role_id') is-invalid @enderror" name="role_id" required>@foreach($roles as $r)<option value="{{ $r->id }}" {{ old('role_id') == $r->id ? 'selected' : '' }}>{{ $r->name }}</option>@endforeach</select>@error('role_id')<div class="invalid-feedback">{{ $message }}</div>@enderror</div>
<div class="mb-3"><label class="form-label">Permission *</label><select class="form-select @error('permission_id') is-invalid @enderror" name="permission_id" required>@foreach($permissions as $p)<option value="{{ $p->id }}" {{ old('permission_id') == $p->id ? 'selected' : '' }}>{{ $p->code }}</option>@endforeach</select>@error('permission_id')<div class="invalid-feedback">{{ $message }}</div>@enderror</div>
<button type="submit" class="btn btn-primary">Create</button>
</form></div></div>
@endsection
