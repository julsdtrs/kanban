@php
    $paginator = $paginator ?? null;
    $searchPlaceholder = $searchPlaceholder ?? 'Search...';
    $perPage = (int) request('per_page', method_exists($paginator, 'perPage') ? $paginator->perPage() : 10);
    $queryExcept = request()->except(['q', 'per_page', 'page', 'partial', 'modal']);
@endphp

@if($paginator)
<form method="GET" class="setup-filter-form setup-table-controls justify-content-between" action="{{ url()->current() }}">
    <div class="d-flex align-items-center gap-2">
        <label class="setup-filter-form-label mb-0">Show</label>
        <select name="per_page" class="form-select form-select-sm" onchange="this.form.submit()">
            @foreach([10, 25, 50, 100] as $size)
            <option value="{{ $size }}" {{ $perPage === $size ? 'selected' : '' }}>{{ $size }}</option>
            @endforeach
        </select>
        <span class="setup-filter-form-label mb-0 text-lowercase" style="text-transform:none; letter-spacing:0;">entries</span>
    </div>

    <div class="d-flex align-items-center gap-2 ms-auto">
        <label class="setup-filter-form-label mb-0 text-lowercase" style="text-transform:none; letter-spacing:0;">Search:</label>
        <input type="search" name="q" class="form-control form-control-sm" value="{{ request('q') }}" placeholder="{{ $searchPlaceholder }}">
        @if(request()->filled('q') || request()->filled('per_page'))
        <a href="{{ url()->current() }}@if(count($queryExcept))?{{ http_build_query($queryExcept) }}@endif" class="btn btn-sm btn-light">Reset</a>
        @endif
    </div>

    @foreach($queryExcept as $key => $value)
        @if(is_array($value))
            @foreach($value as $v)
            <input type="hidden" name="{{ $key }}[]" value="{{ $v }}">
            @endforeach
        @else
        <input type="hidden" name="{{ $key }}" value="{{ $value }}">
        @endif
    @endforeach
</form>
@endif
