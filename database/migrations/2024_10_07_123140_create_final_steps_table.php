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
        Schema::create('final_steps', function (Blueprint $table) {
            $table->integer('user_id');
            $table->integer('department_id');
            $table->string('file');
            $table->string('name');
            $table->integer('userdocs_id');
            $table->integer('doctype_id');
            $table->longText('comment');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('final_steps');
    }
};
