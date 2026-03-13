@php $isEdit = isset($priority) && $priority; @endphp
<form method="POST" action="{{ $isEdit ? route('priorities.update', $priority) : route('priorities.store') }}" id="crudForm">
    @if($isEdit) @method('PUT') @endif
    @csrf
    <div class="row g-2">
        <div class="col-12">
            <label class="form-label">Name <span class="text-danger">*</span></label>
            <input type="text" class="form-control form-control-sm @error('name') is-invalid @enderror" name="name" value="{{ old('name', optional($priority)->name ?? '') }}" required maxlength="50">
            @error('name')<div class="invalid-feedback">{{ $message }}</div>@enderror
        </div>
        <div class="col-6">
            <label class="form-label">Level</label>
            <input type="number" class="form-control form-control-sm @error('level') is-invalid @enderror" name="level" value="{{ old('level', optional($priority)->level ?? 0) }}">
            @error('level')<div class="invalid-feedback">{{ $message }}</div>@enderror
        </div>
        <div class="col-6">
            <label class="form-label">Color</label>
            <input type="text" class="form-control form-control-sm @error('color') is-invalid @enderror" name="color" value="{{ old('color', optional($priority)->color ?? '') }}" maxlength="20" placeholder="#dc3545">
            @error('color')<div class="invalid-feedback">{{ $message }}</div>@enderror
        </div>
    </div>
</form>
