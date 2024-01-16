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
        Schema::create('listing_portals', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->text('base_url')->nullable();
            $table->string('key')->nullable();
            $table->string('office_id')->nullable();
            $table->text('other')->nullable();
            $table->boolean('active')->default(true);
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('listing_portals');
    }
};
