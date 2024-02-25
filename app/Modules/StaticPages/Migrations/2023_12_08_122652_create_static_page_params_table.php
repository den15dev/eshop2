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
        Schema::create('static_page_params', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->unsignedBigInteger('static_page_id')->nullable();
            $table->foreign('static_page_id')->references('id')->on('static_pages')->onUpdate('cascade')->onDelete('cascade');
            $table->jsonb('val')->nullable();
            $table->jsonb('description')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('static_page_params');
    }
};
