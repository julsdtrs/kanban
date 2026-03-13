@extends('layouts.app')
@section('title', 'Add Sprint')
@section('content')
<div class="d-flex justify-content-between align-items-center mb-4"><h1 class="h3 mb-0">Add Sprint</h1><a href="{{ route('sprints.index') }}" class="btn btn-outline-secondary">Back</a></div>
<div class="card border-0 shadow-sm"><div class="card-body">
<form action="{{ route('sprints.store') }}" method="POST">@csrf
<div class="mb-3"><label class="form-label">Board *</label><select class="form-select @error('board_id') is-invalid @enderror" name="board_id" required>@foreach($boards as $b)<option value="{{ $b->id }}" {{ old('board_id') == $b->id ? 'selected' : '' }}>{{ $b->name ?? $b->project->name }} ({{ $b->project->name ?? '' }})</option>@endforeach</select>@error('board_id')<div class="invalid-feedback">{{ $message }}</div>@enderror</div>
<div class="mb-3"><label class="form-label">Name</label><input type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" maxlength="150">@error('name')<div class="invalid-feedback">{{ $message }}</div>@enderror</div>
<div class="mb-3"><label class="form-label">Goal</label><textarea class="form-control @error('goal') is-invalid @enderror" name="goal" rows="2">{{ old('goal') }}</textarea>@error('goal')<div class="invalid-feedback">{{ $message }}</div>@enderror</div>
<div class="mb-3"><label class="form-label">Start date</label><input type="date" class="form-control @error('start_date') is-invalid @enderror" name="start_date" value="{{ old('start_date') }}">@error('start_date')<div class="invalid-feedback">{{ $message }}</div>@enderror</div>
<div class="mb-3"><label class="form-label">End date</label><input type="date" class="form-control @error('end_date') is-invalid @enderror" name="end_date" value="{{ old('end_date') }}">@error('end_date')<div class="invalid-feedback">{{ $message }}</div>@enderror</div>
<div class="mb-3"><label class="form-label">State *</label><select class="form-select @error('state') is-invalid @enderror" name="state" required><option value="planned" {{ old('state') == 'planned' ? 'selected' : '' }}>Planned</option><option value="active" {{ old('state') == 'active' ? 'selected' : '' }}>Active</option><option value="closed" {{ old('state') == 'closed' ? 'selected' : '' }}>Closed</option></select>@error('state')<div class="invalid-feedback">{{ $message }}</div>@enderror</div>
<button type="submit" class="btn btn-primary">Create</button>
</form></div></div>
@endsection
