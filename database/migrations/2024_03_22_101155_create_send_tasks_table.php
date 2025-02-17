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
        Schema::create('send_tasks', function (Blueprint $table) {
            $table->id();
            $table->integer('user_id');
            $table->string('title');

            $table->text('comment');
            $table->string('deadline');
            $table->string('status')->default('waiting');
            $table->string('step')->default('admin');
            $table->timestamps();
            $table->softDeletes();

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('send_tasks');
    }
};
