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
        Schema::create('documenttypes_has_deparments', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('documenttype_id');
            $table->unsignedBigInteger('department_id');
            $table->string('order')->default('off');
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('documenttype_id')->references('id')->on('documenttypes')->onDelete('cascade');
            $table->foreign('department_id')->references('id')->on('departments')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('documents_has_deparments');
    }
};
