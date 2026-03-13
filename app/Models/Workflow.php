<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Collection;

class Workflow extends Model
{
    public $timestamps = false;
    protected $fillable = ['name', 'project_id', 'board_id'];

    public function project(): BelongsTo
    {
        return $this->belongsTo(Project::class);
    }

    public function board(): BelongsTo
    {
        return $this->belongsTo(Board::class);
    }

    public function transitions(): HasMany
    {
        return $this->hasMany(WorkflowTransition::class, 'workflow_id');
    }

    /** Statuses in column order (from workflow transitions order). */
    public function getStatusesInOrder(): Collection
    {
        $transitions = $this->relationLoaded('transitions')
            ? $this->transitions->sortBy('order')
            : $this->transitions()->orderBy('order')->get();
        $order = [];
        $seen = [];
        foreach ($transitions as $t) {
            foreach ([$t->from_status_id, $t->to_status_id] as $id) {
                if (! in_array($id, $seen)) {
                    $order[] = $id;
                    $seen[] = $id;
                }
            }
        }
        if (empty($order)) {
            return collect();
        }

        return Status::whereIn('id', $order)->get()->sortBy(function ($s) use ($order) {
            return array_search($s->id, $order);
        })->values();
    }
}
