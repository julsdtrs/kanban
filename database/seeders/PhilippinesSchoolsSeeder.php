<?php

namespace Database\Seeders;

use App\Models\Issue;
use App\Models\IssueType;
use App\Models\Organization;
use App\Models\Priority;
use App\Models\Project;
use App\Models\Status;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class PhilippinesSchoolsSeeder extends Seeder
{
    public function run(): void
    {
        $org = Organization::firstOrCreate(
            ['name' => 'Philippines Schools'],
            ['description' => 'Schools and universities in the Philippines - IT and enrollment projects']
        );

        $statusTodo = Status::where('name', 'To Do')->first();
        $statusInProgress = Status::where('name', 'In Progress')->first();
        $statusDone = Status::where('name', 'Done')->first();
        $priorityMedium = Priority::where('name', 'Medium')->first();
        $priorityHigh = Priority::where('name', 'High')->first();
        $typeTask = IssueType::where('name', 'Task')->first();
        $typeBug = IssueType::where('name', 'Bug')->first();
        $typeStory = IssueType::where('name', 'Story')->first();

        $schools = [
            ['key' => 'UPD', 'name' => 'UP Diliman - Enrollment System', 'desc' => 'University of the Philippines Diliman enrollment and registration'],
            ['key' => 'ADMU', 'name' => 'Ateneo de Manila - LMS', 'desc' => 'Ateneo de Manila University Learning Management System'],
            ['key' => 'DLSU', 'name' => 'DLSU Manila - Student Portal', 'desc' => 'De La Salle University Manila student and faculty portal'],
            ['key' => 'UST', 'name' => 'UST - Library System', 'desc' => 'University of Santo Tomas library and research portal'],
            ['key' => 'MAPUA', 'name' => 'Mapúa University - LMS', 'desc' => 'Mapúa University online learning platform'],
            ['key' => 'FEU', 'name' => 'FEU - Enrollment Portal', 'desc' => 'Far Eastern University enrollment and assessment'],
            ['key' => 'SILLIMAN', 'name' => 'Silliman University - Campus IT', 'desc' => 'Silliman University Dumaguete campus systems'],
            ['key' => 'XU', 'name' => 'Xavier University Cagayan - Portal', 'desc' => 'Xavier University - Ateneo de Cagayan student portal'],
        ];

        $users = [];
        $names = [
            'Maria Santos', 'Jose Reyes', 'Ana Cruz', 'Carlos Mendoza', 'Elena Bautista',
            'Roberto Garcia', 'Carmen Lopez', 'Antonio Torres', 'Rosa Fernandez', 'Miguel Ramos',
        ];
        foreach ($names as $i => $name) {
            $username = 'ph' . ($i + 1) . '_' . strtolower(str_replace(' ', '', $name));
            $users[] = User::firstOrCreate(
                ['email' => $username . '@schools.ph'],
                [
                    'username' => $username,
                    'password_hash' => Hash::make('password'),
                    'display_name' => $name,
                    'is_active' => true,
                ]
            );
        }

        $admin = User::where('email', 'admin@example.com')->first();
        if ($admin) {
            $users[] = $admin;
        }

        $projects = [];
        foreach ($schools as $s) {
            $projects[] = Project::firstOrCreate(
                [
                    'organization_id' => $org->id,
                    'project_key' => $s['key'],
                ],
                [
                    'name' => $s['name'],
                    'description' => $s['desc'] ?? null,
                    'lead_user_id' => $users[array_rand($users)]->id,
                    'project_type' => 'scrum',
                    'is_active' => true,
                ]
            );
        }

        $issueTemplates = [
            'Fix login timeout on student portal',
            'Enrollment form validation errors',
            'Grade submission deadline reminder',
            'LMS video playback on mobile',
            'Export student list to Excel',
            'Password reset email not received',
            'Calendar sync with academic calendar',
            'Library book reservation not updating',
            'Faculty dashboard loading slow',
            'Student ID photo upload size limit',
            'Course materials download failed',
            'Attendance module duplicate entries',
            'Payment gateway integration test',
            'Report generation timeout',
            'Notification preferences not saving',
            'Bulk import student records',
            'SSO login with DepEd credentials',
            'Offline quiz submission sync',
        ];

        foreach ($projects as $project) {
            $nextNum = Issue::where('project_id', $project->id)->count() + 1;
            $numIssues = rand(3, 8);
            for ($i = 0; $i < $numIssues; $i++) {
                $summary = $issueTemplates[array_rand($issueTemplates)];
                $issueKey = $project->project_key . '-' . $nextNum;
                $nextNum++;
                $assignee = $users[array_rand($users)];
                $reporter = $users[array_rand($users)];
                $status = [$statusTodo, $statusInProgress, $statusDone][array_rand([0, 1, 2])];
                $type = [$typeTask, $typeBug, $typeStory][array_rand([0, 1, 2])];
                Issue::firstOrCreate(
                    ['issue_key' => $issueKey],
                    [
                        'project_id' => $project->id,
                        'issue_type_id' => $type->id,
                        'summary' => $summary,
                        'description' => 'Sample issue for ' . $project->name,
                        'priority_id' => rand(0, 1) ? $priorityMedium?->id : $priorityHigh?->id,
                        'status_id' => $status?->id,
                        'reporter_id' => $reporter->id,
                        'assignee_id' => $assignee->id,
                    ]
                );
            }
        }
    }
}
