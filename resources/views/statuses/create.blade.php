@extends('layouts.app')
@section('title', 'Add Status')
@section('content')
<div class="d-flex justify-content-between align-items-center mb-4"><h1 class="h3 mb-0">Add Status</h1><a href="{{ route('statuses.index') }}" class="btn btn-outline-secondary">Back</a></div>
<div class="card border-0 shadow-sm"><div class="card-body">
<form action="{{ route('statuses.store') }}" method="POST">@csrf
<div class="mb-3"><label class="form-label">Name *</label><input type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" required maxlength="50">@error('name')<div class="invalid-feedback">{{ $message }}</div>@enderror</div>
<div class="mb-3"><label class="form-label">Category *</label><select class="form-select @error('category') is-invalid @enderror" name="category" required><option value="todo" {{ old('category') == 'todo' ? 'selected' : '' }}>Todo</option><option value="in_progress" {{ old('category') == 'in_progress' ? 'selected' : '' }}>In progress</option><option value="done" {{ old('category') == 'done' ? 'selected' : '' }}>Done</option></select>@error('category')<div class="invalid-feedback">{{ $message }}</div>@enderror</div>
<div class="mb-3"><label class="form-label">Color</label><input type="text" class="form-control @error('color') is-invalid @enderror" name="color" value="{{ old('color') }}" maxlength="20" placeholder="#hex or name">@error('color')<div class="invalid-feedback">{{ $message }}</div>@enderror</div>
<div class="mb-3"><label class="form-label">Order</label><input type="number" class="form-control @error('order_no') is-invalid @enderror" name="order_no" value="{{ old('order_no', 0) }}">@error('order_no')<div class="invalid-feedback">{{ $message }}</div>@enderror</div>
<button type="submit" class="btn btn-primary">Create</button>
</form></div></div>
@endsection
