<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Notification extends Model
{
    public $timestamps = false;
    protected $fillable = ['user_id', 'issue_id', 'type', 'title', 'message', 'is_read'];
    protected $casts = ['is_read' => 'boolean'];

    protected static function booted(): void
    {
        static::creating(function (Notification $model) {
            $model->created_at = $model->created_at ?? now();
        });
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function issue(): BelongsTo
    {
        return $this->belongsTo(Issue::class);
    }
}
