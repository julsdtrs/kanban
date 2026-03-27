@php $isEdit = isset($workflow) && $workflow; @endphp
<form method="POST" action="{{ $isEdit ? route('workflows.update', $workflow) : route('workflows.store') }}" id="crudForm">
    @if($isEdit) @method('PUT') @endif
    @csrf
    <div class="row g-2">
        <div class="col-12">
            <label class="form-label">Name <span class="text-danger">*</span></label>
            <input type="text" class="form-control form-control-sm @error('name') is-invalid @enderror" name="name" value="{{ old('name', optional($workflow)->name ?? '') }}" required maxlength="150">
            @error('name')<div class="invalid-feedback">{{ $message }}</div>@enderror
        </div>
        <div class="col-12">
            <label class="form-label">Board</label>
            <select class="form-select form-select-sm @error('board_id') is-invalid @enderror" name="board_id">
                <option value="">No board</option>
                @foreach($boards ?? [] as $b)
                <option value="{{ $b->id }}" {{ old('board_id', optional($workflow)->board_id ?? '') == $b->id ? 'selected' : '' }}>{{ $b->name ?? 'Board #'.$b->id }}@if(isset($b->project)) ({{ $b->project->name }})@endif</option>
                @endforeach
            </select>
            @error('board_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
        </div>
    </div>
</form>
