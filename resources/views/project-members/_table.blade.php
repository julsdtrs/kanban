@php
$createLoadUrl = route('project-members.create');
$createSubmitUrl = route('project-members.store');
$refreshUrl = request()->has('project_id') ? route('project-members.index', ['project_id' => request('project_id'), 'partial' => 1]) : route('project-members.index', ['partial' => 1]);
@endphp
@if(isset($projects))
<form method="GET" class="setup-filter-form" action="{{ route('project-members.index') }}">
    @if(request()->has('project_id'))
    <input type="hidden" name="project_id" value="{{ request('project_id') }}">
    @endif
    <span class="setup-filter-form-label">
        <i class="bi bi-funnel"></i> Filter by project
    </span>
    <select name="project_id" class="form-select form-select-sm" onchange="this.form.submit()">
        <option value="">All projects</option>
        @foreach($projects as $p)
        <option value="{{ $p->id }}" {{ request('project_id') == $p->id ? 'selected' : '' }}>{{ $p->name }}</option>
        @endforeach
    </select>
    @if(request('project_id'))
    <a href="{{ route('project-members.index', ['partial' => 1]) }}" class="btn btn-sm btn-light btn-reset-filter">Reset</a>
    @endif
</form>
@endif
<div class="table-responsive">
    <table class="table table-hover align-middle mb-0">
        <thead class="table-light"><tr><th>Project</th><th>User</th><th>Role</th><th width="140"></th></tr></thead>
        <tbody>
            @forelse($items as $item)
            <tr>
                <td>{{ $item->project_name ?? '—' }}</td>
                <td>{{ $item->display_name ?? $item->username ?? '—' }}</td>
                <td>{{ $item->role_name ?? '—' }}</td>
                <td>
                    <button type="button" class="btn btn-sm btn-outline-primary btn-edit" data-load="{{ route('project-members.edit', $item->project_id . '-' . $item->user_id) }}?modal=1" data-submit="{{ route('project-members.update', $item->project_id . '-' . $item->user_id) }}" data-method="PUT" data-title="Edit Project Member">Edit</button>
                    <button type="button" class="btn btn-sm btn-outline-danger btn-delete" data-url="{{ route('project-members.destroy', $item->project_id . '-' . $item->user_id) }}" data-confirm="Remove this project member?">Delete</button>
                </td>
            </tr>
            @empty
            <tr><td colspan="4" class="text-center text-muted py-4">No project members yet.</td></tr>
            @endforelse
        </tbody>
    </table>
</div>
@if(isset($items) && $items->hasPages())
<div class="card-footer bg-white border-0 pt-0">{{ $items->appends(request()->query())->links() }}</div>
@endif
