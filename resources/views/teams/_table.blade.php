@include('partials.list-table-controls', ['paginator' => $teams, 'searchPlaceholder' => 'Search teams'])
<div class="table-responsive">
    <table class="table table-hover align-middle mb-0">
        <thead class="table-light"><tr><th>Name</th><th>Description</th><th>Members</th><th>Projects</th><th width="140"></th></tr></thead>
        <tbody>
            @forelse($teams as $team)
            <tr>
                <td>{{ $team->name }}</td>
                <td>{{ Str::limit($team->description, 50) }}</td>
                <td>{{ $team->members_count }}</td>
                <td>@if(isset($team->projects_count) && $team->projects_count > 0){{ $team->projects_count }}@else—@endif</td>
                <td>
                    <button type="button" class="btn btn-sm btn-outline-secondary btn-view" data-load="{{ route('teams.show', $team) }}?modal=1" data-title="View Team">View</button>
                    <button type="button" class="btn btn-sm btn-outline-primary btn-edit" data-load="{{ route('teams.edit', $team) }}?modal=1" data-submit="{{ route('teams.update', $team) }}" data-method="PUT" data-title="Edit Team">Edit</button>
                    <button type="button" class="btn btn-sm btn-outline-danger btn-delete" data-url="{{ route('teams.destroy', $team) }}" data-confirm="Delete this team?">Delete</button>
                </td>
            </tr>
            @empty
            <tr><td colspan="5" class="text-center text-muted py-4">No teams yet.</td></tr>
            @endforelse
        </tbody>
    </table>
</div>
@include('partials.list-table-footer', ['paginator' => $teams])
