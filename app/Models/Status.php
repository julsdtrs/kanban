<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Status extends Model
{
    public $timestamps = false;
    protected $fillable = ['name', 'category', 'color', 'order_no'];

    public function issues(): HasMany
    {
        return $this->hasMany(Issue::class, 'status_id');
    }

    public function transitionsFrom(): HasMany
    {
        return $this->hasMany(WorkflowTransition::class, 'from_status_id');
    }

    public function transitionsTo(): HasMany
    {
        return $this->hasMany(WorkflowTransition::class, 'to_status_id');
    }
}
