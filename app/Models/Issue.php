<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Issue extends Model
{
    protected $fillable = [
        'project_id', 'issue_key', 'issue_type_id', 'summary', 'description',
        'priority_id', 'status_id', 'reporter_id', 'assignee_id',
        'story_points', 'due_date', 'parent_issue_id',
    ];
    protected $casts = [
        'due_date' => 'date',
        'story_points' => 'decimal:2',
    ];

    public function project(): BelongsTo
    {
        return $this->belongsTo(Project::class);
    }

    public function issueType(): BelongsTo
    {
        return $this->belongsTo(IssueType::class, 'issue_type_id');
    }

    public function priority(): BelongsTo
    {
        return $this->belongsTo(Priority::class);
    }

    public function status(): BelongsTo
    {
        return $this->belongsTo(Status::class);
    }

    public function reporter(): BelongsTo
    {
        return $this->belongsTo(User::class, 'reporter_id');
    }

    public function assignee(): BelongsTo
    {
        return $this->belongsTo(User::class, 'assignee_id');
    }

    public function parent(): BelongsTo
    {
        return $this->belongsTo(Issue::class, 'parent_issue_id');
    }

    public function subtasks(): HasMany
    {
        return $this->hasMany(Issue::class, 'parent_issue_id');
    }

    public function labels(): BelongsToMany
    {
        return $this->belongsToMany(IssueLabel::class, 'issue_label_map', 'issue_id', 'label_id');
    }

    public function watchers(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'issue_watchers');
    }

    public function comments(): HasMany
    {
        return $this->hasMany(Comment::class);
    }

    public function attachments(): HasMany
    {
        return $this->hasMany(Attachment::class);
    }

    public function history(): HasMany
    {
        return $this->hasMany(IssueHistory::class, 'issue_id');
    }

    public function sprints(): BelongsToMany
    {
        return $this->belongsToMany(Sprint::class, 'sprint_issues');
    }
}
