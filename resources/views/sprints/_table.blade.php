@if(isset($boards) && $boards->isNotEmpty())
<form method="GET" class="p-2 border-bottom bg-light">
    <select name="board_id" class="form-select form-select-sm w-auto d-inline-block" onchange="this.form.submit()">
        <option value="">All boards</option>
        @foreach($boards as $b)
        <option value="{{ $b->id }}" {{ request('board_id') == $b->id ? 'selected' : '' }}>{{ $b->project->name ?? '' }} — {{ $b->name ?? $b->id }}</option>
        @endforeach
    </select>
</form>
@endif
<div class="table-responsive">
    <table class="table table-hover align-middle mb-0">
        <thead class="table-light"><tr><th>Board</th><th>Name</th><th>State</th><th>Start</th><th>End</th><th width="140"></th></tr></thead>
        <tbody>
            @forelse($sprints as $sprint)
            <tr>
                <td>{{ $sprint->board->project->name ?? $sprint->board->id }}</td>
                <td>{{ $sprint->name ?? '—' }}</td>
                <td><span class="badge bg-secondary">{{ $sprint->state }}</span></td>
                <td>{{ $sprint->start_date?->format('Y-m-d') ?? '—' }}</td>
                <td>{{ $sprint->end_date?->format('Y-m-d') ?? '—' }}</td>
                <td>
                    <button type="button" class="btn btn-sm btn-outline-secondary btn-view" data-load="{{ route('sprints.show', $sprint) }}?modal=1" data-title="View Sprint">View</button>
                    <button type="button" class="btn btn-sm btn-outline-primary btn-edit" data-load="{{ route('sprints.edit', $sprint) }}?modal=1" data-submit="{{ route('sprints.update', $sprint) }}" data-method="PUT" data-title="Edit Sprint">Edit</button>
                    <button type="button" class="btn btn-sm btn-outline-danger btn-delete" data-url="{{ route('sprints.destroy', $sprint) }}" data-confirm="Delete this sprint?">Delete</button>
                </td>
            </tr>
            @empty
            <tr><td colspan="6" class="text-center text-muted py-4">No sprints yet.</td></tr>
            @endforelse
        </tbody>
    </table>
</div>
@if($sprints->hasPages())<div class="card-footer bg-white border-0 pt-0">{{ $sprints->appends(request()->query())->links() }}</div>@endif
