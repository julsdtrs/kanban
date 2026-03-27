@include('partials.list-table-controls', ['paginator' => $permissions, 'searchPlaceholder' => 'Search permissions'])
<div class="table-responsive">
    <table class="table table-hover align-middle mb-0">
        <thead class="table-light"><tr><th>Code</th><th>Description</th><th width="140"></th></tr></thead>
        <tbody>
            @forelse($permissions as $permission)
            <tr>
                <td>{{ $permission->code }}</td>
                <td>{{ Str::limit($permission->description, 50) }}</td>
                <td>
                    <button type="button" class="btn btn-sm btn-outline-secondary btn-view" data-load="{{ route('permissions.show', $permission) }}?modal=1" data-title="View Permission">View</button>
                    <button type="button" class="btn btn-sm btn-outline-primary btn-edit" data-load="{{ route('permissions.edit', $permission) }}?modal=1" data-submit="{{ route('permissions.update', $permission) }}" data-method="PUT" data-title="Edit Permission">Edit</button>
                    <button type="button" class="btn btn-sm btn-outline-danger btn-delete" data-url="{{ route('permissions.destroy', $permission) }}" data-confirm="Delete this permission?">Delete</button>
                </td>
            </tr>
            @empty
            <tr><td colspan="3" class="text-center text-muted py-4">No permissions yet.</td></tr>
            @endforelse
        </tbody>
    </table>
</div>
@include('partials.list-table-footer', ['paginator' => $permissions])
