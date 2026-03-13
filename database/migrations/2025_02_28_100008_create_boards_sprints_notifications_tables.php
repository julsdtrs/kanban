<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('boards', function (Blueprint $table) {
            $table->id();
            $table->foreignId('project_id')->constrained()->cascadeOnDelete();
            $table->string('name', 150)->nullable();
            $table->enum('board_type', ['scrum', 'kanban'])->default('scrum');
            $table->timestamp('created_at')->useCurrent();
        });

        Schema::create('sprints', function (Blueprint $table) {
            $table->id();
            $table->foreignId('board_id')->constrained()->cascadeOnDelete();
            $table->string('name', 150)->nullable();
            $table->text('goal')->nullable();
            $table->date('start_date')->nullable();
            $table->date('end_date')->nullable();
            $table->enum('state', ['planned', 'active', 'closed'])->default('planned');
            $table->timestamp('created_at')->useCurrent();
            $table->index(['board_id', 'state']);
        });

        Schema::create('sprint_issues', function (Blueprint $table) {
            $table->foreignId('sprint_id')->constrained()->cascadeOnDelete();
            $table->foreignId('issue_id')->constrained()->cascadeOnDelete();
            $table->timestamp('added_at')->useCurrent();
            $table->primary(['sprint_id', 'issue_id']);
            $table->index('issue_id');
        });

        Schema::create('notifications', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained();
            $table->foreignId('issue_id')->nullable()->constrained()->nullOnDelete();
            $table->string('type', 100)->nullable();
            $table->string('title', 255)->nullable();
            $table->text('message')->nullable();
            $table->boolean('is_read')->default(false);
            $table->timestamp('created_at')->useCurrent();
            $table->index('user_id');
            $table->index(['user_id', 'is_read']);
            $table->index(['user_id', 'created_at']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('notifications');
        Schema::dropIfExists('sprint_issues');
        Schema::dropIfExists('sprints');
        Schema::dropIfExists('boards');
    }
};
