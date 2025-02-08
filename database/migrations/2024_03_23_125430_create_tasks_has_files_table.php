<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('tasks_has_files', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('task_id')->nullable();
            $table->unsignedBigInteger('done_id')->nullable();
            $table->string('name');
            $table->string('status')->default('waiting');
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('task_id')->references('id')->on('send_tasks')->onDelete('cascade');
            $table->foreign('done_id')->references('id')->on('done_tasks')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tasks_has_files');
    }
};
