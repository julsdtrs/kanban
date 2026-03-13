@php
    $total = $boardStats['total'] ?? 0;
    $segments = $boardStats['segments'] ?? [];
@endphp
<div class="board-stats-inner" data-total="{{ $total }}" data-segments='@json($segments)'>
    @if($total === 0 || empty($segments))
        <div class="text-center py-4 text-muted small">
            No tickets on this board yet. Create an issue to see board statistics.
        </div>
    @else
        <div class="row align-items-center g-3">
            <div class="col-auto">
                <div class="dashboard-donut-container" style="width: 200px;">
                    <canvas id="boardStatsDonutChart"></canvas>
                </div>
            </div>
            <div class="col">
                <div class="fw-600 fs-4">{{ $total }}</div>
                <div class="small text-muted mb-2">Total tickets</div>
                <ul class="list-unstyled small mb-0">
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
    @endif
</div>
