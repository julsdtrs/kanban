@php $isEdit = isset($item); @endphp
<form method="POST" action="{{ $isEdit ? route('user-roles.update', $userId . '-' . $roleId) : route('user-roles.store') }}" id="crudForm">
    @if($isEdit) @method('PUT') @endif
    @csrf
    <div class="row g-2">
        <div class="col-12">
            <label class="form-label">User <span class="text-danger">*</span></label>
            <select class="form-select form-select-sm @error('user_id') is-invalid @enderror" name="user_id" required {{ $isEdit ? 'readonly disabled' : '' }}>
                @foreach($users as $u)
                <option value="{{ $u->id }}" {{ old('user_id', optional($item)->user_id ?? '') == $u->id ? 'selected' : '' }}>{{ $u->display_name ?? $u->username }}</option>
                @endforeach
            </select>
            <div class="form-text">Pick the person you want to grant access to.</div>
            @if($isEdit)<input type="hidden" name="user_id" value="{{ $userId }}">@endif
            @error('user_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
        </div>
        <div class="col-12">
            <label class="form-label">Role <span class="text-danger">*</span></label>
            <select class="form-select form-select-sm @error('role_id') is-invalid @enderror" name="role_id" required>
                @foreach($roles as $r)
                <option value="{{ $r->id }}" {{ old('role_id', optional($item)->role_id ?? '') == $r->id ? 'selected' : '' }}>{{ $r->name }}</option>
                @endforeach
            </select>
            <div class="form-text">Assign a role that already has the right permissions.</div>
            @error('role_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
        </div>
    </div>
</form>
