@php $isEdit = isset($sprint) && $sprint; @endphp
<form method="POST" action="{{ $isEdit ? route('sprints.update', $sprint) : route('sprints.store') }}" id="crudForm">
    @if($isEdit) @method('PUT') @endif
    @csrf
    <div class="row g-2">
        <div class="col-12">
            <label class="form-label">Board <span class="text-danger">*</span></label>
            <select class="form-select form-select-sm @error('board_id') is-invalid @enderror" name="board_id" required>
                <option value="">— Select board —</option>
                @foreach(($boards ?? []) as $b)
                <option value="{{ $b->id }}" {{ old('board_id', optional($sprint)->board_id ?? '') == $b->id ? 'selected' : '' }}>{{ $b->project->name ?? 'Project' }} — {{ $b->name ?? 'Board #'.$b->id }}</option>
                @endforeach
            </select>
            @error('board_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
        </div>
        <div class="col-12">
            <label class="form-label">Name</label>
            <input type="text" class="form-control form-control-sm @error('name') is-invalid @enderror" name="name" value="{{ old('name', optional($sprint)->name ?? '') }}" maxlength="150">
            @error('name')<div class="invalid-feedback">{{ $message }}</div>@enderror
        </div>
        <div class="col-12">
            <label class="form-label">Goal</label>
            <textarea class="form-control form-control-sm @error('goal') is-invalid @enderror" name="goal" rows="2">{{ old('goal', optional($sprint)->goal ?? '') }}</textarea>
            @error('goal')<div class="invalid-feedback">{{ $message }}</div>@enderror
        </div>
        <div class="col-6">
            <label class="form-label">Start date</label>
            <input type="date" class="form-control form-control-sm @error('start_date') is-invalid @enderror" name="start_date" value="{{ old('start_date', optional($sprint)->start_date?->format('Y-m-d') ?? '') }}">
            @error('start_date')<div class="invalid-feedback">{{ $message }}</div>@enderror
        </div>
        <div class="col-6">
            <label class="form-label">End date</label>
            <input type="date" class="form-control form-control-sm @error('end_date') is-invalid @enderror" name="end_date" value="{{ old('end_date', optional($sprint)->end_date?->format('Y-m-d') ?? '') }}">
            @error('end_date')<div class="invalid-feedback">{{ $message }}</div>@enderror
        </div>
        <div class="col-12">
            <label class="form-label">State <span class="text-danger">*</span></label>
            <select class="form-select form-select-sm @error('state') is-invalid @enderror" name="state" required>
                <option value="planned" {{ old('state', optional($sprint)->state ?? '') == 'planned' ? 'selected' : '' }}>planned</option>
                <option value="active" {{ old('state', optional($sprint)->state ?? '') == 'active' ? 'selected' : '' }}>active</option>
                <option value="closed" {{ old('state', optional($sprint)->state ?? '') == 'closed' ? 'selected' : '' }}>closed</option>
            </select>
            @error('state')<div class="invalid-feedback">{{ $message }}</div>@enderror
        </div>
    </div>
</form>
