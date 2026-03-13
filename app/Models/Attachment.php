<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Attachment extends Model
{
    public $timestamps = false;
    protected $fillable = ['issue_id', 'file_name', 'file_path', 'file_size', 'uploaded_by'];

    protected static function booted(): void
    {
        static::creating(function (Attachment $model) {
            $model->created_at = $model->created_at ?? now();
        });
    }

    public function issue(): BelongsTo
    {
        return $this->belongsTo(Issue::class);
    }

    public function uploader(): BelongsTo
    {
        return $this->belongsTo(User::class, 'uploaded_by');
    }
}
