@extends('layouts.app')
@section('title', 'Add Project')
@section('content')
<div class="d-flex justify-content-between align-items-center mb-4"><h1 class="h3 mb-0">Add Project</h1><a href="{{ route('projects.index') }}" class="btn btn-outline-secondary">Back</a></div>
<div class="card border-0 shadow-sm"><div class="card-body">
<form action="{{ route('projects.store') }}" method="POST">@csrf
<div class="mb-3"><label class="form-label">Organization *</label><select class="form-select @error('organization_id') is-invalid @enderror" name="organization_id" required>@foreach($organizations as $org)<option value="{{ $org->id }}" {{ old('organization_id') == $org->id ? 'selected' : '' }}>{{ $org->name }}</option>@endforeach</select>@error('organization_id')<div class="invalid-feedback">{{ $message }}</div>@enderror</div>
<div class="mb-3"><label class="form-label">Project key *</label><input type="text" class="form-control @error('project_key') is-invalid @enderror" name="project_key" value="{{ old('project_key') }}" required maxlength="20">@error('project_key')<div class="invalid-feedback">{{ $message }}</div>@enderror</div>
<div class="mb-3"><label class="form-label">Name *</label><input type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" required maxlength="150">@error('name')<div class="invalid-feedback">{{ $message }}</div>@enderror</div>
<div class="mb-3"><label class="form-label">Description</label><textarea class="form-control @error('description') is-invalid @enderror" name="description" rows="2">{{ old('description') }}</textarea>@error('description')<div class="invalid-feedback">{{ $message }}</div>@enderror</div>
<div class="mb-3"><label class="form-label">Lead user</label><select class="form-select @error('lead_user_id') is-invalid @enderror" name="lead_user_id"><option value="">— None —</option>@foreach($users as $u)<option value="{{ $u->id }}" {{ old('lead_user_id') == $u->id ? 'selected' : '' }}>{{ $u->display_name ?? $u->username }}</option>@endforeach</select>@error('lead_user_id')<div class="invalid-feedback">{{ $message }}</div>@enderror</div>
<div class="mb-3"><label class="form-label">Project type *</label><select class="form-select @error('project_type') is-invalid @enderror" name="project_type" required><option value="scrum" {{ old('project_type') == 'scrum' ? 'selected' : '' }}>Scrum</option><option value="kanban" {{ old('project_type') == 'kanban' ? 'selected' : '' }}>Kanban</option></select>@error('project_type')<div class="invalid-feedback">{{ $message }}</div>@enderror</div>
<div class="mb-3"><div class="form-check form-switch"><input class="form-check-input" type="checkbox" name="is_active" value="1" {{ old('is_active', true) ? 'checked' : '' }}><label class="form-check-label">Active</label></div></div>
<button type="submit" class="btn btn-primary">Create</button>
</form></div></div>
@endsection
