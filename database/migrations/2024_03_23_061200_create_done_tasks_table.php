<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('done_tasks', function (Blueprint $table) {
            $table->id();
            $table->integer('user_id');
            $table->unsignedBigInteger('task_id');
            $table->text('comment');
            $table->string('deadline');
            $table->string('status')->default('waiting');
            $table->string('report');
            $table->string('step')->default('0');
            $table->timestamps();
            $table->softDeletes();
            $table->foreign('task_id')->references('id')->on('send_tasks')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('done_tasks');
    }
};
