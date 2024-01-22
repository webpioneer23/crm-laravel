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
        Schema::table('listings', function (Blueprint $table) {
            $table->string('category_code');
            $table->boolean('is_new_construction')->default(false);
            $table->boolean('is_coastal_waterfront')->default(false);
            $table->boolean('has_swimming_pool')->default(false);
            $table->integer('year_built')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('listings', function (Blueprint $table) {
            $table->dropColumn('category_code');
            $table->dropColumn('is_new_construction');
            $table->dropColumn('is_coastal_waterfront');
            $table->dropColumn('has_swimming_pool');
            $table->dropColumn('year_built');
        });
    }
};
