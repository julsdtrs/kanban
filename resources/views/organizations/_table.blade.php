@include('partials.list-table-controls', ['paginator' => $organizations, 'searchPlaceholder' => 'Search organizations'])
<div class="table-responsive">
    <table class="table table-hover align-middle mb-0">
        <thead class="table-light"><tr><th>Name</th><th>Description</th><th>Projects</th><th width="140"></th></tr></thead>
        <tbody>
            @forelse($organizations as $organization)
            <tr>
                <td>{{ $organization->name }}</td>
                <td>{{ Str::limit($organization->description, 50) }}</td>
                <td>{{ $organization->projects_count }}</td>
                <td>
                    <button type="button" class="btn btn-sm btn-outline-secondary btn-view" data-load="{{ route('organizations.show', $organization) }}?modal=1" data-title="View Organization">View</button>
                    <button type="button" class="btn btn-sm btn-outline-primary btn-edit" data-load="{{ route('organizations.edit', $organization) }}?modal=1" data-submit="{{ route('organizations.update', $organization) }}" data-method="PUT" data-title="Edit Organization">Edit</button>
                    <button type="button" class="btn btn-sm btn-outline-danger btn-delete" data-url="{{ route('organizations.destroy', $organization) }}" data-confirm="Delete this organization?">Delete</button>
                </td>
            </tr>
            @empty
            <tr><td colspan="4" class="text-center text-muted py-4">No organizations yet.</td></tr>
            @endforelse
        </tbody>
    </table>
</div>
@include('partials.list-table-footer', ['paginator' => $organizations])
