<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class IssueType extends Model
{
    public $timestamps = false;
    protected $fillable = ['name', 'icon', 'color'];

    public function issues(): HasMany
    {
        return $this->hasMany(Issue::class, 'issue_type_id');
    }
}
