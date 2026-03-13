<?php

namespace Database\Seeders;

use App\Models\Role;
use Illuminate\Database\Seeder;

class RoleSeeder extends Seeder
{
    public function run(): void
    {
        $roles = [
            ['name' => 'Administrator', 'description' => 'Full system access'],
            ['name' => 'Project Admin', 'description' => 'Manage projects and members'],
            ['name' => 'Developer', 'description' => 'Work on issues and sprints'],
            ['name' => 'Viewer', 'description' => 'Read-only access'],
        ];
        foreach ($roles as $r) {
            Role::firstOrCreate(['name' => $r['name']], $r);
        }
    }
}
