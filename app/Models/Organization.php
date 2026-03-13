<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Organization extends Model
{
    public $timestamps = false;
    protected $fillable = ['name', 'description'];

    protected static function booted(): void
    {
        static::creating(function (Organization $model) {
            $model->created_at = $model->created_at ?? now();
        });
    }

    public function projects(): HasMany
    {
        return $this->hasMany(Project::class, 'organization_id');
    }
}
