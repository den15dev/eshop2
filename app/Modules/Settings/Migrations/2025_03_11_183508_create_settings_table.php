<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('settings', function (Blueprint $table) {
            $table->string('id')->unique();
            $table->jsonb('name');
            $table->string('val');
            $table->string('data_type')->default('string')->comment('One of "string", "integer", "boolean", or "array"');
            $table->jsonb('data_set')->nullable()->comment('If provided, only this set of values will be suggested during editing');
            $table->jsonb('description')->nullable();
            $table->timestamps();
        });
    }


    public function down(): void
    {
        Schema::dropIfExists('settings');
    }
};
