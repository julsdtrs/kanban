<?php

namespace Database\Seeders;

use App\Models\Project;
use App\Models\Status;
use App\Models\Workflow;
use App\Models\WorkflowTransition;
use Illuminate\Database\Seeder;

class KanbanWorkflowSeeder extends Seeder
{
    public function run(): void
    {
        $statuses = Status::orderBy('order_no')->get();
        if ($statuses->isEmpty()) {
            return;
        }

        $projects = Project::where('is_active', true)->get();

        foreach ($projects as $project) {
            $workflow = Workflow::firstOrCreate(
                [
                    'project_id' => $project->id,
                    'name' => 'Kanban',
                ],
                ['name' => 'Kanban']
            );

            $ids = $statuses->pluck('id')->all();
            $order = 0;

            for ($i = 0; $i < count($ids) - 1; $i++) {
                $fromId = $ids[$i];
                $toId = $ids[$i + 1];
                WorkflowTransition::firstOrCreate(
                    [
                        'workflow_id' => $workflow->id,
                        'from_status_id' => $fromId,
                        'to_status_id' => $toId,
                    ],
                    [
                        'transition_name' => null,
                        'order' => $order++,
                    ]
                );
            }
        }
    }
}
