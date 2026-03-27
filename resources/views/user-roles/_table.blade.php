@php
$createLoadUrl = route('user-roles.create');
$createSubmitUrl = route('user-roles.store');
$refreshUrl = request()->has('user_id') ? route('user-roles.index', ['user_id' => request('user_id'), 'partial' => 1]) : route('user-roles.index', ['partial' => 1]);
@endphp
@include('partials.list-table-controls', ['paginator' => $items, 'searchPlaceholder' => 'Search user roles'])
@if(isset($users))
<form method="GET" class="setup-filter-form" action="{{ route('user-roles.index') }}">
    @if(request()->has('user_id'))
    <input type="hidden" name="user_id" value="{{ request('user_id') }}">
    @endif
    <span class="setup-filter-form-label">
        <i class="bi bi-funnel"></i> Filter by user
    </span>
    <select name="user_id" class="form-select form-select-sm" onchange="this.form.submit()">
        <option value="">All users</option>
        @foreach($users as $u)
        <option value="{{ $u->id }}" {{ request('user_id') == $u->id ? 'selected' : '' }}>{{ $u->display_name ?? $u->username }}</option>
        @endforeach
    </select>
    @if(request('user_id'))
    <a href="{{ route('user-roles.index', ['partial' => 1]) }}" class="btn btn-sm btn-light btn-reset-filter">Reset</a>
    @endif
</form>
@endif
<div class="table-responsive">
    <table class="table table-hover align-middle mb-0">
        <thead class="table-light"><tr><th>User</th><th>Role</th><th width="140"></th></tr></thead>
        <tbody>
            @forelse($items as $item)
            <tr>
                <td>{{ $item->display_name ?? $item->username ?? '—' }}</td>
                <td>{{ $item->role_name ?? '—' }}</td>
                <td>
                    <button type="button" class="btn btn-sm btn-outline-primary btn-edit" data-load="{{ route('user-roles.edit', $item->user_id . '-' . $item->role_id) }}?modal=1" data-submit="{{ route('user-roles.update', $item->user_id . '-' . $item->role_id) }}" data-method="PUT" data-title="Edit User Role">Edit</button>
                    <button type="button" class="btn btn-sm btn-outline-danger btn-delete" data-url="{{ route('user-roles.destroy', $item->user_id . '-' . $item->role_id) }}" data-confirm="Remove this user role?">Delete</button>
                </td>
            </tr>
            @empty
            <tr><td colspan="3" class="text-center text-muted py-4">No user roles yet.</td></tr>
            @endforelse
        </tbody>
    </table>
</div>
@include('partials.list-table-footer', ['paginator' => $items])
