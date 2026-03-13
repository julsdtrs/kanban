<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use PHPUnit\Framework\Attributes\DataProvider;
use Tests\TestCase;

class SetupCreateRoutesTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed();
    }

    #[DataProvider('setupCreateRoutesProvider')]
    public function test_setup_create_routes_return_success_when_authenticated(string $routeName, ?array $params = null): void
    {
        $user = User::where('email', 'admin@example.com')->first();
        $this->assertNotNull($user, 'Admin user should exist after seeding');

        $url = $params ? route($routeName, $params) : route($routeName);
        $response = $this->actingAs($user)->get($url);

        $response->assertStatus(200, "Create route [{$routeName}] should return 200.");
    }

    public static function setupCreateRoutesProvider(): array
    {
        return [
            'users.create' => ['users.create'],
            'roles.create' => ['roles.create'],
            'permissions.create' => ['permissions.create'],
            'role-permissions.create' => ['role-permissions.create'],
            'user-roles.create' => ['user-roles.create'],
            'teams.create' => ['teams.create'],
            'team-members.create' => ['team-members.create'],
            'organizations.create' => ['organizations.create'],
            'projects.create' => ['projects.create'],
            'project-members.create' => ['project-members.create'],
            'issue-types.create' => ['issue-types.create'],
            'priorities.create' => ['priorities.create'],
            'statuses.create' => ['statuses.create'],
            'workflows.create' => ['workflows.create'],
            'workflow-transitions.create' => ['workflow-transitions.create'],
            'issue-labels.create' => ['issue-labels.create'],
            'boards.create' => ['boards.create'],
            'sprints.create' => ['sprints.create'],
            'issues.create' => ['issues.create'],
        ];
    }

    public function test_priorities_store_creates_and_redirects(): void
    {
        $user = User::where('email', 'admin@example.com')->first();
        $response = $this->actingAs($user)->post(route('priorities.store'), [
            '_token' => csrf_token(),
            'name' => 'Test Priority',
            'level' => 1,
            'color' => '#ccc',
        ]);
        $response->assertRedirect(route('priorities.index'));
        $response->assertSessionHas('success');
        $this->assertDatabaseHas('priorities', ['name' => 'Test Priority']);
    }

    public function test_issue_types_store_creates_and_redirects(): void
    {
        $user = User::where('email', 'admin@example.com')->first();
        $response = $this->actingAs($user)->post(route('issue-types.store'), [
            '_token' => csrf_token(),
            'name' => 'Test Type',
            'icon' => 'bug',
            'color' => 'red',
        ]);
        $response->assertRedirect(route('issue-types.index'));
        $response->assertSessionHas('success');
        $this->assertDatabaseHas('issue_types', ['name' => 'Test Type']);
    }

    public function test_roles_store_creates_and_redirects(): void
    {
        $user = User::where('email', 'admin@example.com')->first();
        $response = $this->actingAs($user)->post(route('roles.store'), [
            '_token' => csrf_token(),
            'name' => 'Test Role',
        ]);
        $response->assertRedirect(route('roles.index'));
        $response->assertSessionHas('success');
        $this->assertDatabaseHas('roles', ['name' => 'Test Role']);
    }

    public function test_organizations_store_creates_and_redirects(): void
    {
        $user = User::where('email', 'admin@example.com')->first();
        $response = $this->actingAs($user)->post(route('organizations.store'), [
            '_token' => csrf_token(),
            'name' => 'Test Org',
            'description' => 'Description',
        ]);
        $response->assertRedirect(route('organizations.index'));
        $response->assertSessionHas('success');
        $this->assertDatabaseHas('organizations', ['name' => 'Test Org']);
    }

    public function test_statuses_store_creates_and_redirects(): void
    {
        $user = User::where('email', 'admin@example.com')->first();
        $response = $this->actingAs($user)->post(route('statuses.store'), [
            '_token' => csrf_token(),
            'name' => 'Test Status',
            'category' => 'todo',
            'order_no' => 99,
        ]);
        $response->assertRedirect(route('statuses.index'));
        $response->assertSessionHas('success');
        $this->assertDatabaseHas('statuses', ['name' => 'Test Status']);
    }
}
