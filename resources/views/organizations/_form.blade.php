@php $isEdit = isset($organization) && $organization; @endphp
<form method="POST" action="{{ $isEdit ? route('organizations.update', $organization) : route('organizations.store') }}" id="crudForm">
    @if($isEdit) @method('PUT') @endif
    @csrf
    <div class="row g-2">
        <div class="col-12">
            <label class="form-label">Name <span class="text-danger">*</span></label>
            <input type="text" class="form-control form-control-sm @error('name') is-invalid @enderror" name="name" value="{{ old('name', optional($organization)->name ?? '') }}" required maxlength="150">
            @error('name')<div class="invalid-feedback">{{ $message }}</div>@enderror
        </div>
        <div class="col-12">
            <label class="form-label">Description</label>
            <textarea class="form-control form-control-sm @error('description') is-invalid @enderror" name="description" rows="2">{{ old('description', optional($organization)->description ?? '') }}</textarea>
            @error('description')<div class="invalid-feedback">{{ $message }}</div>@enderror
        </div>
    </div>
</form>
