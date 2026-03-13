@extends('layouts.app')
@section('title', 'Edit Organization')
@section('content')
<div class="d-flex justify-content-between align-items-center mb-4"><h1 class="h3 mb-0">Edit Organization</h1><a href="{{ route('organizations.index') }}" class="btn btn-outline-secondary">Back</a></div>
<div class="card border-0 shadow-sm"><div class="card-body">
<form action="{{ route('organizations.update', $organization) }}" method="POST">@csrf @method('PUT')
<div class="mb-3"><label class="form-label">Name *</label><input type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name', $organization->name) }}" required maxlength="150">@error('name')<div class="invalid-feedback">{{ $message }}</div>@enderror</div>
<div class="mb-3"><label class="form-label">Description</label><textarea class="form-control @error('description') is-invalid @enderror" name="description" rows="2">{{ old('description', $organization->description) }}</textarea>@error('description')<div class="invalid-feedback">{{ $message }}</div>@enderror</div>
<button type="submit" class="btn btn-primary">Update</button>
</form></div></div>
@endsection
