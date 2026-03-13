<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('workflows', function (Blueprint $table) {
            $table->foreignId('board_id')->nullable()->after('project_id')->constrained()->nullOnDelete();
        });

        // Backfill: set board_id from first board that has this workflow's project
        $workflows = DB::table('workflows')->get();
        foreach ($workflows as $w) {
            $boardId = DB::table('boards')->where('project_id', $w->project_id)->value('id');
            if ($boardId) {
                DB::table('workflows')->where('id', $w->id)->update(['board_id' => $boardId]);
            }
        }
    }

    public function down(): void
    {
        Schema::table('workflows', function (Blueprint $table) {
            $table->dropForeign(['board_id']);
        });
    }
};
