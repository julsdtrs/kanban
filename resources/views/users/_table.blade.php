@include('partials.list-table-controls', ['paginator' => $users, 'searchPlaceholder' => 'Search users'])
<div class="table-responsive">
    <table class="table table-hover align-middle mb-0">
        <thead class="table-light">
            <tr>
                <th>Username</th>
                <th>Email</th>
                <th>Display name</th>
                <th>Active</th>
                <th width="140"></th>
            </tr>
        </thead>
        <tbody>
            @forelse($users as $user)
            <tr>
                <td>{{ $user->username }}</td>
                <td>{{ $user->email }}</td>
                <td>{{ $user->display_name ?? '-' }}</td>
                <td>@if($user->is_active)<span class="badge bg-success">Yes</span>@else<span class="badge bg-secondary">No</span>@endif</td>
                <td>
                    <button type="button" class="btn btn-sm btn-outline-secondary btn-view" data-load="{{ route('users.show', $user) }}?modal=1" data-title="View User">View</button>
                    <button type="button" class="btn btn-sm btn-outline-primary btn-edit" data-load="{{ route('users.edit', $user) }}?modal=1" data-submit="{{ route('users.update', $user) }}" data-method="PUT" data-title="Edit User">Edit</button>
                    <button type="button" class="btn btn-sm btn-outline-danger btn-delete" data-url="{{ route('users.destroy', $user) }}" data-confirm="Delete this user?">Delete</button>
                </td>
            </tr>
            @empty
            <tr><td colspan="5" class="text-center text-muted py-4">No users yet.</td></tr>
            @endforelse
        </tbody>
    </table>
</div>
@include('partials.list-table-footer', ['paginator' => $users])
