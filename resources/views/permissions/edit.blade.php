@extends('layouts.app')
@section('title', 'Edit Permission')
@section('content')
<div class="d-flex justify-content-between align-items-center mb-4"><h1 class="h3 mb-0">Edit Permission</h1><a href="{{ route('permissions.index') }}" class="btn btn-outline-secondary">Back</a></div>
<div class="card border-0 shadow-sm"><div class="card-body">
<form action="{{ route('permissions.update', $permission) }}" method="POST">@csrf @method('PUT')
<div class="mb-3"><label class="form-label">Code *</label><input type="text" class="form-control @error('code') is-invalid @enderror" name="code" value="{{ old('code', $permission->code) }}" required maxlength="100">@error('code')<div class="invalid-feedback">{{ $message }}</div>@enderror</div>
<div class="mb-3"><label class="form-label">Description</label><textarea class="form-control @error('description') is-invalid @enderror" name="description" rows="2">{{ old('description', $permission->description) }}</textarea>@error('description')<div class="invalid-feedback">{{ $message }}</div>@enderror</div>
<button type="submit" class="btn btn-primary">Update</button>
</form></div></div>
@endsection
