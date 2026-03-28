@php
$createLoadUrl = route('role-permissions.create');
$createSubmitUrl = route('role-permissions.store');
$refreshUrl = request()->has('role_id') ? route('role-permissions.index', ['role_id' => request('role_id'), 'partial' => 1]) : route('role-permissions.index', ['partial' => 1]);
@endphp
@include('partials.list-table-controls', ['paginator' => $items, 'searchPlaceholder' => 'Search role permissions'])
@if(isset($roles))
<form method="GET" class="setup-filter-form setup-filter-inline" action="{{ route('role-permissions.index') }}">
    @if(request()->has('role_id'))
    <input type="hidden" name="role_id" value="{{ request('role_id') }}">
    @endif
    <span class="setup-filter-form-label">
        <i class="bi bi-funnel"></i> Filter by role
    </span>
    <select name="role_id" class="form-select form-select-sm" onchange="this.form.submit()">
        <option value="">All roles</option>
        @foreach($roles as $r)
        <option value="{{ $r->id }}" {{ request('role_id') == $r->id ? 'selected' : '' }}>{{ $r->name }}</option>
        @endforeach
    </select>
    @if(request('role_id'))
    <a href="{{ route('role-permissions.index', ['partial' => 1]) }}" class="btn btn-sm btn-light btn-reset-filter">Reset</a>
    @endif
</form>
@endif
<div class="table-responsive">
    <table class="table table-hover align-middle mb-0">
        <thead class="table-light"><tr><th>Role</th><th>Permission</th><th width="140"></th></tr></thead>
        <tbody>
            @forelse($items as $item)
            <tr>
                <td>{{ $item->role_name ?? '—' }}</td>
                <td>{{ $item->permission_code ?? '—' }}</td>
                <td>
                    <button type="button" class="btn btn-sm btn-outline-primary btn-edit" data-load="{{ route('role-permissions.edit', $item->role_id . '-' . $item->permission_id) }}?modal=1" data-submit="{{ route('role-permissions.update', $item->role_id . '-' . $item->permission_id) }}" data-method="PUT" data-title="Edit Role Permission">Edit</button>
                    <button type="button" class="btn btn-sm btn-outline-danger btn-delete" data-url="{{ route('role-permissions.destroy', $item->role_id . '-' . $item->permission_id) }}" data-confirm="Remove this role permission?">Delete</button>
                </td>
            </tr>
            @empty
            <tr><td colspan="3" class="text-center text-muted py-4">No role permissions yet.</td></tr>
            @endforelse
        </tbody>
    </table>
</div>
@include('partials.list-table-footer', ['paginator' => $items])
