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
        Schema::create('listings', function (Blueprint $table) {
            $table->id();

            $table->integer('step')->default(1);
            $table->string('status')->default('Draft');
            $table->boolean('featured_property')->default(false);
            $table->string('property_type')->default('Apartment');
            $table->string('established_development')->default('Established Building');
            $table->string('home_package')->default('No');
            $table->string('authority')->default('Auction');
            $table->string('office')->default('Lab Realty');
            $table->string('expiry_date')->nullable();
            $table->string('price_type')->default('No');
            $table->string('tender_deadline_date')->nullable();
            $table->double('price')->default(0);
            $table->string('display_price')->default('No');
            $table->string('display')->default('No');
            $table->string('key_number')->nullable();
            $table->string('key_location')->nullable();
            $table->string('alarm_code')->nullable();
            $table->string('internal_notes')->nullable();
            $table->string('rent_appraisal')->nullable();
            $table->string('display_price_text')->nullable();

            $table->unsignedBigInteger('address_id');
            $table->foreign('address_id')->references('id')->on('addresses')->onDelete('cascade');

            $table->unsignedBigInteger('contact_id');
            $table->foreign('contact_id')->references('id')->on('contacts')->onDelete('cascade');

            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('listings');
    }
};
