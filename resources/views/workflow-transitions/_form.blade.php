@php $isEdit = isset($workflowTransition) && $workflowTransition; @endphp
<form method="POST" action="{{ $isEdit ? route('workflow-transitions.update', $workflowTransition) : route('workflow-transitions.store') }}" id="crudForm">
    @if($isEdit) @method('PUT') @endif
    @csrf
    <div class="row g-2">
        <div class="col-12">
            <label class="form-label">Workflow <span class="text-danger">*</span></label>
            <select class="form-select form-select-sm @error('workflow_id') is-invalid @enderror" name="workflow_id" required>
                @foreach($workflows as $w)
                <option value="{{ $w->id }}" {{ old('workflow_id', optional($workflowTransition)->workflow_id ?? '') == $w->id ? 'selected' : '' }}>{{ $w->name }} ({{ $w->project->name ?? '' }})</option>
                @endforeach
            </select>
            @error('workflow_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
        </div>
        <div class="col-6">
            <label class="form-label">From status <span class="text-danger">*</span></label>
            <select class="form-select form-select-sm @error('from_status_id') is-invalid @enderror" name="from_status_id" required>
                @foreach($statuses as $s)
                <option value="{{ $s->id }}" {{ old('from_status_id', optional($workflowTransition)->from_status_id ?? '') == $s->id ? 'selected' : '' }}>{{ $s->name }}</option>
                @endforeach
            </select>
            @error('from_status_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
        </div>
        <div class="col-6">
            <label class="form-label">To status <span class="text-danger">*</span></label>
            <select class="form-select form-select-sm @error('to_status_id') is-invalid @enderror" name="to_status_id" required>
                @foreach($statuses as $s)
                <option value="{{ $s->id }}" {{ old('to_status_id', optional($workflowTransition)->to_status_id ?? '') == $s->id ? 'selected' : '' }}>{{ $s->name }}</option>
                @endforeach
            </select>
            @error('to_status_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
        </div>
        <div class="col-12">
            <label class="form-label">Transition name</label>
            <input type="text" class="form-control form-control-sm @error('transition_name') is-invalid @enderror" name="transition_name" value="{{ old('transition_name', optional($workflowTransition)->transition_name ?? '') }}" maxlength="150">
            @error('transition_name')<div class="invalid-feedback">{{ $message }}</div>@enderror
        </div>
    </div>
</form>
