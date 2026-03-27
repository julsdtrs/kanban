@if(isset($workflows) && $workflows->isNotEmpty())
<form method="GET" class="p-2 border-bottom bg-light">
    <select name="workflow_id" class="form-select form-select-sm w-auto d-inline-block" onchange="this.form.submit()">
        <option value="">All workflows</option>
        @foreach($workflows as $w)
        <option value="{{ $w->id }}" {{ request('workflow_id') == $w->id ? 'selected' : '' }}>{{ $w->name }}</option>
        @endforeach
    </select>
</form>
@endif
@include('partials.list-table-controls', ['paginator' => $transitions, 'searchPlaceholder' => 'Search transitions'])
<div class="table-responsive">
    <table class="table table-hover align-middle mb-0">
        <thead class="table-light"><tr><th>Workflow</th><th>From</th><th>To</th><th>Name</th><th width="140"></th></tr></thead>
        <tbody>
            @forelse($transitions as $t)
            <tr>
                <td>{{ $t->workflow->name ?? '—' }}</td>
                <td><span class="badge" style="background:{{ $t->fromStatus->color ?? '#6c757d' }}">{{ $t->fromStatus->name }}</span></td>
                <td><span class="badge" style="background:{{ $t->toStatus->color ?? '#6c757d' }}">{{ $t->toStatus->name }}</span></td>
                <td>{{ $t->transition_name ?? '—' }}</td>
                <td>
                    <button type="button" class="btn btn-sm btn-outline-secondary btn-view" data-load="{{ route('workflow-transitions.show', $t) }}?modal=1" data-title="View Transition">View</button>
                    <button type="button" class="btn btn-sm btn-outline-primary btn-edit" data-load="{{ route('workflow-transitions.edit', $t) }}?modal=1" data-submit="{{ route('workflow-transitions.update', $t) }}" data-method="PUT" data-title="Edit Transition">Edit</button>
                    <button type="button" class="btn btn-sm btn-outline-danger btn-delete" data-url="{{ route('workflow-transitions.destroy', $t) }}" data-confirm="Delete this transition?">Delete</button>
                </td>
            </tr>
            @empty
            <tr><td colspan="5" class="text-center text-muted py-4">No transitions yet.</td></tr>
            @endforelse
        </tbody>
    </table>
</div>
@include('partials.list-table-footer', ['paginator' => $transitions])
