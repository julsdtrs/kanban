<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class IssueHistory extends Model
{
    public $timestamps = false;
    protected $fillable = ['issue_id', 'field_changed', 'old_value', 'new_value', 'changed_by'];
    protected $table = 'issue_history';

    protected static function booted(): void
    {
        static::creating(function (IssueHistory $model) {
            $model->changed_at = $model->changed_at ?? now();
        });
    }

    public function issue(): BelongsTo
    {
        return $this->belongsTo(Issue::class);
    }

    public function changedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'changed_by');
    }
}
