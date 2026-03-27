@include('partials.list-table-controls', ['paginator' => $issueLabels, 'searchPlaceholder' => 'Search issue labels'])
<div class="table-responsive">
    <table class="table table-hover align-middle mb-0">
        <thead class="table-light"><tr><th>Name</th><th>Color</th><th>Issues</th><th width="140"></th></tr></thead>
        <tbody>
            @forelse($issueLabels as $issueLabel)
            <tr>
                <td>{{ $issueLabel->name }}</td>
                <td>@if($issueLabel->color)<span class="badge" style="background:{{ $issueLabel->color }}">{{ $issueLabel->color }}</span>@else—@endif</td>
                <td>{{ $issueLabel->issues_count }}</td>
                <td>
                    <button type="button" class="btn btn-sm btn-outline-secondary btn-view" data-load="{{ route('issue-labels.show', $issueLabel) }}?modal=1" data-title="View Label">View</button>
                    <button type="button" class="btn btn-sm btn-outline-primary btn-edit" data-load="{{ route('issue-labels.edit', $issueLabel) }}?modal=1" data-submit="{{ route('issue-labels.update', $issueLabel) }}" data-method="PUT" data-title="Edit Issue Label">Edit</button>
                    <button type="button" class="btn btn-sm btn-outline-danger btn-delete" data-url="{{ route('issue-labels.destroy', $issueLabel) }}" data-confirm="Delete this label?">Delete</button>
                </td>
            </tr>
            @empty
            <tr><td colspan="4" class="text-center text-muted py-4">No issue labels yet.</td></tr>
            @endforelse
        </tbody>
    </table>
</div>
@include('partials.list-table-footer', ['paginator' => $issueLabels])
