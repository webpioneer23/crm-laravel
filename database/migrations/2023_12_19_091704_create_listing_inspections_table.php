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
        Schema::create('listing_inspections', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('listing_id');
            $table->foreign('listing_id')->references('id')->on('listings')->onDelete('cascade');

            $table->string('inspection_date')->nullable();
            $table->string('start_time')->nullable();
            $table->string('end_time')->nullable();
            $table->string('inspection_type')->nullable();
            $table->string('inspection_booking_setting')->nullable();

            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('listing_inspections');
    }
};
