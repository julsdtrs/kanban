@php $isEdit = isset($project) && $project; @endphp
<form method="POST" action="{{ $isEdit ? route('projects.update', $project) : route('projects.store') }}" id="crudForm">
    @if($isEdit) @method('PUT') @endif
    @csrf
    <div class="row g-2">
        <div class="col-12">
            <label class="form-label">Organization <span class="text-danger">*</span></label>
            <select class="form-select form-select-sm @error('organization_id') is-invalid @enderror" name="organization_id" required>
                @foreach($organizations as $o)
                <option value="{{ $o->id }}" {{ old('organization_id', optional($project)->organization_id ?? '') == $o->id ? 'selected' : '' }}>{{ $o->name }}</option>
                @endforeach
            </select>
            @error('organization_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
        </div>
        <div class="col-6">
            <label class="form-label">Project key <span class="text-danger">*</span></label>
            <input type="text" class="form-control form-control-sm @error('project_key') is-invalid @enderror" name="project_key" value="{{ old('project_key', optional($project)->project_key ?? '') }}" required maxlength="20" placeholder="PRJ">
            @error('project_key')<div class="invalid-feedback">{{ $message }}</div>@enderror
        </div>
        <div class="col-6">
            <label class="form-label">Name <span class="text-danger">*</span></label>
            <input type="text" class="form-control form-control-sm @error('name') is-invalid @enderror" name="name" value="{{ old('name', optional($project)->name ?? '') }}" required maxlength="150">
            @error('name')<div class="invalid-feedback">{{ $message }}</div>@enderror
        </div>
        <div class="col-12">
            <label class="form-label">Description</label>
            <textarea class="form-control form-control-sm @error('description') is-invalid @enderror" name="description" rows="2">{{ old('description', optional($project)->description ?? '') }}</textarea>
            @error('description')<div class="invalid-feedback">{{ $message }}</div>@enderror
        </div>
        <div class="col-6">
            <label class="form-label">Lead</label>
            <select class="form-select form-select-sm @error('lead_user_id') is-invalid @enderror" name="lead_user_id">
                <option value="">— None —</option>
                @foreach($users as $u)
                <option value="{{ $u->id }}" {{ old('lead_user_id', optional($project)->lead_user_id ?? '') == $u->id ? 'selected' : '' }}>{{ $u->display_name ?? $u->username }}</option>
                @endforeach
            </select>
            @error('lead_user_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
        </div>
        <div class="col-6">
            <label class="form-label">Type <span class="text-danger">*</span></label>
            <select class="form-select form-select-sm @error('project_type') is-invalid @enderror" name="project_type" required>
                <option value="scrum" {{ old('project_type', optional($project)->project_type ?? '') == 'scrum' ? 'selected' : '' }}>scrum</option>
                <option value="kanban" {{ old('project_type', optional($project)->project_type ?? '') == 'kanban' ? 'selected' : '' }}>kanban</option>
            </select>
            @error('project_type')<div class="invalid-feedback">{{ $message }}</div>@enderror
        </div>
        <div class="col-12">
            <div class="form-check form-switch">
                <input class="form-check-input" type="checkbox" name="is_active" value="1" {{ old('is_active', optional($project)->is_active ?? true) ? 'checked' : '' }}>
                <label class="form-check-label">Active</label>
            </div>
        </div>
    </div>
</form>
