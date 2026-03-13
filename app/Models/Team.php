<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Team extends Model
{
    public $timestamps = false;
    protected $fillable = ['name', 'description'];

    protected static function booted(): void
    {
        static::creating(function (Team $model) {
            $model->created_at = $model->created_at ?? now();
        });
    }

    public function members(): BelongsToManyMany
    {
        return $this->belongsToMany(User::class, 'team_members')->withPivot('role_in_team');
    }

    /** Projects tagged to this team. */
    public function projects(): BelongsToMany
    {
        return $this->belongsToMany(Project::class, 'team_project');
    }
}
