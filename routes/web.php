<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\BoardController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\GlobalSearchController;
use App\Http\Controllers\IssueController;
use App\Http\Controllers\IssueLabelController;
use App\Http\Controllers\IssueTypeController;
use App\Http\Controllers\KanbanController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\OrganizationController;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\PriorityController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\ProjectMemberController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\RolePermissionController;
use App\Http\Controllers\SprintController;
use App\Http\Controllers\StatusController;
use App\Http\Controllers\TeamController;
use App\Http\Controllers\TeamMemberController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\UserRoleController;
use App\Http\Controllers\WorkflowController;
use App\Http\Controllers\WorkflowDiagramController;
use App\Http\Controllers\WorkflowTransitionController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return auth()->check() ? redirect()->route('dashboard') : view('welcome');
});

Route::middleware('guest')->group(function () {
    Route::get('login', [LoginController::class, 'showLoginForm'])->name('login');
    Route::post('login', [LoginController::class, 'login']);
    Route::get('register', [RegisterController::class, 'showRegistrationForm'])->name('register');
    Route::post('register', [RegisterController::class, 'register']);
});

Route::middleware('auth')->group(function () {
    Route::post('logout', [LoginController::class, 'logout'])->name('logout');
    Route::get('dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('dashboard/board-stats/{project}', [DashboardController::class, 'boardStatsContent'])->name('dashboard.board-stats');
    Route::get('search/global', GlobalSearchController::class)->name('search.global');

    Route::get('kanban', [KanbanController::class, 'index'])->name('kanban.index');
    Route::get('kanban/board/{board}', [KanbanController::class, 'showBoard'])->name('kanban.board.show');
    Route::get('kanban/project/{project}', [KanbanController::class, 'board'])->name('kanban.board');
    Route::post('kanban/issue/{issue}/status', [KanbanController::class, 'updateStatus'])->name('kanban.update-status');

    Route::get('workflows/diagram', [WorkflowDiagramController::class, 'index'])->name('workflows.diagram.index');
    Route::get('workflows/diagram/{workflow}', [WorkflowDiagramController::class, 'show'])->name('workflows.diagram.show');
    Route::post('workflows/diagram/transition', [WorkflowDiagramController::class, 'storeTransition'])->name('workflows.diagram.store-transition');
    Route::post('workflows/diagram/{workflow}/reorder', [WorkflowDiagramController::class, 'reorderTransitions'])->name('workflows.diagram.reorder');
    Route::delete('workflows/diagram/transition/{workflowTransition}', [WorkflowDiagramController::class, 'destroyTransition'])->name('workflows.diagram.destroy-transition');

    Route::resource('users', UserController::class);
    Route::resource('roles', RoleController::class);
    Route::resource('permissions', PermissionController::class);
    Route::resource('role-permissions', RolePermissionController::class)->parameters(['role_permission' => 'rolePermission'])->except('show');
    Route::resource('user-roles', UserRoleController::class)->parameters(['user_role' => 'userRole'])->except('show');
    Route::resource('teams', TeamController::class);
    Route::resource('team-members', TeamMemberController::class)->parameters(['team_member' => 'teamMember'])->except('show');
    Route::resource('organizations', OrganizationController::class);
    Route::resource('projects', ProjectController::class);
    Route::resource('project-members', ProjectMemberController::class)->parameters(['project_member' => 'projectMember'])->except('show');
    Route::resource('issue-types', IssueTypeController::class)->parameters(['issue-types' => 'issueType']);
    Route::resource('priorities', PriorityController::class);
    Route::post('statuses/reorder', [StatusController::class, 'reorder'])->name('statuses.reorder');
    Route::resource('statuses', StatusController::class);
    Route::resource('workflows', WorkflowController::class);
    Route::resource('workflow-transitions', WorkflowTransitionController::class)->parameters(['workflow-transitions' => 'workflowTransition']);
    Route::resource('issue-labels', IssueLabelController::class)->parameters(['issue-labels' => 'issueLabel']);
    Route::resource('boards', BoardController::class);
    Route::resource('sprints', SprintController::class);
    Route::resource('issues', IssueController::class);
    Route::resource('notifications', NotificationController::class)->only(['index', 'show', 'update']);
});
