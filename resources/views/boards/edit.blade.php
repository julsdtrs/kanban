@extends('layouts.app')
@section('title', 'Edit Board')
@section('content')
<div class="d-flex justify-content-between align-items-center mb-4"><h1 class="h3 mb-0">Edit Board</h1><a href="{{ route('boards.index') }}" class="btn btn-outline-secondary">Back</a></div>
<div class="card border-0 shadow-sm"><div class="card-body">
<form action="{{ route('boards.update', $board) }}" method="POST">@csrf @method('PUT')
<div class="mb-3"><label class="form-label">Project *</label><select class="form-select @error('project_id') is-invalid @enderror" name="project_id" required>@foreach($projects as $p)<option value="{{ $p->id }}" {{ old('project_id', $board->project_id) == $p->id ? 'selected' : '' }}>{{ $p->name }}</option>@endforeach</select>@error('project_id')<div class="invalid-feedback">{{ $message }}</div>@enderror</div>
<div class="mb-3"><label class="form-label">Name</label><input type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name', $board->name) }}" maxlength="150">@error('name')<div class="invalid-feedback">{{ $message }}</div>@enderror</div>
<div class="mb-3"><label class="form-label">Board type *</label><select class="form-select @error('board_type') is-invalid @enderror" name="board_type" required><option value="scrum" {{ old('board_type', $board->board_type) == 'scrum' ? 'selected' : '' }}>Scrum</option><option value="kanban" {{ old('board_type', $board->board_type) == 'kanban' ? 'selected' : '' }}>Kanban</option></select>@error('board_type')<div class="invalid-feedback">{{ $message }}</div>@enderror</div>
<button type="submit" class="btn btn-primary">Update</button>
</form></div></div>
@endsection
