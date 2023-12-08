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
        Schema::create('complexes', function (Blueprint $table) {
            $table->id();
            $table->text('street_address');
            $table->string('name');
            $table->string('year_built')->nullable();
            $table->string('architect')->nullable();
            $table->string('constructor')->nullable();
            $table->integer('number_units')->nullable();
            $table->integer('number_floors')->nullable();
            $table->string('property_type')->nullable();
            $table->string('body_manager')->nullable();
            $table->text('note')->nullable();
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('complexes');
    }
};
