<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'username',
        'email',
        'password_hash',
        'display_name',
        'avatar',
        'is_active',
    ];

    protected $hidden = [
        'password_hash',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'is_active' => 'boolean',
        ];
    }

    public function getAuthPassword(): string
    {
        return $this->password_hash;
    }

    public function setPasswordAttribute(?string $value): void
    {
        if ($value) {
            $this->attributes['password_hash'] = bcrypt($value);
        }
    }

    public function roles(): BelongsToMany
    {
        return $this->belongsToMany(Role::class, 'user_roles');
    }

    public function teams(): BelongsToMany
    {
        return $this->belongsToMany(Team::class, 'team_members')->withPivot('role_in_team');
    }

    public function ledProjects(): HasMany
    {
        return $this->hasMany(Project::class, 'lead_user_id');
    }

    public function projectMemberships(): BelongsToMany
    {
        return $this->belongsToMany(Project::class, 'project_members')->withPivot('role_id');
    }

    public function reportedIssues(): HasMany
    {
        return $this->hasMany(Issue::class, 'reporter_id');
    }

    public function assignedIssues(): HasMany
    {
        return $this->hasMany(Issue::class, 'assignee_id');
    }

    public function comments(): HasMany
    {
        return $this->hasMany(Comment::class);
    }

    public function notifications(): HasMany
    {
        return $this->hasMany(Notification::class);
    }

    public function watchedIssues(): BelongsToMany
    {
        return $this->belongsToMany(Issue::class, 'issue_watchers');
    }

    public function getNameAttribute(): string
    {
        return $this->display_name ?? $this->username;
    }
}
