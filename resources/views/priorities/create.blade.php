@extends('layouts.app')
@section('title', 'Add Priority')
@section('content')
<div class="d-flex justify-content-between align-items-center mb-4"><h1 class="h3 mb-0">Add Priority</h1><a href="{{ route('priorities.index') }}" class="btn btn-outline-secondary">Back</a></div>
<div class="card border-0 shadow-sm"><div class="card-body">
<form action="{{ route('priorities.store') }}" method="POST">@csrf
<div class="mb-3"><label class="form-label">Name *</label><input type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" required maxlength="50">@error('name')<div class="invalid-feedback">{{ $message }}</div>@enderror</div>
<div class="mb-3"><label class="form-label">Level</label><input type="number" class="form-control @error('level') is-invalid @enderror" name="level" value="{{ old('level', 0) }}">@error('level')<div class="invalid-feedback">{{ $message }}</div>@enderror</div>
<div class="mb-3"><label class="form-label">Color</label><input type="text" class="form-control @error('color') is-invalid @enderror" name="color" value="{{ old('color') }}" maxlength="20">@error('color')<div class="invalid-feedback">{{ $message }}</div>@enderror</div>
<button type="submit" class="btn btn-primary">Create</button>
</form></div></div>
@endsection
