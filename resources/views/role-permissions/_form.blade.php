@php $isEdit = isset($item); @endphp
<form method="POST" action="{{ $isEdit ? route('role-permissions.update', $roleId . '-' . $permissionId) : route('role-permissions.store') }}" id="crudForm">
    @if($isEdit) @method('PUT') @endif
    @csrf
    <div class="row g-2">
        <div class="col-12">
            <label class="form-label">Role <span class="text-danger">*</span></label>
            <select class="form-select form-select-sm @error('role_id') is-invalid @enderror" name="role_id" required>
                @foreach($roles as $r)
                <option value="{{ $r->id }}" {{ old('role_id', optional($item)->role_id ?? '') == $r->id ? 'selected' : '' }}>{{ $r->name }}</option>
                @endforeach
            </select>
            @error('role_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
            <div class="form-text">Choose which role you are adding permissions to.</div>
        </div>
        <div class="col-12">
            <label class="form-label">Permission <span class="text-danger">*</span></label>
            <select class="form-select form-select-sm @error('permission_id') is-invalid @enderror" name="permission_id" required>
                @foreach($permissions as $p)
                <option value="{{ $p->id }}" {{ old('permission_id', optional($item)->permission_id ?? '') == $p->id ? 'selected' : '' }}>{{ $p->code }}</option>
                @endforeach
            </select>
            <div class="form-text">Select a specific capability to grant to this role.</div>
            @error('permission_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
        </div>
    </div>
</form>
