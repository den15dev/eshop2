<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('skus', function (Blueprint $table) {
            $table->unsignedBigInteger('code')->nullable()->unique()->after('slug');
        });

        DB::statement('UPDATE skus SET code = id;');

        Schema::table('skus', function (Blueprint $table) {
            $table->unsignedBigInteger('code')->nullable(false)->change();
        });
    }


    public function down(): void
    {
        Schema::table('skus', function (Blueprint $table) {
            $table->dropUnique(['code']);
            $table->dropColumn('code');
        });
    }
};
