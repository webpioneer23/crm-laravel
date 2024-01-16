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
        Schema::table('listing_portal_maps', function (Blueprint $table) {
            $table->string('push_id')->nullable();
            $table->text('note')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('listing_portal_maps', function (Blueprint $table) {
            $table->dropColumn('push_id');
            $table->dropColumn('note');
        });
    }
};
