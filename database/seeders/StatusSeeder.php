<?php

namespace Database\Seeders;

use App\Models\Status;
use Illuminate\Database\Seeder;

class StatusSeeder extends Seeder
{
    public function run(): void
    {
        $statuses = [
            ['name' => 'To Do', 'category' => 'todo', 'color' => '#6c757d', 'order_no' => 1],
            ['name' => 'In Progress', 'category' => 'in_progress', 'color' => '#0d6efd', 'order_no' => 2],
            ['name' => 'In Review', 'category' => 'in_progress', 'color' => '#fd7e14', 'order_no' => 3],
            ['name' => 'Done', 'category' => 'done', 'color' => '#198754', 'order_no' => 4],
        ];
        foreach ($statuses as $s) {
            Status::firstOrCreate(['name' => $s['name']], $s);
        }
    }
}
