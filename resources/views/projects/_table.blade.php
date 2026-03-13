<div class="table-responsive">
    <table class="table table-hover align-middle mb-0">
        <thead class="table-light"><tr><th>Key</th><th>Name</th><th>Organization</th><th>Lead</th><th>Type</th><th width="140"></th></tr></thead>
        <tbody>
            @forelse($projects as $project)
            <tr>
                <td>{{ $project->project_key }}</td>
                <td>{{ $project->name }}</td>
                <td>{{ $project->organization->name ?? '—' }}</td>
                <td>{{ $project->lead->name ?? '—' }}</td>
                <td><span class="badge bg-secondary">{{ $project->project_type }}</span></td>
                <td>
                    <button type="button" class="btn btn-sm btn-outline-secondary btn-view" data-load="{{ route('projects.show', $project) }}?modal=1" data-title="View Project">View</button>
                    <button type="button" class="btn btn-sm btn-outline-primary btn-edit" data-load="{{ route('projects.edit', $project) }}?modal=1" data-submit="{{ route('projects.update', $project) }}" data-method="PUT" data-title="Edit Project">Edit</button>
                    <button type="button" class="btn btn-sm btn-outline-danger btn-delete" data-url="{{ route('projects.destroy', $project) }}" data-confirm="Delete this project?">Delete</button>
                </td>
            </tr>
            @empty
            <tr><td colspan="6" class="text-center text-muted py-4">No projects yet.</td></tr>
            @endforelse
        </tbody>
    </table>
</div>
@if($projects->hasPages())<div class="card-footer bg-white border-0 pt-0">{{ $projects->appends(request()->query())->links() }}</div>@endif
