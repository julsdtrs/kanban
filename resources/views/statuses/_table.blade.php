<div class="table-responsive">
    <table class="table table-hover align-middle mb-0" id="statuses-table">
        <thead class="table-light"><tr><th class="status-drag-col" width="36"></th><th>Name</th><th>Category</th><th>Color</th><th>Order</th><th width="140"></th></tr></thead>
        <tbody id="statuses-tbody">
            @forelse($statuses as $index => $status)
            <tr class="status-row" data-status-id="{{ $status->id }}" draggable="true">
                <td class="status-drag-col align-middle"><span class="drag-handle text-body-secondary cursor-grab" title="Drag to reorder"><i class="bi bi-grip-vertical"></i></span></td>
                <td>{{ $status->name }}</td>
                <td><span class="badge bg-secondary">{{ $status->category }}</span></td>
                <td>@if($status->color)<span class="badge" style="background:{{ $status->color }}">{{ $status->color }}</span>@else—@endif</td>
                <td>{{ $index }}</td>
                <td>
                    <button type="button" class="btn btn-sm btn-outline-secondary btn-view" data-load="{{ route('statuses.show', $status) }}?modal=1" data-title="View Status">View</button>
                    <button type="button" class="btn btn-sm btn-outline-primary btn-edit" data-load="{{ route('statuses.edit', $status) }}?modal=1" data-submit="{{ route('statuses.update', $status) }}" data-method="PUT" data-title="Edit Status">Edit</button>
                    <button type="button" class="btn btn-sm btn-outline-danger btn-delete" data-url="{{ route('statuses.destroy', $status) }}" data-confirm="Delete this status?">Delete</button>
                </td>
            </tr>
            @empty
            <tr><td colspan="6" class="text-center text-muted py-4">No statuses yet.</td></tr>
            @endforelse
        </tbody>
    </table>
</div>
