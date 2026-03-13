<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Board extends Model
{
    public $timestamps = false;
    protected $fillable = ['project_id', 'name', 'board_type'];

    protected static function booted(): void
    {
        static::creating(function (Board $model) {
            $model->created_at = $model->created_at ?? now();
        });
    }

    /** Primary/default project (for backward compatibility and sprints). */
    public function project(): BelongsTo
    {
        return $this->belongsTo(Project::class);
    }

    /** All projects tagged to this board. */
    public function projects(): BelongsToMany
    {
        return $this->belongsToMany(Project::class, 'board_project');
    }

    public function sprints(): HasMany
    {
        return $this->hasMany(Sprint::class);
    }

    public function workflows(): HasMany
    {
        return $this->hasMany(Workflow::class);
    }
}
