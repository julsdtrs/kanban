# TaskFlow – Enterprise Task & Kanban System

Laravel 12 application built from your database schema. Includes full CRUD for all setup tables, Kanban board with drag-and-drop (auto status update), and workflow diagram/editor.

**Project root:** The application lives at the repository root (no `system` subfolder). Run `php artisan serve` from this directory.

## Stack

- **PHP 8.2+**, **Laravel 12**
- **Bootstrap 5**, **Bootstrap Icons**, **jQuery**
- SQLite by default (or MySQL via `.env`)

## Setup

1. **Install dependencies** (already done if you created via Composer):
   ```bash
   composer install
   ```

2. **Environment**  
   Copy `.env.example` to `.env` if needed. Default uses SQLite (`database/database.sqlite`).

3. **Database**  
   Migrations and seeders are in place. Run:
   ```bash
   php artisan migrate:fresh --seed
   ```
   This creates an admin user: **admin@example.com** / **password**.

4. **Run the app**
   ```bash
   php artisan serve
   ```
   Open http://127.0.0.1:8000 — log in or register.

## Features

- **Auth**: Login (email or username) / Register; password stored as `password_hash`.
- **Dashboard**: Counts for projects, issues, “my issues”; recent issues list.
- **Sidebar**: All setup entities in the nav (Users, Roles, Permissions, Role Permissions, User Roles, Teams, Team Members, Organizations, Projects, Project Members, Issue Types, Priorities, Statuses, Workflows, Workflow Transitions, Issue Labels, Boards, Sprints, Notifications).
- **CRUD**: Every setup table has index/create/edit/show (and destroy) with inputs for all required/optional columns and relations.
- **Issues**: Full issue CRUD (project, type, summary, description, priority, status, reporter, assignee, story points, due date, parent issue, labels); issue key auto-generated per project.
- **Kanban**: Project selector → board with columns per status + Backlog. Drag issues between columns; status is updated via AJAX.
- **Workflow diagram**: List workflows → open diagram view; add/remove transitions (from/to status); transitions listed with delete.

## Database

Schema matches your `database.php`: users, roles, permissions, role_permissions, user_roles, teams, team_members, organizations, projects, project_members, issue_types, priorities, statuses, workflows, workflow_transitions, issues, issue_labels, issue_label_map, issue_watchers, comments, attachments, issue_history, boards, sprints, sprint_issues, notifications. All relations and indexes are reflected in migrations.

## Using MySQL

In `.env` set:

- `DB_CONNECTION=mysql`
- `DB_HOST`, `DB_PORT`, `DB_DATABASE`, `DB_USERNAME`, `DB_PASSWORD`

Then run `php artisan migrate:fresh --seed` again.
