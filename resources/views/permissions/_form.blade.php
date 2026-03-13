@php $isEdit = isset($permission) && $permission; @endphp
<form method="POST" action="{{ $isEdit ? route('permissions.update', $permission) : route('permissions.store') }}" id="crudForm">
    @if($isEdit) @method('PUT') @endif
    @csrf
    <div class="row g-2">
        <div class="col-12">
            <label class="form-label">Code <span class="text-danger">*</span></label>
            <input type="text" class="form-control form-control-sm @error('code') is-invalid @enderror" name="code" value="{{ old('code', optional($permission)->code ?? '') }}" required maxlength="100">
            @error('code')<div class="invalid-feedback">{{ $message }}</div>@enderror
        </div>
        <div class="col-12">
            <label class="form-label">Description</label>
            <textarea class="form-control form-control-sm @error('description') is-invalid @enderror" name="description" rows="2">{{ old('description', optional($permission)->description ?? '') }}</textarea>
            @error('description')<div class="invalid-feedback">{{ $message }}</div>@enderror
        </div>
    </div>
</form>
