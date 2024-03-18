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
        Schema::create('currencies', function (Blueprint $table) {
            $table->string('id')->unique();
            $table->jsonb('name');
            $table->string('symbol');
            $table->boolean('symbol_precedes');
            $table->string('thousands_sep')->nullable();
            $table->string('decimal_sep');
            $table->string('language_id')->nullable();
            $table->foreign('language_id')->references('id')->on('languages')->onUpdate('cascade')->onDelete('set null');
            $table->decimal('exchange_rate', 21, 8)->comment('All rates must be relative to one currency. That is, one of the rates must be equal 1.');
            $table->string('source')->default('manual')->comment('Exchange rate source');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('currencies');
    }
};
