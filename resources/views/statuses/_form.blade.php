@php $isEdit = isset($status) && $status; @endphp
<form method="POST" action="{{ $isEdit ? route('statuses.update', $status) : route('statuses.store') }}" id="crudForm">
    @if($isEdit) @method('PUT') @endif
    @csrf
    <div class="row g-2">
        <div class="col-12">
            <label class="form-label">Name <span class="text-danger">*</span></label>
            <input type="text" class="form-control form-control-sm @error('name') is-invalid @enderror" name="name" value="{{ old('name', optional($status)->name ?? '') }}" required maxlength="50">
            @error('name')<div class="invalid-feedback">{{ $message }}</div>@enderror
        </div>
        <div class="col-6">
            <label class="form-label">Color</label>
            <input type="text" class="form-control form-control-sm @error('color') is-invalid @enderror" name="color" value="{{ old('color', optional($status)->color ?? '') }}" maxlength="20" placeholder="#198754">
            @error('color')<div class="invalid-feedback">{{ $message }}</div>@enderror
        </div>
        <div class="col-12">
            <label class="form-label">Order</label>
            <input type="number" class="form-control form-control-sm @error('order_no') is-invalid @enderror" name="order_no" value="{{ old('order_no', optional($status)->order_no ?? 0) }}">
            @error('order_no')<div class="invalid-feedback">{{ $message }}</div>@enderror
        </div>
    </div>
</form>
