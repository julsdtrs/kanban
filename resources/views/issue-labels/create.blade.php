@extends('layouts.app')
@section('title', 'Add Issue Label')
@section('content')
<div class="d-flex justify-content-between align-items-center mb-4"><h1 class="h3 mb-0">Add Issue Label</h1><a href="{{ route('issue-labels.index') }}" class="btn btn-outline-secondary">Back</a></div>
<div class="card border-0 shadow-sm"><div class="card-body">
<form action="{{ route('issue-labels.store') }}" method="POST">@csrf
<div class="mb-3"><label class="form-label">Name *</label><input type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" required maxlength="100">@error('name')<div class="invalid-feedback">{{ $message }}</div>@enderror</div>
<div class="mb-3"><label class="form-label">Color</label><input type="text" class="form-control @error('color') is-invalid @enderror" name="color" value="{{ old('color') }}" maxlength="20">@error('color')<div class="invalid-feedback">{{ $message }}</div>@enderror</div>
<button type="submit" class="btn btn-primary">Create</button>
</form></div></div>
@endsection
