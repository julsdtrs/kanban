@extends('layouts.app')
@section('title', 'Kanban - ' . $project->name)
@section('content')
<div class="kanban-page-layout">
    <div class="d-flex flex-wrap align-items-center gap-2 mb-2">
        <h1 class="h4 mb-0">Kanban Board</h1>
    </div>
    <div id="kanban-board-container" data-create-issue-url="{{ route('issues.create') }}">
        @include('kanban._board_content')
    </div>
</div>

@push('scripts')
<script>
$(function() {
    const csrf = $('meta[name="csrf-token"]').attr('content');
    const container = $('#kanban-board-container');
    let lastDragEnd = 0;

    function getTransitionMap() {
        const wrapper = container.find('.kanban-board-wrapper').first();
        if (!wrapper.length) return null;
        const raw = wrapper.attr('data-transitions');
        if (!raw) return null;
        try {
            return JSON.parse(raw);
        } catch (e) {
            return null;
        }
    }

    $(document).on('click', '.kanban-board-select', function(e) {
        if ($(this).hasClass('active')) { e.preventDefault(); return; }
        e.preventDefault();
        var url = $(this).attr('href');
        var boardUrl = url + (url.indexOf('?') >= 0 ? '&' : '?') + 'partial=1';
        container.addClass('opacity-50');
        $.ajax({
            url: boardUrl,
            headers: { 'X-Requested-With': 'XMLHttpRequest' },
            success: function(html) {
                container.html(html).removeClass('opacity-50');
                history.pushState(null, '', url);
            },
            error: function() {
                container.removeClass('opacity-50');
                if (typeof TaskFlow !== 'undefined' && TaskFlow.toast) TaskFlow.toast('error', 'Failed to load board.');
            }
        });
    });

    $(document).on('dragstart', '.kanban-card', function(e) {
        const $card = $(this);
        const fromColumn = $card.closest('.kanban-column');
        const fromStatusId = fromColumn.data('status-id') || null;
        e.originalEvent.dataTransfer.setData('text/plain', $card.data('issue-id'));
        e.originalEvent.dataTransfer.effectAllowed = 'move';
        $card.addClass('kanban-card-dragging');

        const transitions = getTransitionMap() || {};
        const allowedTargets = fromStatusId ? (transitions[String(fromStatusId)] || transitions[fromStatusId] || []) : [];

        $('.kanban-dropszone').each(function() {
            const col = $(this).closest('.kanban-column');
            const targetStatusId = col.data('status-id') || null;
            const isBacklog = targetStatusId === null || targetStatusId === '';
            let allowed = true;
            if (fromStatusId && !isBacklog && allowedTargets.length > 0) {
                allowed = allowedTargets.indexOf(Number(targetStatusId)) !== -1;
            }
            if (allowed) {
                $(this).addClass('kanban-drop-allowed');
            } else {
                $(this).addClass('kanban-drop-blocked');
            }
        });
    });

    $(document).on('dragend', '.kanban-card', function() {
        $(this).removeClass('kanban-card-dragging');
        $('.kanban-dropszone').removeClass('kanban-drop-allowed kanban-drop-blocked bg-white bg-opacity-50');
        lastDragEnd = Date.now();
    });

    $(document).on('click', '.kanban-card', function(e) {
        if (Date.now() - lastDragEnd < 300) return;
        const url = $(this).data('issue-url');
        const title = $(this).data('issue-title');
        if (url && typeof TaskFlow !== 'undefined' && TaskFlow.crudModal && TaskFlow.crudModal.openView) {
            e.preventDefault();
            TaskFlow.crudModal.openView({ loadUrl: url, title: title || 'Issue' });
        }
    });

    $(document).on('dragover', '.kanban-dropszone', function(e) {
        const isAllowed = $(this).hasClass('kanban-drop-allowed');
        if (!isAllowed) {
            e.preventDefault();
            e.originalEvent.dataTransfer.dropEffect = 'none';
            return;
        }
        e.preventDefault();
        e.originalEvent.dataTransfer.dropEffect = 'move';
        $(this).addClass('bg-white bg-opacity-50');
    });

    $(document).on('dragleave', '.kanban-dropszone', function() {
        $(this).removeClass('bg-white bg-opacity-50');
    });

    $(document).on('drop', '.kanban-dropszone', function(e) {
        e.preventDefault();
        const $zone = $(this);
        $zone.removeClass('bg-white bg-opacity-50');
        if (!$zone.hasClass('kanban-drop-allowed')) {
            if (typeof TaskFlow !== 'undefined' && TaskFlow.toast) {
                TaskFlow.toast('warning', 'Move not allowed by workflow.');
            }
            return;
        }
        const issueId = e.originalEvent.dataTransfer.getData('text/plain');
        const column = $zone.closest('.kanban-column');
        const statusId = column.data('status-id') || null;

        const card = $('.kanban-card[data-issue-id="' + issueId + '"]').first();
        if (card.closest('.kanban-dropszone')[0] === $zone[0]) return;

        $.post('{{ url("kanban/issue") }}/' + issueId + '/status', { status_id: statusId || '', _token: csrf })
            .done(function() {
                $zone.append(card);
            })
            .fail(function() {
                if (typeof TaskFlow !== 'undefined' && TaskFlow.toast) {
                    TaskFlow.toast('error', 'Failed to update status.');
                } else {
                    alert('Failed to update status.');
                }
            });
    });
});
</script>
@endpush
@endsection
