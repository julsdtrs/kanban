@extends('layouts.app')
@section('title', 'Statuses')
@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h1 class="h3 mb-0 page-title">Statuses</h1>
    <button type="button" class="btn btn-primary" id="btn-create-status"><i class="bi bi-plus-lg me-1"></i> Add Status</button>
</div>
<div class="card border-0 shadow-sm setup-list-card">
    <div class="card-header bg-transparent border-bottom py-3"><span class="fw-600 text-body">All statuses</span><span class="text-muted small fw-normal ms-2">— Drag rows to update sequence</span></div>
    <div class="card-body p-0" id="statuses-table-container">
        @include('statuses._table', ['statuses' => $statuses])
    </div>
</div>
@include('partials.crud-modal-js', [
    'createButtonId' => 'btn-create-status',
    'createTitle' => 'Add Status',
    'createLoadUrl' => route('statuses.create'),
    'createSubmitUrl' => route('statuses.store'),
    'refreshUrl' => route('statuses.index', ['partial' => 1]),
    'containerSelector' => '#statuses-table-container',
])
@endsection
@push('styles')
<style>
.status-drag-col { user-select: none; }
.status-row.dragging { opacity: 0.6; }
.status-row.drag-over { background: rgba(105, 108, 255, 0.08) !important; }
.cursor-grab { cursor: grab; }
.cursor-grab:active { cursor: grabbing; }
</style>
@endpush
@push('scripts')
<script>
(function() {
    var reorderUrl = '{{ route("statuses.reorder") }}';
    var csrf = document.querySelector('meta[name="csrf-token"]') && document.querySelector('meta[name="csrf-token"]').getAttribute('content');
    var draggedId = null;

    document.addEventListener('dragstart', function(e) {
        var row = e.target.closest('.status-row');
        if (row && row.dataset.statusId) {
            draggedId = row.dataset.statusId;
            e.dataTransfer.setData('text/plain', draggedId);
            e.dataTransfer.effectAllowed = 'move';
            row.classList.add('dragging');
        }
    });
    document.addEventListener('dragend', function(e) {
        var row = e.target.closest('.status-row');
        if (row) row.classList.remove('dragging');
        document.querySelectorAll('.status-row').forEach(function(r) { r.classList.remove('drag-over'); });
    });
    document.addEventListener('dragover', function(e) {
        var row = e.target.closest('.status-row');
        if (!row || !row.dataset.statusId || row.dataset.statusId === draggedId) return;
        if (e.dataTransfer && e.dataTransfer.types.indexOf('text/plain') >= 0) {
            e.preventDefault();
            e.dataTransfer.dropEffect = 'move';
            document.querySelectorAll('.status-row').forEach(function(r) { r.classList.remove('drag-over'); });
            row.classList.add('drag-over');
        }
    });
    document.addEventListener('dragleave', function(e) {
        if (e.target.classList && e.target.classList.contains('status-row')) e.target.classList.remove('drag-over');
    });
    document.addEventListener('drop', function(e) {
        e.preventDefault();
        var row = e.target.closest('.status-row');
        if (!row || !row.dataset.statusId || !draggedId || row.dataset.statusId === draggedId) return;
        row.classList.remove('drag-over');
        var tbody = document.getElementById('statuses-tbody');
        var draggedEl = tbody && tbody.querySelector('.status-row[data-status-id="' + draggedId + '"]');
        if (!tbody || !draggedEl) return;
        row.parentNode.insertBefore(draggedEl, row);
        var order = [];
        tbody.querySelectorAll('.status-row').forEach(function(r) { order.push(parseInt(r.dataset.statusId, 10)); });
        var formData = new FormData();
        order.forEach(function(id, i) { formData.append('order[' + i + ']', id); });
        formData.append('_token', csrf);
        fetch(reorderUrl, { method: 'POST', body: formData, headers: { 'X-Requested-With': 'XMLHttpRequest', 'Accept': 'application/json' } })
            .then(function(r) { return r.json(); })
            .then(function(res) {
                var rows = tbody.querySelectorAll('.status-row');
                rows.forEach(function(r, i) {
                    var orderCell = r.querySelector('td:nth-child(5)');
                    if (orderCell) orderCell.textContent = i;
                });
                if (window.TaskFlow && TaskFlow.toast) TaskFlow.toast('success', res.message || 'Sequence updated.');
            })
            .catch(function() {
                if (window.TaskFlow && TaskFlow.toast) TaskFlow.toast('error', 'Failed to save sequence.');
            });
    });
})();
</script>
@endpush
