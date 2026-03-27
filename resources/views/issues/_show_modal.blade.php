<div class="card setup-detail-card border-0 shadow-none mb-0">
    <div class="card-header d-flex justify-content-between align-items-center">
        <div class="me-3">
            <div class="fw-semibold small text-uppercase text-muted mb-1">Issue</div>
            <div class="d-flex flex-wrap align-items-center gap-2">
                <span class="badge bg-primary bg-opacity-10 text-primary fw-semibold">{{ $issue->issue_key }}</span>
                <span class="fw-semibold">{{ Str::limit($issue->summary, 80) }}</span>
            </div>
        </div>
        <div class="d-flex align-items-center gap-2">
            @if($issue->status)
                <span class="badge" style="background: {{ $issue->status->color ?? '#6c757d' }}20; color: {{ $issue->status->color ?? '#6c757d' }};">
                    {{ $issue->status->name }}
                </span>
            @endif
            @if($issue->priority)
                <span class="badge" style="background: {{ $issue->priority->color ?? '#6c757d' }}20; color: {{ $issue->priority->color ?? '#6c757d' }};">
                    {{ $issue->priority->name }}
                </span>
            @endif
            <a href="{{ route('issues.edit', $issue) }}" class="btn btn-sm btn-primary">Edit</a>
        </div>
    </div>
    <div class="card-body">
        <div class="row g-3">
            <div class="col-md-6">
                <dl class="row mb-0 small">
                    <dt class="col-sm-4">Project</dt>
                    <dd class="col-sm-8"><a href="{{ route('projects.show', $issue->project) }}">{{ $issue->project->name ?? '-' }}</a></dd>
                    <dt class="col-sm-4">Type</dt>
                    <dd class="col-sm-8">{{ $issue->issueType->name ?? '-' }}</dd>
                    <dt class="col-sm-4">Reporter</dt>
                    <dd class="col-sm-8">{{ $issue->reporter->display_name ?? $issue->reporter->username ?? '-' }}</dd>
                    <dt class="col-sm-4">Assignee</dt>
                    <dd class="col-sm-8">{{ $issue->assignee->display_name ?? $issue->assignee->username ?? '-' }}</dd>
                    <dt class="col-sm-4">Story points</dt>
                    <dd class="col-sm-8">{{ $issue->story_points ?? '-' }}</dd>
                    <dt class="col-sm-4">Due date</dt>
                    <dd class="col-sm-8">{{ $issue->due_date ? $issue->due_date->format('Y-m-d') : '-' }}</dd>
                    <dt class="col-sm-4">Parent</dt>
                    <dd class="col-sm-8">
                        @if($issue->parent)
                            <a href="{{ route('issues.show', $issue->parent) }}">{{ $issue->parent->issue_key }}</a>
                        @else
                            —
                        @endif
                    </dd>
                    <dt class="col-sm-4">Labels</dt>
                    <dd class="col-sm-8">
                        @forelse($issue->labels ?? [] as $l)
                            <span class="badge bg-secondary me-1">{{ $l->name }}</span>
                        @empty
                            —
                        @endforelse
                    </dd>
                </dl>
            </div>
            <div class="col-md-6">
                <div class="mb-3">
                    <div class="fw-semibold small text-uppercase text-muted mb-1">Description</div>
                    <div class="small">{!! $issue->description ?: 'No description.' !!}</div>
                </div>
                <div>
                    <div class="fw-semibold small text-uppercase text-muted mb-1">Comments</div>
                    <div class="border-start border-3 border-light ps-3 small" style="max-height: 220px; overflow-y: auto;">
                        @forelse($issue->comments ?? [] as $comment)
                        <div class="mb-3">
                            <strong>{{ $comment->user->display_name ?? $comment->user->username ?? 'User' }}</strong>
                            <span class="text-muted small">{{ $comment->created_at ? $comment->created_at->format('Y-m-d H:i') : '' }}</span>
                            <div class="mt-1">{{ $comment->comment_text ?? '-' }}</div>
                        </div>
                        @empty
                        <p class="text-muted mb-0">No comments yet.</p>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
