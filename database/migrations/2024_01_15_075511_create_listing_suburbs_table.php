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
        Schema::create('listing_suburbs', function (Blueprint $table) {
            $table->id();
            $table->integer("suburb_id");
            $table->string("suburb_fq_slug");
            $table->string("display_suburb_name");
            $table->integer("sdnid");
            $table->string("dynamic_index")->nullable();
            $table->string("suburb_name");
            $table->string("district_name");
            $table->string("region_name");
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('listing_suburbs');
    }
};
