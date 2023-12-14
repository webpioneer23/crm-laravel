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
        Schema::table('contacts', function (Blueprint $table) {
            $table->text('listing_types')->nullable();
            $table->double('land_size_min')->nullable();
            $table->double('land_size_max')->nullable();
            $table->string('land_size_unit')->nullable();
            $table->double('floor_size_min')->nullable();
            $table->double('floor_size_max')->nullable();
            $table->string('floor_size_unit')->nullable();
            $table->double('car_spaces_min')->nullable();
            $table->double('car_spaces_max')->nullable();
            $table->string('suburbs')->nullable();
            $table->text('comments')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('contacts', function (Blueprint $table) {
            $table->dropColumn('listing_types');
            $table->dropColumn('land_size_min');
            $table->dropColumn('land_size_max');
            $table->dropColumn('land_size_unit');
            $table->dropColumn('floor_size_min');
            $table->dropColumn('floor_size_max');
            $table->dropColumn('floor_size_unit');
            $table->dropColumn('car_spaces_min');
            $table->dropColumn('car_spaces_max');
            $table->dropColumn('suburbs');
            $table->dropColumn('comments');
        });
    }
};
