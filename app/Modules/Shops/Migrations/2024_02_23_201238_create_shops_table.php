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
        Schema::create('shops', function (Blueprint $table) {
            $table->id();
            $table->jsonb('name');
            $table->jsonb('address');
            $table->jsonb('location');
            $table->jsonb('opening_hours');
            $table->jsonb('info')->nullable();
            $table->jsonb('images')->nullable();
            $table->unsignedInteger('sort');
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('shops');
    }
};
