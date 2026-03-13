<div class="row g-4 flex-grow-1 min-h-0">
    <div class="col-lg-9 d-flex flex-column min-h-0">
        <div class="card workflow-card flat-card flex-grow-1 d-flex flex-column min-h-0">
            <div class="card-body d-flex flex-column min-h-0 overflow-hidden">
                <h6 class="text-uppercase small fw-600 text-body-secondary mb-3 flex-shrink-0">Diagram</h6>
                <p class="small text-body-secondary mb-2 flex-shrink-0">Each line is one transition. Hover a row below or a line to highlight the connection.</p>
                <div id="workflow-diagram-wrap" class="workflow-diagram-wrap flex-grow-1 min-h-0">
                    <div id="workflow-cy" class="workflow-cy"></div>
                    <p class="workflow-empty-msg" style="{{ $workflow->transitions->isEmpty() ? '' : 'display:none' }}">No transitions yet. Add one in <strong>Transition setup</strong> on the right.</p>
                </div>
                <h6 class="text-uppercase small fw-600 text-body-secondary mt-3 mb-2 flex-shrink-0">Defined transitions <span class="text-muted fw-normal">(matches diagram — drag to reorder)</span></h6>
                <div id="workflow-transitions-list" class="workflow-transitions-list flex-grow-1 overflow-auto">
                    @foreach($workflow->transitions as $t)
                    <div class="workflow-transition-item" data-transition-id="{{ $t->id }}" draggable="true">
                        <span class="drag-handle" title="Drag to reorder"><i class="bi bi-grip-vertical text-body-secondary"></i></span>
                        <span class="from-badge" style="background:{{ $t->fromStatus->color ?? '#6c757d' }}">{{ $t->fromStatus->name }}</span>
                        <span class="arrow-icon"><i class="bi bi-arrow-right"></i></span>
                        <span class="to-badge" style="--tint:{{ $t->toStatus->color ?? '#6c757d' }}">{{ $t->toStatus->name }}</span>
                        @if($t->transition_name)<span class="transition-name">{{ $t->transition_name }}</span>@endif
                        <button type="button" class="btn btn-delete-transition delete-transition" data-id="{{ $t->id }}" title="Remove"><i class="bi bi-trash"></i></button>
                    </div>
                    @endforeach
                    @if($workflow->transitions->isEmpty())
                    <p class="text-body-secondary small mb-0">None. Add transitions in the panel on the right.</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-3">
        <div class="card workflow-card flat-card">
            <div class="card-body">
                <h6 class="text-uppercase small fw-600 text-body-secondary mb-3">Transition setup</h6>
                <form id="form-transition">
                    <input type="hidden" name="workflow_id" value="{{ $workflow->id }}">
                    <div class="mb-3">
                        <label class="form-label">From status</label>
                        <select name="from_status_id" class="form-select form-select-sm" required>
                            @foreach($statuses as $s)
                            <option value="{{ $s->id }}">{{ $s->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">To status</label>
                        <select name="to_status_id" class="form-select form-select-sm" required>
                            @foreach($statuses as $s)
                            <option value="{{ $s->id }}">{{ $s->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Transition name <span class="text-muted fw-normal">(optional)</span></label>
                        <input type="text" name="transition_name" class="form-control form-control-sm" placeholder="e.g. Submit for review">
                    </div>
                    <button type="submit" class="btn btn-primary w-100" id="btn-add-transition">Add transition</button>
                </form>
                <div class="d-flex align-items-center mt-3">
                    <button type="button" class="btn btn-sm btn-outline-secondary" id="btn-add-status" title="Create a new status">+ New status</button>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
(function() {
    'use strict';
    var statusesData = [], transitionsData = [];
    try {
        statusesData = @json($statusesForDiagram ?? []);
        transitionsData = @json($transitionsForDiagram ?? []);
    } catch (e) { statusesData = []; transitionsData = []; }
    if (!Array.isArray(statusesData)) statusesData = [];
    if (!Array.isArray(transitionsData)) transitionsData = [];
    window.workflowDiagramData = { statusesData: statusesData, transitionsData: transitionsData, container: '#workflow-cy' };

    const csrf = document.querySelector('meta[name="csrf-token"]') && document.querySelector('meta[name="csrf-token"]').getAttribute('content');
    const reorderUrl = '{{ route("workflows.diagram.reorder", $workflow) }}';
    const storeTransitionUrl = '{{ route("workflows.diagram.store-transition") }}';
    const deleteTransitionBaseUrl = '{{ url("workflows/diagram/transition") }}';

    function renderWorkflowDiagram() {
        if (window.renderWorkflowDiagram) window.renderWorkflowDiagram();
    }
    function highlightTransition(transitionId, on) {
        document.querySelectorAll('.workflow-transition-item[data-transition-id="' + transitionId + '"]').forEach(function(el) { el.classList.toggle('highlight', on); });
        if (window.workflowDiagramHighlightEdge) window.workflowDiagramHighlightEdge(transitionId, on);
    }
    window.highlightTransition = highlightTransition;

    function addTransitionToDiagram(t) {
        var fromStatus = t.from_status || t.fromStatus || { id: t.from_status_id, name: '', color: '#6c757d' };
        var toStatus = t.to_status || t.toStatus || { id: t.to_status_id, name: '', color: '#6c757d' };
        var fromId = t.from_status_id, toId = t.to_status_id;
        if (!statusesData.some(function(s) { return s.id === fromId; })) statusesData.push({ id: fromId, name: fromStatus.name, color: fromStatus.color || '#6c757d' });
        if (!statusesData.some(function(s) { return s.id === toId; })) statusesData.push({ id: toId, name: toStatus.name, color: toStatus.color || '#6c757d' });
        transitionsData.push({ id: t.id, from_status_id: fromId, to_status_id: toId, transition_name: t.transition_name || '', from_status: fromStatus, to_status: toStatus });
        renderWorkflowDiagram();
        var nameHtml = (t.transition_name && t.transition_name.trim()) ? '<span class="transition-name">' + (t.transition_name || '').replace(/</g,'&lt;') + '</span>' : '';
        var item = '<div class="workflow-transition-item" data-transition-id="' + t.id + '" draggable="true"><span class="drag-handle" title="Drag to reorder"><i class="bi bi-grip-vertical text-body-secondary"></i></span><span class="from-badge" style="background:' + (fromStatus.color || '#6c757d') + '">' + (fromStatus.name || '').replace(/</g,'&lt;') + '</span><span class="arrow-icon"><i class="bi bi-arrow-right"></i></span><span class="to-badge" style="--tint:' + (toStatus.color || '#6c757d') + '">' + (toStatus.name || '').replace(/</g,'&lt;') + '</span>' + nameHtml + '<button type="button" class="btn btn-delete-transition delete-transition" data-id="' + t.id + '" title="Remove"><i class="bi bi-trash"></i></button></div>';
        var list = document.getElementById('workflow-transitions-list');
        var emptyP = list && list.querySelector('p.text-body-secondary');
        if (emptyP) emptyP.remove();
        if (list) list.insertAdjacentHTML('beforeend', item);
        var emptyMsg = document.querySelector('#workflow-diagram-wrap .workflow-empty-msg');
        if (emptyMsg) emptyMsg.style.display = 'none';
    }
    function highlightTransition(transitionId, on) {
        document.querySelectorAll('.workflow-transition-item[data-transition-id="' + transitionId + '"]').forEach(function(el) { el.classList.toggle('highlight', on); });
        document.querySelectorAll('#workflow-svg .link-path[data-transition-id="' + transitionId + '"]').forEach(function(el) { el.classList.toggle('highlight', on); });
    }
    document.addEventListener('mouseenter', function(e) {
        if (!e.target || typeof e.target.closest !== 'function') return;
        var item = e.target.closest('.workflow-transition-item');
        if (item && item.dataset && item.dataset.transitionId) highlightTransition(item.dataset.transitionId, true);
    }, true);
    document.addEventListener('mouseleave', function(e) {
        if (!e.target || typeof e.target.closest !== 'function') return;
        var item = e.target.closest('.workflow-transition-item');
        if (item && item.dataset && item.dataset.transitionId) highlightTransition(item.dataset.transitionId, false);
    }, true);
    var draggedId = null;
    document.addEventListener('dragstart', function(e) {
        if (!e.target || typeof e.target.closest !== 'function') return;
        var item = e.target.closest('.workflow-transition-item');
        if (item && item.dataset) { draggedId = item.dataset.transitionId; e.dataTransfer.setData('text/plain', draggedId); e.dataTransfer.effectAllowed = 'move'; item.classList.add('dragging'); }
    });
    document.addEventListener('dragend', function(e) {
        if (!e.target || typeof e.target.closest !== 'function') return;
        var item = e.target.closest('.workflow-transition-item');
        if (item) { item.classList.remove('dragging'); document.querySelectorAll('.workflow-transition-item').forEach(function(el) { el.classList.remove('drag-over'); }); }
    });
    document.addEventListener('dragover', function(e) {
        if (!e.target || typeof e.target.closest !== 'function') return;
        var item = e.target.closest('.workflow-transition-item');
        if (item && e.dataTransfer && e.dataTransfer.types.indexOf('text/plain') >= 0) { e.preventDefault(); e.dataTransfer.dropEffect = 'move'; if (item.dataset && item.dataset.transitionId !== draggedId) item.classList.add('drag-over'); }
    });
    document.addEventListener('dragleave', function(e) {
        if (!e.target || typeof e.target.closest !== 'function') return;
        var item = e.target.closest('.workflow-transition-item');
        if (item) item.classList.remove('drag-over');
    });
    document.addEventListener('drop', function(e) {
        if (!e.target || typeof e.target.closest !== 'function') return;
        var item = e.target.closest('.workflow-transition-item');
        if (!item || !item.dataset || !draggedId || item.dataset.transitionId === draggedId) return;
        e.preventDefault();
        item.classList.remove('drag-over');
        var list = document.getElementById('workflow-transitions-list');
        var dragged = list && list.querySelector('.workflow-transition-item[data-transition-id="' + draggedId + '"]');
        if (list && dragged) {
            item.after(dragged);
            var order = [];
            list.querySelectorAll('.workflow-transition-item').forEach(function(el) { order.push(parseInt(el.dataset.transitionId, 10)); });
            var byId = {};
            transitionsData.forEach(function(t) { byId[t.id] = t; });
            transitionsData.length = 0;
            order.forEach(function(id) { if (byId[id]) transitionsData.push(byId[id]); });
            var formData = new FormData();
            order.forEach(function(id, i) { formData.append('order[' + i + ']', id); });
            formData.append('_token', csrf);
            fetch(reorderUrl, { method: 'POST', body: formData }).then(function(r) { return r.json(); }).then(function() {
                renderWorkflowDiagram();
                if (window.TaskFlow && TaskFlow.toast) TaskFlow.toast('success', 'Order updated.');
            }).catch(function() {
                if (window.TaskFlow && TaskFlow.toast) TaskFlow.toast('error', 'Failed to save order.');
            });
        }
    });

    var form = document.getElementById('form-transition');
    if (form) {
        form.addEventListener('submit', function(e) {
            e.preventDefault();
            var btn = document.getElementById('btn-add-transition');
            if (btn) btn.disabled = true;
            var fd = new FormData(form);
            fd.append('_token', csrf);
            fetch(storeTransitionUrl, { method: 'POST', body: fd }).then(function(r) { return r.json(); }).then(function(res) {
                if (res.success && res.transition) {
                    addTransitionToDiagram(res.transition);
                    if (window.TaskFlow && TaskFlow.toast) TaskFlow.toast('success', 'Transition added.');
                }
            }).catch(function() {}).finally(function() {
                if (btn) btn.disabled = false;
            });
        });
    }
    document.addEventListener('click', function(e) {
        if (!e.target || typeof e.target.closest !== 'function') return;
        if (e.target.closest('.delete-transition')) {
            var btn = e.target.closest('.delete-transition');
            var id = parseInt(btn.dataset.id, 10);
            if (!confirm('Remove this transition?')) return;
            fetch(deleteTransitionBaseUrl + '/' + id, { method: 'DELETE', headers: { 'X-CSRF-TOKEN': csrf, 'Accept': 'application/json', 'X-Requested-With': 'XMLHttpRequest' } }).then(function(r) { return r.json(); }).then(function() {
                var idx = transitionsData.findIndex(function(t) { return t.id === id; });
                if (idx >= 0) transitionsData.splice(idx, 1);
                var row = btn.closest('.workflow-transition-item');
                if (row) row.remove();
                renderWorkflowDiagram();
                var list = document.getElementById('workflow-transitions-list');
                if (list && !list.querySelector('.workflow-transition-item')) {
                    var p = document.createElement('p');
                    p.className = 'text-body-secondary small mb-0';
                    p.textContent = 'None. Add transitions in the panel on the right.';
                    list.appendChild(p);
                }
                if (window.TaskFlow && TaskFlow.toast) TaskFlow.toast('success', 'Transition removed.');
            }).catch(function() {
                if (window.TaskFlow && TaskFlow.toast) TaskFlow.toast('error', 'Failed to delete.');
            });
        }
        if (e.target.closest('#btn-add-status')) {
            if (window.TaskFlow && TaskFlow.crudModal && TaskFlow.crudModal.open) {
                TaskFlow.crudModal.open({
                    title: 'Add status',
                    loadUrl: '{{ route("statuses.create") }}?modal=1',
                    submitUrl: '{{ route("statuses.store") }}',
                    method: 'POST',
                    refreshSelector: null,
                    onSuccess: function() {
                        if (window.TaskFlow && TaskFlow.appNav && TaskFlow.appNav.loadPage) TaskFlow.appNav.loadPage(window.location.pathname + window.location.search, true);
                        else window.location.reload();
                    }
                });
            }
        }
    });
    if (window.renderWorkflowDiagram) window.renderWorkflowDiagram();
})();
</script>
