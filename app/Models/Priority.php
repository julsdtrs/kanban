<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Priority extends Model
{
    public $timestamps = false;
    protected $fillable = ['name', 'level', 'color'];

    public function issues(): HasMany
    {
        return $this->hasMany(Issue::class, 'priority_id');
    }
}
