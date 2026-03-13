@php $isEdit = isset($team) && $team; @endphp
<form method="POST" action="{{ $isEdit ? route('teams.update', $team) : route('teams.store') }}" id="crudForm">
    @if($isEdit) @method('PUT') @endif
    @csrf
    <div class="row g-2">
        <div class="col-12">
            <label class="form-label">Name <span class="text-danger">*</span></label>
            <input type="text" class="form-control form-control-sm @error('name') is-invalid @enderror" name="name" value="{{ old('name', optional($team)->name ?? '') }}" required maxlength="150">
            @error('name')<div class="invalid-feedback">{{ $message }}</div>@enderror
        </div>
        <div class="col-12">
            <label class="form-label">Description</label>
            <textarea class="form-control form-control-sm @error('description') is-invalid @enderror" name="description" rows="2">{{ old('description', optional($team)->description ?? '') }}</textarea>
            @error('description')<div class="invalid-feedback">{{ $message }}</div>@enderror
        </div>
        <div class="col-12">
            <label class="form-label">Projects</label>
            <select class="form-select form-select-sm @error('project_ids') is-invalid @enderror" name="project_ids[]" multiple size="4">
                @foreach($projects ?? [] as $p)
                <option value="{{ $p->id }}" {{ in_array($p->id, old('project_ids', $isEdit ? $team->projects->pluck('id')->all() : [])) ? 'selected' : '' }}>{{ $p->name }} ({{ $p->project_key }})</option>
                @endforeach
            </select>
            <small class="text-muted">Hold Ctrl/Cmd to select multiple projects.</small>
            @error('project_ids')<div class="invalid-feedback">{{ $message }}</div>@enderror
        </div>
    </div>
</form>
