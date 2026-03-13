<?php

namespace Database\Seeders;

use App\Models\IssueType;
use Illuminate\Database\Seeder;

class IssueTypeSeeder extends Seeder
{
    public function run(): void
    {
        $types = [
            ['name' => 'Story', 'icon' => 'bi-journal-text', 'color' => '#198754'],
            ['name' => 'Task', 'icon' => 'bi-check2-square', 'color' => '#0d6efd'],
            ['name' => 'Bug', 'icon' => 'bi-bug', 'color' => '#dc3545'],
            ['name' => 'Epic', 'icon' => 'bi-stars', 'color' => '#6f42c1'],
        ];
        foreach ($types as $t) {
            IssueType::firstOrCreate(['name' => $t['name']], $t);
        }
    }
}
