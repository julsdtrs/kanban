@php $isEdit = isset($issueLabel) && $issueLabel; @endphp
<form method="POST" action="{{ $isEdit ? route('issue-labels.update', $issueLabel) : route('issue-labels.store') }}" id="crudForm">
    @if($isEdit) @method('PUT') @endif
    @csrf
    <div class="row g-2">
        <div class="col-12">
            <label class="form-label">Name <span class="text-danger">*</span></label>
            <input type="text" class="form-control form-control-sm @error('name') is-invalid @enderror" name="name" value="{{ old('name', optional($issueLabel)->name ?? '') }}" required maxlength="100">
            @error('name')<div class="invalid-feedback">{{ $message }}</div>@enderror
        </div>
        <div class="col-12">
            <label class="form-label">Color</label>
            <input type="text" class="form-control form-control-sm @error('color') is-invalid @enderror" name="color" value="{{ old('color', optional($issueLabel)->color ?? '') }}" maxlength="20" placeholder="#0d6efd">
            @error('color')<div class="invalid-feedback">{{ $message }}</div>@enderror
        </div>
    </div>
</form>
