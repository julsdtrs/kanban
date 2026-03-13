<?php

namespace Database\Seeders;

use App\Models\Permission;
use Illuminate\Database\Seeder;

class PermissionSeeder extends Seeder
{
    public function run(): void
    {
        $permissions = [
            ['code' => 'users.manage', 'description' => 'Manage users'],
            ['code' => 'roles.manage', 'description' => 'Manage roles and permissions'],
            ['code' => 'organizations.manage', 'description' => 'Manage organizations'],
            ['code' => 'projects.manage', 'description' => 'Manage projects'],
            ['code' => 'issues.manage', 'description' => 'Manage issues'],
            ['code' => 'workflows.manage', 'description' => 'Manage workflows'],
        ];
        foreach ($permissions as $p) {
            Permission::firstOrCreate(['code' => $p['code']], $p);
        }
    }
}
