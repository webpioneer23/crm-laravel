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
            $table->text('headline')->nullable();
            $table->text('description')->nullable();
            $table->string('video_url')->nullable();
            $table->string('online_tour1')->nullable();
            $table->string('online_tour2')->nullable();
            $table->string('third_party_link')->nullable();

            $table->string('inspection_date')->nullable();
            $table->string('start_time')->nullable();
            $table->string('end_time')->nullable();
            $table->string('inspection_type')->nullable();
            $table->string('inspection_booking_setting')->nullable();

            $table->integer('inspection_user')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('listings', function (Blueprint $table) {
            $table->dropColumn('headline');
            $table->dropColumn('description');
            $table->dropColumn('video_url');
            $table->dropColumn('online_tour1');
            $table->dropColumn('online_tour2');
            $table->dropColumn('third_party_link');
            $table->dropColumn('inspection_date');
            $table->dropColumn('start_time');
            $table->dropColumn('end_time');
            $table->dropColumn('inspection_type');
            $table->dropColumn('inspection_user');
            $table->dropColumn('inspection_booking_setting');
        });
    }
};
