<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Project extends Model
{
    public $timestamps = false;
    protected $fillable = [
        'organization_id', 'project_key', 'name', 'description',
        'lead_user_id', 'project_type', 'is_active',
    ];
    protected $casts = ['is_active' => 'boolean'];

    protected static function booted(): void
    {
        static::creating(function (Project $model) {
            $model->created_at = $model->created_at ?? now();
        });
    }

    public function organization(): BelongsTo
    {
        return $this->belongsTo(Organization::class);
    }

    public function lead(): BelongsTo
    {
        return $this->belongsTo(User::class, 'lead_user_id');
    }

    public function members(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'project_members')->withPivot('role_id');
    }

    public function issues(): HasMany
    {
        return $this->hasMany(Issue::class);
    }

    public function workflows(): HasMany
    {
        return $this->hasMany(Workflow::class);
    }

    /** Workflow used for Kanban board columns (name = "Kanban"). */
    public function kanbanWorkflow(): ?Workflow
    {
        return $this->workflows()->where('name', 'Kanban')->first();
    }

    public function boards(): HasMany
    {
        return $this->hasMany(Board::class);
    }

    /** Boards that have this project tagged (many-to-many). */
    public function boardsTagged(): BelongsToMany
    {
        return $this->belongsToMany(Board::class, 'board_project');
    }

    /** Teams tagged to this project. */
    public function teams(): BelongsToMany
    {
        return $this->belongsToMany(Team::class, 'team_project');
    }
}
