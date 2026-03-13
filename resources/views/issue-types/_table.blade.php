<div class="table-responsive">
    <table class="table table-hover align-middle mb-0">
        <thead class="table-light"><tr><th>Name</th><th>Icon</th><th>Color</th><th width="140"></th></tr></thead>
        <tbody>
            @forelse($issueTypes as $issueType)
            <tr>
                <td>{{ $issueType->name }}</td>
                <td>{{ $issueType->icon ?? '—' }}</td>
                <td>@if($issueType->color)<span class="badge" style="background:{{ $issueType->color }}">{{ $issueType->color }}</span>@else—@endif</td>
                <td>
                    <button type="button" class="btn btn-sm btn-outline-secondary btn-view" data-load="{{ route('issue-types.show', $issueType) }}?modal=1" data-title="View Issue Type">View</button>
                    <button type="button" class="btn btn-sm btn-outline-primary btn-edit" data-load="{{ route('issue-types.edit', $issueType) }}?modal=1" data-submit="{{ route('issue-types.update', $issueType) }}" data-method="PUT" data-title="Edit Issue Type">Edit</button>
                    <button type="button" class="btn btn-sm btn-outline-danger btn-delete" data-url="{{ route('issue-types.destroy', $issueType) }}" data-confirm="Delete this issue type?">Delete</button>
                </td>
            </tr>
            @empty
            <tr><td colspan="4" class="text-center text-muted py-4">No issue types yet.</td></tr>
            @endforelse
        </tbody>
    </table>
</div>
@if($issueTypes->hasPages())<div class="card-footer bg-white border-0 pt-0">{{ $issueTypes->appends(request()->query())->links() }}</div>@endif
