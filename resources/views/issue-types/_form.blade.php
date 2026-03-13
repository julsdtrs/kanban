@php $isEdit = isset($issueType) && $issueType; @endphp
<form method="POST" action="{{ $isEdit ? route('issue-types.update', $issueType) : route('issue-types.store') }}" id="crudForm">
    @if($isEdit) @method('PUT') @endif
    @csrf
    <div class="row g-2">
        <div class="col-12">
            <label class="form-label">Name <span class="text-danger">*</span></label>
            <input type="text" class="form-control form-control-sm @error('name') is-invalid @enderror" name="name" value="{{ old('name', optional($issueType)->name ?? '') }}" required maxlength="50">
            @error('name')<div class="invalid-feedback">{{ $message }}</div>@enderror
        </div>
        <div class="col-6">
            <label class="form-label">Icon</label>
            <input type="text" class="form-control form-control-sm @error('icon') is-invalid @enderror" name="icon" value="{{ old('icon', optional($issueType)->icon ?? '') }}" maxlength="100" placeholder="bi-check2-square">
            @error('icon')<div class="invalid-feedback">{{ $message }}</div>@enderror
        </div>
        <div class="col-6">
            <label class="form-label">Color</label>
            <input type="text" class="form-control form-control-sm @error('color') is-invalid @enderror" name="color" value="{{ old('color', optional($issueType)->color ?? '') }}" maxlength="20" placeholder="#198754">
            @error('color')<div class="invalid-feedback">{{ $message }}</div>@enderror
        </div>
    </div>
</form>
