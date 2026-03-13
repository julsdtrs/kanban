@php
    $total = $boardStats['total'] ?? 0;
    $segments = $boardStats['segments'] ?? [];
    $radius = 48;
    $circum = 2 * M_PI * $radius;
    $offset = 0;
@endphp
<div class="kanban-board-stats card border-0 shadow-sm mb-3">
    <div class="card-body py-3">
        <h6 class="text-uppercase small fw-600 text-body-secondary mb-3">Board statistics</h6>
        <div class="row align-items-center g-3">
            <div class="col-auto">
                <div class="board-stats-pie position-relative" style="width: 120px; height: 120px;">
                    @if($total > 0 && count($segments) > 0)
                    <svg viewBox="0 0 100 100" class="d-block" style="width: 100%; height: 100%;">
                        @foreach($segments as $seg)
                        @php
                            $length = $total > 0 ? ($seg['count'] / $total) * $circum : 0;
                        @endphp
                        @if($length > 0)
                        <circle cx="50" cy="50" r="{{ $radius }}" fill="none" stroke="{{ $seg['color'] }}" stroke-width="20" stroke-dasharray="{{ $length }} {{ $circum }}" stroke-dashoffset="{{ -$offset }}" transform="rotate(-90 50 50)"/>
                        @endif
                        @php $offset += $length; @endphp
                        @endforeach
                    </svg>
                    @else
                    <div class="position-absolute top-50 start-50 translate-middle text-muted small">No data</div>
                    @endif
                </div>
            </div>
            <div class="col">
                <div class="fw-600 fs-5">{{ $total }}</div>
                <div class="small text-muted">Total tickets</div>
                <ul class="list-unstyled small mt-2 mb-0">
                    @foreach($segments as $seg)
                    <li class="d-flex align-items-center gap-2 py-1">
                        <span class="d-inline-block rounded-circle flex-shrink-0" style="width: 10px; height: 10px; background: {{ $seg['color'] }};"></span>
                        <span>{{ $seg['label'] }}</span>
                        <span class="text-muted">{{ $seg['count'] }}</span>
                        <span class="text-muted">({{ $seg['percentage'] }}%)</span>
                    </li>
                    @endforeach
                </ul>
            </div>
        </div>
    </div>
</div>
