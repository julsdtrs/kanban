@extends('layouts.app')
@section('title', 'Edit Issue Type')
@section('content')
<div class="d-flex justify-content-between align-items-center mb-4"><h1 class="h3 mb-0">Edit Issue Type</h1><a href="{{ route('issue-types.index') }}" class="btn btn-outline-secondary">Back</a></div>
<div class="card border-0 shadow-sm"><div class="card-body">
<form action="{{ route('issue-types.update', $issueType) }}" method="POST">@csrf @method('PUT')
<div class="mb-3"><label class="form-label">Name *</label><input type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name', $issueType->name) }}" required maxlength="50">@error('name')<div class="invalid-feedback">{{ $message }}</div>@enderror</div>
<div class="mb-3"><label class="form-label">Icon</label><input type="text" class="form-control @error('icon') is-invalid @enderror" name="icon" value="{{ old('icon', $issueType->icon) }}" maxlength="100">@error('icon')<div class="invalid-feedback">{{ $message }}</div>@enderror</div>
<div class="mb-3"><label class="form-label">Color</label><input type="text" class="form-control @error('color') is-invalid @enderror" name="color" value="{{ old('color', $issueType->color) }}" maxlength="20">@error('color')<div class="invalid-feedback">{{ $message }}</div>@enderror</div>
<button type="submit" class="btn btn-primary">Update</button>
</form></div></div>
@endsection
