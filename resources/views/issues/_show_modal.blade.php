<div class="card setup-detail-card border-0 shadow-none mb-0 issue-show-modal">
    <div class="card-header d-flex flex-wrap justify-content-between align-items-start gap-3">
        <div class="me-2 flex-grow-1 min-w-0">
            <div class="fw-semibold small text-uppercase text-muted mb-1">Issue</div>
            <div class="d-flex flex-wrap align-items-center gap-2 mb-2">
                <span class="badge bg-primary bg-opacity-10 text-primary fw-semibold">{{ $issue->issue_key }}</span>
                @if($issue->issueType)
                    <span class="badge bg-secondary bg-opacity-10 text-secondary">{{ $issue->issueType->name }}</span>
                @endif
            </div>
            <h2 class="h5 mb-0 fw-semibold text-break">{{ $issue->summary }}</h2>
        </div>
        <div class="d-flex flex-wrap align-items-center gap-2 flex-shrink-0">
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
        <div class="row g-4">
            <div class="col-lg-6">
                <div class="text-uppercase small fw-semibold text-muted mb-2">Work</div>
                <dl class="row mb-0 small gx-2">
                    <dt class="col-5 text-muted fw-normal">Project</dt>
                    <dd class="col-7 mb-2 text-break">
                        @if($issue->project)
                            <a href="{{ route('projects.show', $issue->project) }}">{{ $issue->project->name }}</a>
                        @else
                            —
                        @endif
                    </dd>
                    <dt class="col-5 text-muted fw-normal">Type</dt>
                    <dd class="col-7 mb-2">{{ $issue->issueType->name ?? '—' }}</dd>
                    <dt class="col-5 text-muted fw-normal">Story points</dt>
                    <dd class="col-7 mb-2">{{ $issue->story_points !== null ? $issue->story_points : '—' }}</dd>
                    <dt class="col-5 text-muted fw-normal">Due date</dt>
                    <dd class="col-7 mb-2">{{ $issue->due_date ? $issue->due_date->format('Y-m-d') : '—' }}</dd>
                    <dt class="col-5 text-muted fw-normal">Sprints</dt>
                    <dd class="col-7 mb-2">
                        @if(($issue->sprints ?? collect())->isNotEmpty())
                            {{ $issue->sprints->pluck('name')->filter()->join(', ') ?: '—' }}
                        @else
                            —
                        @endif
                    </dd>
                    <dt class="col-5 text-muted fw-normal">Parent</dt>
                    <dd class="col-7 mb-2">
                        @if($issue->parent)
                            <a href="{{ route('issues.show', $issue->parent) }}">{{ $issue->parent->issue_key }} — {{ Str::limit($issue->parent->summary, 40) }}</a>
                        @else
                            —
                        @endif
                    </dd>
                    <dt class="col-5 text-muted fw-normal">Subtasks</dt>
                    <dd class="col-7 mb-2">
                        @if(($issue->subtasks ?? collect())->isNotEmpty())
                            <ul class="list-unstyled mb-0 small">
                                @foreach($issue->subtasks as $st)
                                    <li class="mb-1"><a href="{{ route('issues.show', $st) }}">{{ $st->issue_key }}</a> — {{ Str::limit($st->summary, 48) }}</li>
                                @endforeach
                            </ul>
                        @else
                            —
                        @endif
                    </dd>
                    <dt class="col-5 text-muted fw-normal">Labels</dt>
                    <dd class="col-7 mb-2">
                        @forelse($issue->labels ?? [] as $l)
                            <span class="badge bg-secondary me-1 mb-1">{{ $l->name }}</span>
                        @empty
                            —
                        @endforelse
                    </dd>
                </dl>
            </div>
            <div class="col-lg-6">
                <div class="text-uppercase small fw-semibold text-muted mb-2">People &amp; record</div>
                <dl class="row mb-0 small gx-2">
                    <dt class="col-5 text-muted fw-normal">Reporter</dt>
                    <dd class="col-7 mb-2">{{ $issue->reporter->display_name ?? $issue->reporter->username ?? '—' }}</dd>
                    <dt class="col-5 text-muted fw-normal">Assignee</dt>
                    <dd class="col-7 mb-2">{{ $issue->assignee->display_name ?? $issue->assignee->username ?? '—' }}</dd>
                    <dt class="col-5 text-muted fw-normal">Watchers</dt>
                    <dd class="col-7 mb-2">
                        @if(($issue->watchers ?? collect())->isNotEmpty())
                            {{ $issue->watchers->map(fn ($u) => $u->display_name ?? $u->username)->filter()->join(', ') }}
                        @else
                            —
                        @endif
                    </dd>
                    <dt class="col-5 text-muted fw-normal">Created</dt>
                    <dd class="col-7 mb-2">{{ $issue->created_at ? $issue->created_at->format('Y-m-d H:i') : '—' }}</dd>
                    <dt class="col-5 text-muted fw-normal">Updated</dt>
                    <dd class="col-7 mb-2">{{ $issue->updated_at ? $issue->updated_at->format('Y-m-d H:i') : '—' }}</dd>
                    <dt class="col-5 text-muted fw-normal">Attachments</dt>
                    <dd class="col-7 mb-2">
                        @if(($issue->attachments ?? collect())->isNotEmpty())
                            <ul class="list-unstyled mb-0 small">
                                @foreach($issue->attachments as $att)
                                    <li class="mb-1 text-break">
                                        {{ $att->file_name ?? 'File' }}
                                        @if($att->file_size)
                                            <span class="text-muted">({{ number_format((int) $att->file_size / 1024, 1) }} KB)</span>
                                        @endif
                                        @if($att->uploader)
                                            <span class="text-muted">· {{ $att->uploader->display_name ?? $att->uploader->username }}</span>
                                        @endif
                                    </li>
                                @endforeach
                            </ul>
                        @else
                            —
                        @endif
                    </dd>
                </dl>
            </div>
        </div>

        <hr class="my-4">

        <div class="mb-4">
            <div class="text-uppercase small fw-semibold text-muted mb-2">Description</div>
            <div class="issue-modal-description border rounded p-3 bg-body-secondary bg-opacity-50">
                @if($issue->description)
                    {!! $issue->description !!}
                @else
                    <span class="text-muted">No description.</span>
                @endif
            </div>
        </div>

        <div>
            <div class="text-uppercase small fw-semibold text-muted mb-2">Comments</div>
            <div class="border rounded p-3 bg-body-secondary bg-opacity-25" style="max-height: 240px; overflow-y: auto;">
                @forelse($issue->comments ?? [] as $comment)
                    <div class="mb-3 pb-3 border-bottom border-light {{ $loop->last ? 'border-0 mb-0 pb-0' : '' }}">
                        <div class="d-flex flex-wrap align-items-baseline gap-2">
                            <strong class="small">{{ $comment->user->display_name ?? $comment->user->username ?? 'User' }}</strong>
                            <span class="text-muted small">{{ $comment->created_at ? $comment->created_at->format('Y-m-d H:i') : '' }}</span>
                        </div>
                        <div class="mt-1 small text-break">{{ $comment->comment_text ?? '—' }}</div>
                    </div>
                @empty
                    <p class="text-muted small mb-0">No comments yet.</p>
                @endforelse
            </div>
        </div>
    </div>
</div>
