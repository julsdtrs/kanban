<div class="table-responsive">
    <table class="table table-hover align-middle mb-0">
        <thead class="table-light"><tr><th>Name</th><th>Board</th><th width="140"></th></tr></thead>
        <tbody>
            @forelse($workflows as $workflow)
            <tr>
                <td>{{ $workflow->name }}</td>
                <td>{{ $workflow->board->name ?? '—' }} @if($workflow->board && $workflow->board->project)<span class="text-muted small">({{ $workflow->board->project->name }})</span>@endif</td>
                <td>
                    <button type="button" class="btn btn-sm btn-outline-secondary btn-view" data-load="{{ route('workflows.show', $workflow) }}?modal=1" data-title="View Workflow">View</button>
                    <button type="button" class="btn btn-sm btn-outline-primary btn-edit" data-load="{{ route('workflows.edit', $workflow) }}?modal=1" data-submit="{{ route('workflows.update', $workflow) }}" data-method="PUT" data-title="Edit Workflow">Edit</button>
                    <button type="button" class="btn btn-sm btn-outline-danger btn-delete" data-url="{{ route('workflows.destroy', $workflow) }}" data-confirm="Delete this workflow?">Delete</button>
                </td>
            </tr>
            @empty
            <tr><td colspan="3" class="text-center text-muted py-4">No workflows yet.</td></tr>
            @endforelse
        </tbody>
    </table>
</div>
@if($workflows->hasPages())<div class="card-footer bg-white border-0 pt-0">{{ $workflows->appends(request()->query())->links() }}</div>@endif
