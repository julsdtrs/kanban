@extends('layouts.app')
@section('title', 'Edit Workflow')
@section('content')
<div class="d-flex justify-content-between align-items-center mb-4"><h1 class="h3 mb-0">Edit Workflow</h1><a href="{{ route('workflows.index') }}" class="btn btn-outline-secondary">Back</a></div>
<div class="card border-0 shadow-sm"><div class="card-body">
<form action="{{ route('workflows.update', $workflow) }}" method="POST">@csrf @method('PUT')
<div class="mb-3"><label class="form-label">Name *</label><input type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name', $workflow->name) }}" required maxlength="150">@error('name')<div class="invalid-feedback">{{ $message }}</div>@enderror</div>
<div class="mb-3"><label class="form-label">Board *</label><select class="form-select @error('board_id') is-invalid @enderror" name="board_id" required>@foreach($boards as $b)<option value="{{ $b->id }}" {{ old('board_id', $workflow->board_id) == $b->id ? 'selected' : '' }}>{{ $b->name ?? 'Board #'.$b->id }}@if(isset($b->project)) ({{ $b->project->name }})@endif</option>@endforeach</select>@error('board_id')<div class="invalid-feedback">{{ $message }}</div>@enderror</div>
<button type="submit" class="btn btn-primary">Update</button>
</form></div></div>
@endsection
