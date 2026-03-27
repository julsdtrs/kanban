@include('partials.list-table-controls', ['paginator' => $priorities, 'searchPlaceholder' => 'Search priorities'])
<div class="table-responsive">
    <table class="table table-hover align-middle mb-0">
        <thead class="table-light"><tr><th>Name</th><th>Level</th><th>Color</th><th width="140"></th></tr></thead>
        <tbody>
            @forelse($priorities as $priority)
            <tr>
                <td>{{ $priority->name }}</td>
                <td>{{ $priority->level }}</td>
                <td>@if($priority->color)<span class="badge" style="background:{{ $priority->color }}">{{ $priority->color }}</span>@else—@endif</td>
                <td>
                    <button type="button" class="btn btn-sm btn-outline-secondary btn-view" data-load="{{ route('priorities.show', $priority) }}?modal=1" data-title="View Priority">View</button>
                    <button type="button" class="btn btn-sm btn-outline-primary btn-edit" data-load="{{ route('priorities.edit', $priority) }}?modal=1" data-submit="{{ route('priorities.update', $priority) }}" data-method="PUT" data-title="Edit Priority">Edit</button>
                    <button type="button" class="btn btn-sm btn-outline-danger btn-delete" data-url="{{ route('priorities.destroy', $priority) }}" data-confirm="Delete this priority?">Delete</button>
                </td>
            </tr>
            @empty
            <tr><td colspan="4" class="text-center text-muted py-4">No priorities yet.</td></tr>
            @endforelse
        </tbody>
    </table>
</div>
@include('partials.list-table-footer', ['paginator' => $priorities])
