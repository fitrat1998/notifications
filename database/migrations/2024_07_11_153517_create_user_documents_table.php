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
        Schema::create('user_documents', function (Blueprint $table) {
            $table->id();
            $table->integer('user_id');
            $table->unsignedBigInteger('userdocument_id');
            $table->text('comment');
            $table->string('deadline');
            $table->string('status')->default('waiting');
            $table->string('report');
            $table->string('cancelled_user')->default('0');
            $table->timestamps();
            $table->softDeletes();
            $table->foreign('userdocument_id')->references('id')->on('documenttypes')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_documents');
    }
};
