@extends('layouts.app')
@section('title', 'New Issue')
@section('content')
<div class="issue-create-page">
<div class="d-flex justify-content-between align-items-center mb-4 issue-create-page-header">
    <h1 class="h3 mb-0 page-title">New Issue</h1>
    <a href="{{ route('issues.index') }}" class="btn btn-outline-secondary">
        <i class="bi bi-arrow-left me-1"></i> Back
    </a>
</div>

<div class="card border-0 shadow-sm issue-create-card">
    <div class="card-header bg-transparent border-bottom py-3 flex-shrink-0">
        <span class="fw-600 text-body">Create issue details</span>
    </div>
    <div class="card-body p-4 issue-create-scroll scrollable">
        <form action="{{ route('issues.store') }}" method="POST">
            @csrf

            <div class="mb-4">
                <div class="text-uppercase small fw-semibold text-muted mb-2">Basics</div>
                <div class="row g-3">
                    <div class="col-md-6">
                        <label class="form-label">Project <span class="text-danger">*</span></label>
                        <select class="form-select @error('project_id') is-invalid @enderror" name="project_id" required id="issue-project">
                            @foreach($projects as $p)
                            <option value="{{ $p->id }}" {{ old('project_id', request('project_id')) == $p->id ? 'selected' : '' }}>{{ $p->name }}</option>
                            @endforeach
                        </select>
                        @error('project_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Issue type <span class="text-danger">*</span></label>
                        <select class="form-select @error('issue_type_id') is-invalid @enderror" name="issue_type_id" required>
                            @foreach($issueTypes as $t)
                            <option value="{{ $t->id }}" {{ old('issue_type_id') == $t->id ? 'selected' : '' }}>{{ $t->name }}</option>
                            @endforeach
                        </select>
                        @error('issue_type_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div class="col-12">
                        <label class="form-label">Summary <span class="text-danger">*</span></label>
                        <input type="text" class="form-control @error('summary') is-invalid @enderror" name="summary" value="{{ old('summary') }}" required maxlength="255" placeholder="Briefly describe the issue">
                        @error('summary')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div class="col-12">
                        <label class="form-label">Description</label>
                        <textarea id="issue-description-editor" class="form-control @error('description') is-invalid @enderror" name="description" rows="8" placeholder="Add context, expected behavior, and acceptance notes">{{ old('description') }}</textarea>
                        @error('description')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                </div>
            </div>

            <hr class="my-4">

            <div class="mb-4">
                <div class="text-uppercase small fw-semibold text-muted mb-2">Planning</div>
                <div class="row g-3">
                    <div class="col-md-6">
                        <label class="form-label">Priority</label>
                        <select class="form-select @error('priority_id') is-invalid @enderror" name="priority_id">
                            <option value="">— None —</option>
                            @foreach($priorities as $p)
                            <option value="{{ $p->id }}" {{ old('priority_id') == $p->id ? 'selected' : '' }}>{{ $p->name }}</option>
                            @endforeach
                        </select>
                        @error('priority_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Status</label>
                        <select class="form-select @error('status_id') is-invalid @enderror" name="status_id">
                            <option value="">— None —</option>
                            @foreach($statuses as $s)
                            <option value="{{ $s->id }}" {{ old('status_id') == $s->id ? 'selected' : '' }}>{{ $s->name }}</option>
                            @endforeach
                        </select>
                        @error('status_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Reporter</label>
                        <select class="form-select @error('reporter_id') is-invalid @enderror" name="reporter_id">
                            <option value="">— None —</option>
                            @foreach($users as $u)
                            <option value="{{ $u->id }}" {{ old('reporter_id', auth()->id()) == $u->id ? 'selected' : '' }}>{{ $u->display_name ?? $u->username }}</option>
                            @endforeach
                        </select>
                        @error('reporter_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Assignee</label>
                        <select class="form-select @error('assignee_id') is-invalid @enderror" name="assignee_id">
                            <option value="">— None —</option>
                            @foreach($users as $u)
                            <option value="{{ $u->id }}" {{ old('assignee_id') == $u->id ? 'selected' : '' }}>{{ $u->display_name ?? $u->username }}</option>
                            @endforeach
                        </select>
                        @error('assignee_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Story points</label>
                        <input type="number" step="any" min="0" class="form-control @error('story_points') is-invalid @enderror" name="story_points" value="{{ old('story_points') }}" placeholder="e.g. 1, 2, 3, 5, 8">
                        @error('story_points')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Due date</label>
                        <input type="date" class="form-control @error('due_date') is-invalid @enderror" name="due_date" value="{{ old('due_date') }}">
                        @error('due_date')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                </div>
            </div>

            <hr class="my-4">

            <div class="mb-3">
                <div class="text-uppercase small fw-semibold text-muted mb-2">Links</div>
                <div class="row g-3">
                    <div class="col-md-6">
                        <label class="form-label">Parent issue</label>
                        <select class="form-select @error('parent_issue_id') is-invalid @enderror" name="parent_issue_id">
                            <option value="">— None —</option>
                            @foreach($parentIssues as $pi)
                            <option value="{{ $pi->id }}" {{ old('parent_issue_id') == $pi->id ? 'selected' : '' }}>{{ $pi->issue_key }} — {{ Str::limit($pi->summary, 45) }}</option>
                            @endforeach
                        </select>
                        @error('parent_issue_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Labels</label>
                        <select class="form-select @error('label_ids') is-invalid @enderror" name="label_ids[]" multiple size="6">
                            @foreach($labels as $l)
                            <option value="{{ $l->id }}" {{ in_array($l->id, old('label_ids', [])) ? 'selected' : '' }}>{{ $l->name }}</option>
                            @endforeach
                        </select>
                        <small class="text-muted">Hold Ctrl (Windows) or Cmd (Mac) to select multiple labels.</small>
                        @error('label_ids')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                </div>
            </div>

            <div class="d-flex align-items-center justify-content-end gap-2 mt-4 pt-2 border-top">
                <a href="{{ route('issues.index') }}" class="btn btn-outline-secondary">Cancel</a>
                <button type="submit" class="btn btn-primary px-4">Create Issue</button>
            </div>
        </form>
    </div>
</div>
</div>
@endsection

@push('styles')
<link href="https://cdn.jsdelivr.net/npm/summernote@0.9.0/dist/summernote-lite.min.css" rel="stylesheet">
<style id="taskflow-page-issues-create">
    /*
     * Scrollable form: #app-main-inner is a flex column (flex:1; min-height:0; overflow-y:auto).
     * Use flex-basis 0 so this page fills remaining height; do NOT use .setup-list-card here —
     * layout forces .setup-list-card .card-body { overflow: visible } which blocks inner scroll.
     */
    #app-main-content > .issue-create-page {
        flex: 1 1 0;
        min-height: 0;
    }
    .issue-create-page {
        display: flex;
        flex-direction: column;
        min-height: 0;
    }
    .issue-create-page-header {
        flex-shrink: 0;
    }
    .issue-create-card {
        flex: 1 1 0;
        min-height: 0;
        display: flex;
        flex-direction: column;
    }
    .issue-create-scroll {
        flex: 1 1 0;
        min-height: 0;
        max-height: 100%;
        overflow-y: auto !important;
        overflow-x: hidden;
        overscroll-behavior: contain;
    }
</style>
@endpush

@push('scripts')
<script>
    (function initIssueDescriptionEditor() {
        function loadScriptOnce(id, src, cb) {
            var existing = document.getElementById(id);
            if (existing) {
                if (typeof cb === 'function') cb();
                return;
            }
            var s = document.createElement('script');
            s.id = id;
            s.src = src;
            s.onload = function() { if (typeof cb === 'function') cb(); };
            document.body.appendChild(s);
        }

        function mountEditor() {
            if (typeof $ === 'undefined') return;
            var editor = $('#issue-description-editor');
            if (!editor.length || typeof editor.summernote !== 'function') return;
            if (editor.next('.note-editor').length) return;

            editor.summernote({
                placeholder: 'Add context, expected behavior, and acceptance notes',
                tabsize: 2,
                height: 220,
                toolbar: [
                    ['style', ['bold', 'italic', 'underline', 'clear']],
                    ['font', ['strikethrough']],
                    ['para', ['ul', 'ol', 'paragraph']],
                    ['insert', ['link']],
                    ['view', ['codeview']]
                ]
            });
        }

        if (typeof $ !== 'undefined' && typeof $.fn !== 'undefined' && typeof $.fn.summernote === 'function') {
            mountEditor();
            return;
        }

        loadScriptOnce(
            'summernote-lite-js',
            'https://cdn.jsdelivr.net/npm/summernote@0.9.0/dist/summernote-lite.min.js',
            mountEditor
        );
    })();
</script>
@endpush
