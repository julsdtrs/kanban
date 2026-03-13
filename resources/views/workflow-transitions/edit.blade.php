@extends('layouts.app')
@section('title', 'Edit Workflow Transition')
@section('content')
<div class="d-flex justify-content-between align-items-center mb-4"><h1 class="h3 mb-0">Edit Workflow Transition</h1><a href="{{ route('workflow-transitions.index') }}" class="btn btn-outline-secondary">Back</a></div>
<div class="card border-0 shadow-sm"><div class="card-body">
<form action="{{ route('workflow-transitions.update', $workflowTransition) }}" method="POST">@csrf @method('PUT')
<div class="mb-3"><label class="form-label">Workflow *</label><select class="form-select @error('workflow_id') is-invalid @enderror" name="workflow_id" required>@foreach($workflows as $w)<option value="{{ $w->id }}" {{ old('workflow_id', $workflowTransition->workflow_id) == $w->id ? 'selected' : '' }}>{{ $w->name }} ({{ $w->project->name ?? '' }})</option>@endforeach</select>@error('workflow_id')<div class="invalid-feedback">{{ $message }}</div>@enderror</div>
<div class="mb-3"><label class="form-label">From status *</label><select class="form-select @error('from_status_id') is-invalid @enderror" name="from_status_id" required>@foreach($statuses as $s)<option value="{{ $s->id }}" {{ old('from_status_id', $workflowTransition->from_status_id) == $s->id ? 'selected' : '' }}>{{ $s->name }}</option>@endforeach</select>@error('from_status_id')<div class="invalid-feedback">{{ $message }}</div>@enderror</div>
<div class="mb-3"><label class="form-label">To status *</label><select class="form-select @error('to_status_id') is-invalid @enderror" name="to_status_id" required>@foreach($statuses as $s)<option value="{{ $s->id }}" {{ old('to_status_id', $workflowTransition->to_status_id) == $s->id ? 'selected' : '' }}>{{ $s->name }}</option>@endforeach</select>@error('to_status_id')<div class="invalid-feedback">{{ $message }}</div>@enderror</div>
<div class="mb-3"><label class="form-label">Transition name</label><input type="text" class="form-control @error('transition_name') is-invalid @enderror" name="transition_name" value="{{ old('transition_name', $workflowTransition->transition_name) }}" maxlength="150">@error('transition_name')<div class="invalid-feedback">{{ $message }}</div>@enderror</div>
<button type="submit" class="btn btn-primary">Update</button>
</form></div></div>
@endsection
