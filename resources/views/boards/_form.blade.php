@php $isEdit = isset($board) && $board; @endphp
<form method="POST" action="{{ $isEdit ? route('boards.update', $board) : route('boards.store') }}" id="crudForm">
    @if($isEdit) @method('PUT') @endif
    @csrf
    <div class="row g-2">
        <div class="col-12">
            <label class="form-label">Projects <span class="text-danger">*</span></label>
            <select class="form-select form-select-sm @error('project_ids') is-invalid @enderror" name="project_ids[]" multiple size="5">
                @foreach($projects as $p)
                <option value="{{ $p->id }}" {{ in_array($p->id, old('project_ids', $isEdit ? $board->projects->pluck('id')->all() : [])) ? 'selected' : '' }}>{{ $p->name }} ({{ $p->project_key }})</option>
                @endforeach
            </select>
            <small class="text-muted">Hold Ctrl/Cmd to select multiple projects.</small>
            @error('project_ids')<div class="invalid-feedback">{{ $message }}</div>@enderror
        </div>
        <div class="col-12">
            <label class="form-label">Name</label>
            <input type="text" class="form-control form-control-sm @error('name') is-invalid @enderror" name="name" value="{{ old('name', optional($board)->name ?? '') }}" maxlength="150">
            @error('name')<div class="invalid-feedback">{{ $message }}</div>@enderror
        </div>
        <div class="col-12">
            <label class="form-label">Board type <span class="text-danger">*</span></label>
            <select class="form-select form-select-sm @error('board_type') is-invalid @enderror" name="board_type" required>
                <option value="scrum" {{ old('board_type', optional($board)->board_type ?? '') == 'scrum' ? 'selected' : '' }}>scrum</option>
                <option value="kanban" {{ old('board_type', optional($board)->board_type ?? '') == 'kanban' ? 'selected' : '' }}>kanban</option>
            </select>
            @error('board_type')<div class="invalid-feedback">{{ $message }}</div>@enderror
        </div>
        @if($isEdit && isset($workflows) && $workflows->isNotEmpty())
        <div class="col-12">
            <label class="form-label">Workflow diagram for this board</label>
            <select class="form-select form-select-sm @error('workflow_id') is-invalid @enderror" name="workflow_id" size="4">
                <option value="">— Use default project workflow —</option>
                @php
                    $selectedWorkflowId = (int) old('workflow_id', optional($board->workflows->first())->id ?? 0);
                @endphp
                @foreach($workflows as $w)
                    <option value="{{ $w->id }}" {{ $w->id === $selectedWorkflowId ? 'selected' : '' }}>
                        {{ $w->name }} @if($w->project) ({{ $w->project->name }} - {{ $w->project->project_key }}) @endif
                    </option>
                @endforeach
            </select>
            <small class="text-muted">Only one workflow diagram can be selected. It will be used for this board&apos;s Kanban status workflow transitions.</small>
            @error('workflow_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
        </div>
        @endif
    </div>
</form>
