<?php

namespace Database\Seeders;

use App\Models\Priority;
use Illuminate\Database\Seeder;

class PrioritySeeder extends Seeder
{
    public function run(): void
    {
        $priorities = [
            ['name' => 'Highest', 'level' => 1, 'color' => '#dc3545'],
            ['name' => 'High', 'level' => 2, 'color' => '#fd7e14'],
            ['name' => 'Medium', 'level' => 3, 'color' => '#ffc107'],
            ['name' => 'Low', 'level' => 4, 'color' => '#0d6efd'],
            ['name' => 'Lowest', 'level' => 5, 'color' => '#6c757d'],
        ];
        foreach ($priorities as $p) {
            Priority::firstOrCreate(['name' => $p['name']], $p);
        }
    }
}
