@php $isEdit = isset($user) && $user; @endphp
<form method="POST" action="{{ $isEdit ? route('users.update', $user) : route('users.store') }}" id="crudForm">
    @if($isEdit) @method('PUT') @endif
    @csrf
    <div class="row g-2">
        <div class="col-12">
            <label class="form-label">Username <span class="text-danger">*</span></label>
            <input type="text" class="form-control form-control-sm @error('username') is-invalid @enderror" name="username" value="{{ old('username', optional($user)->username ?? '') }}" required maxlength="100">
            @error('username')<div class="invalid-feedback">{{ $message }}</div>@enderror
        </div>
        <div class="col-12">
            <label class="form-label">Email <span class="text-danger">*</span></label>
            <input type="email" class="form-control form-control-sm @error('email') is-invalid @enderror" name="email" value="{{ old('email', optional($user)->email ?? '') }}" required maxlength="150">
            @error('email')<div class="invalid-feedback">{{ $message }}</div>@enderror
        </div>
        <div class="col-12">
            <label class="form-label">Display name</label>
            <input type="text" class="form-control form-control-sm @error('display_name') is-invalid @enderror" name="display_name" value="{{ old('display_name', optional($user)->display_name ?? '') }}" maxlength="150">
            @error('display_name')<div class="invalid-feedback">{{ $message }}</div>@enderror
        </div>
        <div class="col-12">
            <label class="form-label">Password @if($isEdit)<span class="text-muted">(leave blank to keep)</span>@else<span class="text-danger">*</span>@endif</label>
            <input type="password" class="form-control form-control-sm @error('password') is-invalid @enderror" name="password" {{ $isEdit ? '' : 'required' }} minlength="8">
            @error('password')<div class="invalid-feedback">{{ $message }}</div>@enderror
        </div>
        <div class="col-12">
            <div class="form-check form-switch">
                <input class="form-check-input" type="checkbox" name="is_active" value="1" {{ old('is_active', optional($user)->is_active ?? true) ? 'checked' : '' }}>
                <label class="form-check-label">Active</label>
            </div>
        </div>
    </div>
</form>
