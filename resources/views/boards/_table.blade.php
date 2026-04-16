@include('partials.list-table-controls', ['paginator' => $boards, 'searchPlaceholder' => 'Search boards'])
<div class="table-responsive">
    <table class="table table-hover align-middle mb-0">
        <thead class="table-light"><tr><th class="board-projects-col">Projects</th><th>Name</th><th>Type</th><th width="140"></th></tr></thead>
        <tbody>
            @forelse($boards as $board)
            <tr>
                <td class="board-projects-cell">
                    @php
                        if ($board->relationLoaded('projects') && $board->projects->isNotEmpty()) {
                            $boardProjects = $board->projects;
                        } elseif ($board->project) {
                            $boardProjects = collect([$board->project]);
                        } else {
                            $boardProjects = collect();
                        }
                    @endphp
                    @if($boardProjects->isEmpty())
                        <span class="text-muted">—</span>
                    @else
                        <div class="board-projects-badges d-flex flex-wrap gap-1 align-items-center">
                            @foreach($boardProjects->take(6) as $p)
                                <a href="{{ route('projects.show', $p) }}" class="board-project-badge text-decoration-none" title="{{ $p->name }}">{{ $p->project_key ?: Str::limit($p->name, 18) }}</a>
                            @endforeach
                            @if($boardProjects->count() > 6)
                                <span class="board-projects-more" title="{{ $boardProjects->slice(6)->pluck('name')->filter()->join(', ') }}">+{{ $boardProjects->count() - 6 }} more</span>
                            @endif
                        </div>
                    @endif
                </td>
                <td>{{ $board->name ?? '—' }}</td>
                <td><span class="badge bg-secondary">{{ $board->board_type }}</span></td>
                <td>
                    <button type="button" class="btn btn-sm btn-outline-secondary btn-view" data-load="{{ route('boards.show', $board) }}?modal=1" data-title="View Board">View</button>
                    <button type="button" class="btn btn-sm btn-outline-primary btn-edit" data-load="{{ route('boards.edit', $board) }}?modal=1" data-submit="{{ route('boards.update', $board) }}" data-method="PUT" data-title="Edit Board">Edit</button>
                    <button type="button" class="btn btn-sm btn-outline-danger btn-delete" data-url="{{ route('boards.destroy', $board) }}" data-confirm="Delete this board?">Delete</button>
                </td>
            </tr>
            @empty
            <tr><td colspan="4" class="text-center text-muted py-4">No boards yet.</td></tr>
            @endforelse
        </tbody>
    </table>
</div>
@include('partials.list-table-footer', ['paginator' => $boards])
