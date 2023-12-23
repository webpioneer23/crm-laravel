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
        Schema::create('properties', function (Blueprint $table) {
            $table->id();
            $table->integer('bedroom')->nullable();
            $table->integer('bathroom')->nullable();
            $table->integer('ensuite')->nullable();
            $table->integer('toilet')->nullable();
            $table->integer('garage')->nullable();
            $table->integer('carport')->nullable();
            $table->integer('open_car')->nullable();
            $table->integer('living')->nullable();
            $table->double('house_size')->nullable();
            $table->string('house_size_unit')->nullable();
            $table->double('land_size')->nullable();
            $table->string('land_size_unit')->nullable();
            $table->double('energy_efficiency_rating')->nullable();
            $table->text('extra')->nullable();
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('properties');
    }
};
