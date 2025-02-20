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
        Schema::create('userdocs_has_files', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('documenttype_id')->nullable();
            $table->unsignedBigInteger('userdocs_id')->nullable();
            $table->string('name');
            $table->string('status')->default('waiting');
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('userdocs_id')->references('id')->on('user_documents')->onDelete('cascade');
            $table->foreign('documenttype_id')->references('id')->on('documenttypes')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('userdocs_has_files');
    }
};
