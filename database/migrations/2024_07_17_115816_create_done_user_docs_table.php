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
        Schema::create('done_user_docs', function (Blueprint $table) {
            $table->id();
            $table->integer('user_id');
            $table->unsignedBigInteger('userdocs_id');
            $table->text('comment');
            $table->string('deadline');
            $table->string('status')->default('waiting');
            $table->string('report');
            $table->string('step')->default('0');
            $table->timestamps();
            $table->softDeletes();
            $table->foreign('userdocs_id')->references('id')->on('user_documents')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('done_user_docs');
    }
};
