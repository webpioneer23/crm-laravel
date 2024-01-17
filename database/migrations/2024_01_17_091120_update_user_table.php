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
        Schema::table('users', function (Blueprint $table) {
            $table->string('licence_number')->nullable();
            $table->string('licence_class')->nullable();
            $table->string('expiry_date')->nullable();
            $table->text('photo')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('licence_number');
            $table->dropColumn('licence_class');
            $table->dropColumn('expiry_date');
            $table->dropColumn('photo');
        });
    }
};
