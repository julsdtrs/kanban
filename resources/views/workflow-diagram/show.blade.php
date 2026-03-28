@extends('layouts.app')
@section('title', 'Workflow Diagram')
@section('content')
<div class="workflow-page workflow-page-fill">
    <div class="d-flex align-items-center mb-3 flex-shrink-0 flex-wrap gap-2">
        <h1 class="h3 mb-0 me-3">Workflow Diagram</h1>
        @if(isset($workflows) && $workflows->isNotEmpty())
        <div class="dropdown">
            <button class="btn btn-outline-secondary dropdown-toggle d-flex align-items-center gap-2" type="button" id="workflowDiagramDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                <i class="bi bi-arrow-left-right"></i>
                <span id="workflow-diagram-label">{{ $workflow->name }}</span>
                <span class="badge bg-primary rounded-pill" id="workflow-diagram-project">{{ $workflow->project->name ?? '' }}</span>
            </button>
            <ul class="dropdown-menu dropdown-menu-end kanban-board-dropdown-menu" aria-labelledby="workflowDiagramDropdown">
                @foreach($workflows as $wf)
                <li>
                    <a class="workflow-diagram-select dropdown-item d-flex justify-content-between align-items-center {{ $wf->id === $workflow->id ? 'active' : '' }}" href="{{ route('workflows.diagram.show', $wf) }}" data-workflow-id="{{ $wf->id }}" data-workflow-name="{{ e($wf->name) }}" data-project-name="{{ e($wf->project->name ?? '') }}">
                        <span>{{ $wf->name }}</span>
                        <span class="badge bg-secondary rounded-pill">{{ $wf->project->name ?? '' }}</span>
                    </a>
                </li>
                @endforeach
            </ul>
        </div>
        @endif
    </div>
    <div id="workflow-diagram-content">
        @include('workflow-diagram._diagram_content')
    </div>
</div>
@endsection
@section('vite')
@vite(['resources/js/workflow-diagram.js'])
@endsection
@push('styles')
<style id="taskflow-page-workflow-diagram">
.workflow-page-fill { display: flex; flex-direction: column; min-height: 100%; flex: 1; }
#app-main-content > .workflow-page-fill {
    flex: 1 1 0;
    min-height: 0;
}
.workflow-page .flat-card { border: 1px solid #e9ecef; box-shadow: none; border-radius: var(--radius-lg); }
.workflow-page .workflow-card .card-body { padding: 1.25rem; }
.workflow-diagram-wrap { background: #f8f9fa; border-radius: var(--radius-lg); min-height: 280px; overflow: hidden; border: 1px solid #e9ecef; position: relative; display: flex; flex-direction: column; }
.workflow-cy { flex: 1; min-height: 280px; width: 100%; }
.workflow-empty-msg { position: absolute; margin: 1rem; color: #6c757d; font-size: 0.875rem; }
.workflow-transitions-list { display: flex; flex-direction: column; gap: 0.5rem; }
.workflow-transitions-list .workflow-transition-item {
    display: flex; align-items: center; gap: 0.5rem; padding: 0.5rem 0.75rem;
    background: #fff !important; border: 1px solid #e9ecef; border-radius: var(--radius-lg);
    transition: background .15s, border-color .15s;
}
.workflow-transitions-list .workflow-transition-item:hover,
.workflow-transitions-list .workflow-transition-item.highlight {
    background: #e8ecff !important; border-color: #696cff;
}
.workflow-transitions-list .workflow-transition-item.active,
.workflow-transitions-list .workflow-transition-item.drag-over {
    background: #e8ecff !important; border-color: #696cff;
}
.workflow-transition-item .from-badge, .workflow-transition-item .to-badge { padding: 0.2rem 0.5rem; border-radius: var(--radius); font-size: 0.8125rem; font-weight: 500; }
.workflow-transition-item .from-badge { color: #fff; }
.workflow-transition-item .to-badge { background: color-mix(in srgb, var(--tint) 18%, #fff); color: var(--tint); }
.workflow-transition-item .arrow-icon { color: #adb5bd; font-size: 0.75rem; }
.workflow-transition-item .transition-name { font-size: 0.8125rem; color: #6c757d; margin-left: 0.25rem; }
.workflow-transition-item .btn-delete-transition { margin-left: auto; padding: 0.2rem; color: #dc3545; background: none !important; border: none; opacity: 0.7; }
.workflow-transition-item .btn-delete-transition:hover { opacity: 1; }
.workflow-transition-item .drag-handle { cursor: grab; padding: 0.2rem; margin-right: 0.25rem; }
.workflow-transition-item .drag-handle:active { cursor: grabbing; }
.workflow-transition-item.dragging { opacity: 0.6; }
#workflow-diagram-content { flex: 1; min-height: 0; display: flex; flex-direction: column; }
#workflow-diagram-content .row { flex: 1; min-height: 0; }
#workflow-diagram-content .workflow-transitions-list { max-height: 240px; overflow-y: auto; }
</style>
@endpush
@push('scripts')
<script>
$(function() {
    $(document).on('click', '.workflow-diagram-select', function(e) {
        e.preventDefault();
        var $a = $(this);
        if ($a.hasClass('active')) return;
        var url = $a.attr('href');
        var name = $a.data('workflow-name');
        var projectName = $a.data('project-name');
        $('#workflow-diagram-label').text(name);
        $('#workflow-diagram-project').text(projectName);
        $('.workflow-diagram-select').removeClass('active');
        $a.addClass('active');
        var $content = $('#workflow-diagram-content');
        $content.addClass('opacity-50');
        var loadUrl = url + (url.indexOf('?') >= 0 ? '&' : '?') + 'partial=1';
        $.get(loadUrl, { headers: { 'X-Requested-With': 'XMLHttpRequest' } }).done(function(html) {
            $content.html(html).removeClass('opacity-50');
            $content.find('script').each(function() {
                var s = document.createElement('script');
                s.textContent = this.textContent;
                document.body.appendChild(s);
            });
        }).fail(function() {
            $content.removeClass('opacity-50');
            if (typeof TaskFlow !== 'undefined' && TaskFlow.toast) TaskFlow.toast('error', 'Failed to load workflow.');
        });
    });
});
</script>
@endpush
