@php
$createLoadUrl = route('team-members.create');
$createSubmitUrl = route('team-members.store');
$refreshUrl = request()->has('team_id') ? route('team-members.index', ['team_id' => request('team_id'), 'partial' => 1]) : route('team-members.index', ['partial' => 1]);
@endphp
@if(isset($teams))
<form method="GET" class="setup-filter-form" action="{{ route('team-members.index') }}">
    @if(request()->has('team_id'))
    <input type="hidden" name="team_id" value="{{ request('team_id') }}">
    @endif
    <span class="setup-filter-form-label">
        <i class="bi bi-funnel"></i> Filter by team
    </span>
    <select name="team_id" class="form-select form-select-sm" onchange="this.form.submit()">
        <option value="">All teams</option>
        @foreach($teams as $t)
        <option value="{{ $t->id }}" {{ request('team_id') == $t->id ? 'selected' : '' }}>{{ $t->name }}</option>
        @endforeach
    </select>
    @if(request('team_id'))
    <a href="{{ route('team-members.index', ['partial' => 1]) }}" class="btn btn-sm btn-light btn-reset-filter">Reset</a>
    @endif
</form>
@endif
<div class="table-responsive">
    <table class="table table-hover align-middle mb-0">
        <thead class="table-light"><tr><th>Team</th><th>User</th><th>Role in team</th><th width="140"></th></tr></thead>
        <tbody>
            @forelse($members as $member)
            <tr>
                <td>{{ $member->team_name ?? '—' }}</td>
                <td>{{ $member->display_name ?? $member->username ?? '—' }}</td>
                <td>{{ $member->role_in_team ?? '—' }}</td>
                <td>
                    <button type="button" class="btn btn-sm btn-outline-primary btn-edit" data-load="{{ route('team-members.edit', $member->team_id . '-' . $member->user_id) }}?modal=1" data-submit="{{ route('team-members.update', $member->team_id . '-' . $member->user_id) }}" data-method="PUT" data-title="Edit Team Member">Edit</button>
                    <button type="button" class="btn btn-sm btn-outline-danger btn-delete" data-url="{{ route('team-members.destroy', $member->team_id . '-' . $member->user_id) }}" data-confirm="Remove this team member?">Delete</button>
                </td>
            </tr>
            @empty
            <tr><td colspan="4" class="text-center text-muted py-4">No team members yet.</td></tr>
            @endforelse
        </tbody>
    </table>
</div>
@if(isset($members) && $members->hasPages())
<div class="card-footer bg-white border-0 pt-0">{{ $members->appends(request()->query())->links() }}</div>
@endif
