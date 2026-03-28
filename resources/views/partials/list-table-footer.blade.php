@php
    $paginator = $paginator ?? null;
@endphp

@if($paginator)
<div class="card-footer bg-white setup-table-footer">
    <div class="d-flex align-items-center justify-content-between flex-wrap gap-2">
        <div class="small text-muted">
            Showing {{ $paginator->firstItem() ?? 0 }} to {{ $paginator->lastItem() ?? 0 }} of {{ $paginator->total() }} entries
        </div>
        <div>
            {{ $paginator->appends(request()->query())->links('vendor.pagination.table-links') }}
        </div>
    </div>
</div>
@endif
