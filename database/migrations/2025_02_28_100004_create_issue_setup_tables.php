<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('issue_types', function (Blueprint $table) {
            $table->id();
            $table->string('name', 50);
            $table->string('icon', 100)->nullable();
            $table->string('color', 20)->nullable();
        });

        Schema::create('priorities', function (Blueprint $table) {
            $table->id();
            $table->string('name', 50);
            $table->integer('level')->default(0);
            $table->string('color', 20)->nullable();
        });

        Schema::create('statuses', function (Blueprint $table) {
            $table->id();
            $table->string('name', 50);
            $table->enum('category', ['todo', 'in_progress', 'done'])->default('todo');
            $table->string('color', 20)->nullable();
            $table->integer('order_no')->default(0);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('statuses');
        Schema::dropIfExists('priorities');
        Schema::dropIfExists('issue_types');
    }
};
