@php $isEdit = isset($member); @endphp
<form method="POST" action="{{ $isEdit ? route('team-members.update', $teamId . '-' . $userId) : route('team-members.store') }}" id="crudForm">
    @if($isEdit) @method('PUT') @endif
    @csrf
    <div class="row g-2">
        <div class="col-12">
            <label class="form-label">Team <span class="text-danger">*</span></label>
            <select class="form-select form-select-sm @error('team_id') is-invalid @enderror" name="team_id" required {{ $isEdit ? 'readonly disabled' : '' }}>
                @foreach($teams as $t)
                <option value="{{ $t->id }}" {{ old('team_id', optional($member)->team_id ?? '') == $t->id ? 'selected' : '' }}>{{ $t->name }}</option>
                @endforeach
            </select>
            @if($isEdit)<input type="hidden" name="team_id" value="{{ $teamId }}">@endif
            @error('team_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
        </div>
        <div class="col-12">
            <label class="form-label">User <span class="text-danger">*</span></label>
            <select class="form-select form-select-sm @error('user_id') is-invalid @enderror" name="user_id" required {{ $isEdit ? 'readonly disabled' : '' }}>
                @foreach($users as $u)
                <option value="{{ $u->id }}" {{ old('user_id', optional($member)->user_id ?? '') == $u->id ? 'selected' : '' }}>{{ $u->display_name ?? $u->username }}</option>
                @endforeach
            </select>
            @if($isEdit)<input type="hidden" name="user_id" value="{{ $userId }}">@endif
            @error('user_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
        </div>
        <div class="col-12">
            <label class="form-label">Role in team</label>
            <input type="text" class="form-control form-control-sm @error('role_in_team') is-invalid @enderror" name="role_in_team" value="{{ old('role_in_team', optional($member)->role_in_team ?? '') }}" maxlength="100">
            @error('role_in_team')<div class="invalid-feedback">{{ $message }}</div>@enderror
        </div>
    </div>
</form>
