@extends('layouts.app')
@section('title', 'Workflow Diagram')
@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h1 class="h3 mb-0">Workflow Diagram</h1>
</div>
<div class="card border-0 shadow-sm">
    <div class="card-body">
        <p class="text-muted mb-3">Select a board to view or edit its assigned workflow diagram (statuses and transitions).</p>
        <div class="list-group">
            @forelse($boards as $board)
            @php $boardWorkflow = $board->workflows->first(); @endphp
            @if($boardWorkflow)
            <a href="{{ route('workflows.diagram.show', $boardWorkflow) }}" class="list-group-item list-group-item-action d-flex justify-content-between align-items-center">
                <span><i class="bi bi-kanban me-2"></i>{{ $board->name ?? ('Board #'.$board->id) }}</span>
                <span class="badge bg-secondary">{{ $boardWorkflow->name ?? '' }}</span>
            </a>
            @endif
            @empty
            <p class="text-muted mb-0">No boards with assigned workflows. Configure a workflow in <a href="{{ route('boards.index') }}">Boards setup</a> first.</p>
            @endforelse
        </div>
    </div>
</div>
@endsection
