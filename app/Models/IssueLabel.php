<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class IssueLabel extends Model
{
    public $timestamps = false;
    protected $fillable = ['name', 'color'];
    protected $table = 'issue_labels';

    public function issues(): BelongsToMany
    {
        return $this->belongsToMany(Issue::class, 'issue_label_map', 'label_id', 'issue_id');
    }
}
