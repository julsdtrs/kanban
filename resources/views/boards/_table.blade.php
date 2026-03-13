<div class="table-responsive">
    <table class="table table-hover align-middle mb-0">
        <thead class="table-light"><tr><th>Projects</th><th>Name</th><th>Type</th><th width="140"></th></tr></thead>
        <tbody>
            @forelse($boards as $board)
            <tr>
                <td>@if(isset($board->projects) && $board->projects->isNotEmpty()){{ $board->projects->pluck('name')->join(', ') }}@else{{ $board->project->name ?? '—' }}@endif</td>
                <td>{{ $board->name ?? '—' }}</td>
                <td><span class="badge bg-secondary">{{ $board->board_type }}</span></td>
                <td>
                    <button type="button" class="btn btn-sm btn-outline-secondary btn-view" data-load="{{ route('boards.show', $board) }}?modal=1" data-title="View Board">View</button>
                    <button type="button" class="btn btn-sm btn-outline-primary btn-edit" data-load="{{ route('boards.edit', $board) }}?modal=1" data-submit="{{ route('boards.update', $board) }}" data-method="PUT" data-title="Edit Board">Edit</button>
                    <button type="button" class="btn btn-sm btn-outline-danger btn-delete" data-url="{{ route('boards.destroy', $board) }}" data-confirm="Delete this board?">Delete</button>
                </td>
            </tr>
            @empty
            <tr><td colspan="4" class="text-center text-muted py-4">No boards yet.</td></tr>
            @endforelse
        </tbody>
    </table>
</div>
@if($boards->hasPages())<div class="card-footer bg-white border-0 pt-0">{{ $boards->appends(request()->query())->links() }}</div>@endif
