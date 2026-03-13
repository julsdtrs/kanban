<div class="table-responsive">
    <table class="table table-hover align-middle mb-0">
        <thead class="table-light"><tr><th>Name</th><th>Description</th><th>Users</th><th width="220"></th></tr></thead>
        <tbody>
            @forelse($roles as $role)
            <tr>
                <td>{{ $role->name }}</td>
                <td>{{ Str::limit($role->description, 50) }}</td>
                <td>{{ $role->users_count }}</td>
                <td>
                    <button type="button" class="btn btn-sm btn-outline-secondary btn-view" data-load="{{ route('roles.show', $role) }}?modal=1" data-title="View Role">View</button>
                    <button type="button" class="btn btn-sm btn-outline-primary btn-edit" data-load="{{ route('roles.edit', $role) }}?modal=1" data-submit="{{ route('roles.update', $role) }}" data-method="PUT" data-title="Edit Role">Edit</button>
                    <a href="{{ route('role-permissions.index', ['role_id' => $role->id]) }}" class="btn btn-sm btn-outline-primary">Permissions</a>
                    <button type="button" class="btn btn-sm btn-outline-danger btn-delete" data-url="{{ route('roles.destroy', $role) }}" data-confirm="Delete this role?">Delete</button>
                </td>
            </tr>
            @empty
            <tr><td colspan="4" class="text-center text-muted py-4">No roles yet.</td></tr>
            @endforelse
        </tbody>
    </table>
</div>
@if($roles->hasPages())<div class="card-footer bg-white border-0 pt-0">{{ $roles->appends(request()->query())->links() }}</div>@endif
