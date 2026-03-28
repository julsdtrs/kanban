<?php

namespace App\Http\Controllers;

use App\Models\Board;
use App\Models\Issue;
use App\Models\Project;
use App\Models\Sprint;
use App\Models\Team;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class GlobalSearchController extends Controller
{
    private const ALLOWED_TYPES = ['issues', 'projects', 'users', 'teams', 'sprints', 'boards'];

    public function __invoke(Request $request): JsonResponse
    {
        $q = trim((string) $request->query('q', ''));

        $empty = [
            'issues' => [],
            'projects' => [],
            'users' => [],
            'teams' => [],
            'sprints' => [],
            'boards' => [],
        ];

        if (strlen($q) < 2) {
            return response()->json($empty);
        }

        $types = $this->resolveTypes($request);
        $n = count($types);
        $perGroup = $n >= 5 ? 6 : ($n <= 2 ? 16 : 10);

        $payload = $empty;

        if (in_array('issues', $types, true)) {
            $payload['issues'] = Issue::query()
                ->with(['project:id,name'])
                ->where(function ($query) use ($q) {
                    $query->where('issue_key', 'like', "%{$q}%")
                        ->orWhere('summary', 'like', "%{$q}%");
                })
                ->latest('id')
                ->limit($perGroup)
                ->get()
                ->map(fn (Issue $i) => [
                    'id' => $i->id,
                    'issue_key' => $i->issue_key,
                    'summary' => $i->summary,
                    'project_name' => $i->project->name ?? '',
                    'url' => route('issues.show', $i),
                ])
                ->values();
        }

        if (in_array('projects', $types, true)) {
            $payload['projects'] = Project::query()
                ->where('is_active', true)
                ->where(function ($query) use ($q) {
                    $query->where('name', 'like', "%{$q}%")
                        ->orWhere('project_key', 'like', "%{$q}%")
                        ->orWhere('description', 'like', "%{$q}%");
                })
                ->orderBy('name')
                ->limit($perGroup)
                ->get()
                ->map(fn (Project $p) => [
                    'id' => $p->id,
                    'name' => $p->name,
                    'project_key' => $p->project_key,
                    'url' => route('projects.show', $p),
                ])
                ->values();
        }

        if (in_array('users', $types, true)) {
            $payload['users'] = User::query()
                ->where('is_active', true)
                ->where(function ($query) use ($q) {
                    $query->where('username', 'like', "%{$q}%")
                        ->orWhere('display_name', 'like', "%{$q}%")
                        ->orWhere('email', 'like', "%{$q}%");
                })
                ->orderByRaw('COALESCE(display_name, username) asc')
                ->limit($perGroup)
                ->get()
                ->map(fn (User $u) => [
                    'id' => $u->id,
                    'name' => $u->name,
                    'username' => $u->username,
                    'url' => route('users.show', $u),
                ])
                ->values();
        }

        if (in_array('teams', $types, true)) {
            $payload['teams'] = Team::query()
                ->where(function ($query) use ($q) {
                    $query->where('name', 'like', "%{$q}%")
                        ->orWhere('description', 'like', "%{$q}%");
                })
                ->orderBy('name')
                ->limit($perGroup)
                ->get()
                ->map(fn (Team $t) => [
                    'id' => $t->id,
                    'name' => $t->name,
                    'excerpt' => Str::limit((string) ($t->description ?? ''), 80),
                    'url' => route('teams.show', $t),
                ])
                ->values();
        }

        if (in_array('sprints', $types, true)) {
            $payload['sprints'] = Sprint::query()
                ->with(['board:id,name'])
                ->where(function ($query) use ($q) {
                    $query->where('name', 'like', "%{$q}%")
                        ->orWhere('goal', 'like', "%{$q}%");
                })
                ->latest('id')
                ->limit($perGroup)
                ->get()
                ->map(fn (Sprint $s) => [
                    'id' => $s->id,
                    'name' => $s->name,
                    'board_name' => $s->board->name ?? '',
                    'excerpt' => Str::limit((string) ($s->goal ?? ''), 80),
                    'url' => route('sprints.show', $s),
                ])
                ->values();
        }

        if (in_array('boards', $types, true)) {
            $payload['boards'] = Board::query()
                ->with(['project:id,name,project_key'])
                ->where(function ($query) use ($q) {
                    $query->where('name', 'like', "%{$q}%")
                        ->orWhere('board_type', 'like', "%{$q}%");
                })
                ->orderBy('name')
                ->limit($perGroup)
                ->get()
                ->map(fn (Board $b) => [
                    'id' => $b->id,
                    'name' => $b->name,
                    'board_type' => $b->board_type ?? '',
                    'project_name' => $b->project->name ?? '',
                    'url' => route('boards.show', $b),
                ])
                ->values();
        }

        return response()->json($payload);
    }

    /**
     * @return list<string>
     */
    private function resolveTypes(Request $request): array
    {
        $raw = $request->query('types');
        $types = [];
        if (is_array($raw)) {
            $types = $raw;
        } elseif (is_string($raw) && $raw !== '') {
            $types = array_filter(array_map('trim', explode(',', $raw)));
        }

        $types = array_values(array_unique(array_intersect(
            array_map(static fn ($t) => is_string($t) ? strtolower(trim($t)) : '', $types),
            self::ALLOWED_TYPES
        )));

        if ($types === []) {
            return self::ALLOWED_TYPES;
        }

        return $types;
    }
}
