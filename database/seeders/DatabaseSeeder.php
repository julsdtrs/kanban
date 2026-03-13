<?php

namespace Database\Seeders;

use App\Models\Organization;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call([
            RoleSeeder::class,
            PermissionSeeder::class,
            StatusSeeder::class,
            IssueTypeSeeder::class,
            PrioritySeeder::class,
        ]);

        $admin = User::firstOrCreate(
            ['email' => 'admin@example.com'],
            [
                'username' => 'admin',
                'password_hash' => Hash::make('password'),
                'display_name' => 'Administrator',
                'is_active' => true,
            ]
        );
        $adminRole = \App\Models\Role::where('name', 'Administrator')->first();
        if ($adminRole && !$admin->roles()->where('role_id', $adminRole->id)->exists()) {
            $admin->roles()->attach($adminRole->id);
        }

        Organization::firstOrCreate(
            ['name' => 'Default Organization'],
            ['description' => 'Default organization']
        );

        $this->call(PhilippinesSchoolsSeeder::class);
        $this->call(KanbanWorkflowSeeder::class);
    }
}
