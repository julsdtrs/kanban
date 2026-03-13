@extends('layouts.app')
@section('title', 'Issues')
@section('content')
<div class="issues-page">
    <div class="d-flex justify-content-between align-items-center mb-3 flex-shrink-0">
        <h1 class="h3 mb-0">Issues</h1>
        <a href="{{ route('issues.create') }}" class="btn btn-primary"><i class="bi bi-plus-lg me-1"></i> New Issue</a>
    </div>
    <form method="GET" class="row g-2 mb-3 flex-shrink-0">
        <div class="col-auto"><select name="project_id" class="form-select form-select-sm"><option value="">All projects</option>@foreach($projects as $p)<option value="{{ $p->id }}" {{ request('project_id') == $p->id ? 'selected' : '' }}>{{ $p->name }}</option>@endforeach</select></div>
        <div class="col-auto"><select name="status_id" class="form-select form-select-sm"><option value="">All statuses</option>@foreach($statuses as $s)<option value="{{ $s->id }}" {{ request('status_id') == $s->id ? 'selected' : '' }}>{{ $s->name }}</option>@endforeach</select></div>
        <div class="col-auto"><button type="submit" class="btn btn-sm btn-outline-secondary">Filter</button></div>
    </form>
    <div class="card border-0 shadow-sm">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-light"><tr><th>Key</th><th>Summary</th><th>Project</th><th>Status</th><th>Type</th><th>Assignee</th><th class="text-end" style="min-width: 180px;">Actions</th></tr></thead>
                <tbody>
                    @forelse($issues as $issue)
                    <tr>
                        <td>{{ $issue->issue_key }}</td>
                        <td>{{ Str::limit($issue->summary, 50) }}</td>
                        <td>{{ $issue->project->name ?? '-' }}</td>
                        <td>{{ $issue->status->name ?? '-' }}</td>
                        <td>{{ $issue->issueType->name ?? '-' }}</td>
                        <td>{{ $issue->assignee->display_name ?? $issue->assignee->username ?? '-' }}</td>
                        <td class="text-end text-nowrap">
                            <a href="{{ route('issues.show', $issue) }}" class="btn btn-sm btn-outline-secondary">View</a>
                            <a href="{{ route('issues.edit', $issue) }}" class="btn btn-sm btn-outline-primary">Edit</a>
                            <form action="{{ route('issues.destroy', $issue) }}" method="POST" class="d-inline" onsubmit="return confirm('Delete?');">@csrf @method('DELETE')<button type="submit" class="btn btn-sm btn-outline-danger">Delete</button></form>
                        </td>
                    </tr>
                    @empty
                    <tr><td colspan="7" class="text-center text-muted py-4">No issues yet.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if($issues->hasPages())
        <div class="card-footer bg-white border-top flex-shrink-0 py-3">
            <div class="d-flex flex-wrap align-items-center justify-content-between gap-2">
                <div class="small text-muted">
                    Showing {{ $issues->firstItem() ?? 0 }} to {{ $issues->lastItem() ?? 0 }} of {{ $issues->total() }} results
                </div>
                <div>{{ $issues->withQueryString()->links() }}</div>
            </div>
        </div>
        @endif
    </div>
</div>
@endsection
