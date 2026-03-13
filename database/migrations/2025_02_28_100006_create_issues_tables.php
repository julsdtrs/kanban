<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('issues', function (Blueprint $table) {
            $table->id();
            $table->foreignId('project_id')->constrained();
            $table->string('issue_key', 30)->unique();
            $table->foreignId('issue_type_id')->constrained();
            $table->string('summary', 255);
            $table->mediumText('description')->nullable();
            $table->foreignId('priority_id')->nullable()->constrained()->nullOnDelete();
            $table->foreignId('status_id')->nullable()->constrained()->nullOnDelete();
            $table->foreignId('reporter_id')->nullable()->constrained('users')->nullOnDelete();
            $table->foreignId('assignee_id')->nullable()->constrained('users')->nullOnDelete();
            $table->decimal('story_points', 5, 2)->nullable();
            $table->date('due_date')->nullable();
            $table->foreignId('parent_issue_id')->nullable()->constrained('issues')->nullOnDelete();
            $table->timestamps();
            $table->index(['project_id', 'status_id']);
            $table->index(['assignee_id', 'status_id']);
            $table->index('reporter_id');
            $table->index(['project_id', 'priority_id']);
            $table->index('due_date');
            $table->index('parent_issue_id');
            $table->index('created_at');
        });

        Schema::create('issue_labels', function (Blueprint $table) {
            $table->id();
            $table->string('name', 100);
            $table->string('color', 20)->nullable();
        });

        Schema::create('issue_label_map', function (Blueprint $table) {
            $table->foreignId('issue_id')->constrained()->cascadeOnDelete();
            $table->foreignId('label_id')->constrained('issue_labels')->cascadeOnDelete();
            $table->primary(['issue_id', 'label_id']);
            $table->index(['label_id', 'issue_id']);
        });

        Schema::create('issue_watchers', function (Blueprint $table) {
            $table->foreignId('issue_id')->constrained()->cascadeOnDelete();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->primary(['issue_id', 'user_id']);
            $table->index(['user_id', 'issue_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('issue_watchers');
        Schema::dropIfExists('issue_label_map');
        Schema::dropIfExists('issue_labels');
        Schema::dropIfExists('issues');
    }
};
