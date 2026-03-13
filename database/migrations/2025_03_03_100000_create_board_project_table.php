<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('board_project', function (Blueprint $table) {
            $table->foreignId('board_id')->constrained()->cascadeOnDelete();
            $table->foreignId('project_id')->constrained()->cascadeOnDelete();
            $table->primary(['board_id', 'project_id']);
        });

        // Seed pivot from existing boards.project_id
        $boards = DB::table('boards')->get();
        foreach ($boards as $board) {
            DB::table('board_project')->insertOrIgnore([
                'board_id' => $board->id,
                'project_id' => $board->project_id,
            ]);
        }
    }

    public function down(): void
    {
        Schema::dropIfExists('board_project');
    }
};
