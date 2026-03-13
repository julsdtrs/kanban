<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Sprint extends Model
{
    public $timestamps = false;
    protected $fillable = ['board_id', 'name', 'goal', 'start_date', 'end_date', 'state'];
    protected $casts = [
        'start_date' => 'date',
        'end_date' => 'date',
    ];

    protected static function booted(): void
    {
        static::creating(function (Sprint $model) {
            $model->created_at = $model->created_at ?? now();
        });
    }

    public function board(): BelongsTo
    {
        return $this->belongsTo(Board::class);
    }

    public function issues(): BelongsToMany
    {
        return $this->belongsToMany(Issue::class, 'sprint_issues');
    }
}
