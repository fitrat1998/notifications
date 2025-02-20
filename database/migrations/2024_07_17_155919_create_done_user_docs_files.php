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
        Schema::create('done_user_docs_files', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_docs')->nullable();
            $table->unsignedBigInteger('done_user_docs_id')->nullable();
            $table->string('name');
            $table->string('status')->default('waiting');
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('user_docs')->references('id')->on('user_documents')->onDelete('cascade');
            $table->foreign('done_user_docs_id')->references('id')->on('done_user_docs')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('done_user_docs_files');
    }
};
