<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('workflow_transitions', function (Blueprint $table) {
            $table->unsignedInteger('order')->default(0)->after('transition_name');
        });
        $rows = DB::table('workflow_transitions')->orderBy('id')->get();
        foreach ($rows as $i => $row) {
            DB::table('workflow_transitions')->where('id', $row->id)->update(['order' => $i]);
        }
    }

    public function down(): void
    {
        Schema::table('workflow_transitions', function (Blueprint $table) {
            $table->dropColumn('order');
        });
    }
};
