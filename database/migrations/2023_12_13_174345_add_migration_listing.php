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
            $table->integer('bedrooms')->nullable();
            $table->integer('bathrooms')->nullable();
            $table->integer('ensuites')->nullable();
            $table->integer('toilets')->nullable();
            $table->integer('garage_spaces')->nullable();
            $table->integer('carport_spaces')->nullable();
            $table->integer('open_car_spaces')->nullable();
            $table->integer('living_areas')->nullable();
            $table->double('house_size')->nullable();
            $table->string('house_size_unit')->nullable();
            $table->double('land_size')->nullable();
            $table->string('land_size_unit')->nullable();
            $table->double('energy_efficiency_rating')->nullable();
            $table->string('agency_reference')->nullable();
            $table->string('sms_code')->nullable();
            $table->string('document_delivery_cma')->nullable();
            $table->string('document_delivery_method_cma')->nullable();
            $table->string('inhouse_complaints_guide')->nullable();
            $table->string('deed_assignment_requested')->nullable();
            $table->string('floor_area_verified')->nullable();
            $table->string('ax_listing_check_admin')->nullable();
            $table->string('ax_listing_check_mitch')->nullable();
            $table->text('outdoor_features')->nullable();
            $table->text('indoor_features')->nullable();
            $table->text('heating_cooling')->nullable();
            $table->text('eco_friendly_features')->nullable();
            $table->text('other_features')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('listings', function (Blueprint $table) {
            $table->dropColumn('bedrooms');
            $table->dropColumn('bathrooms');
            $table->dropColumn('ensuites');
            $table->dropColumn('toilets');
            $table->dropColumn('garage_spaces');
            $table->dropColumn('carport_spaces');
            $table->dropColumn('open_car_spaces');
            $table->dropColumn('living_areas');
            $table->dropColumn('house_size');
            $table->dropColumn('house_size_unit');
            $table->dropColumn('land_size');
            $table->dropColumn('land_size_unit');
            $table->dropColumn('energy_efficiency_rating');
            $table->dropColumn('agency_reference');
            $table->dropColumn('sms_code');
            $table->dropColumn('document_delivery_cma');
            $table->dropColumn('document_delivery_method_cma');
            $table->dropColumn('inhouse_complaints_guide');
            $table->dropColumn('deed_assignment_requested');
            $table->dropColumn('floor_area_verified');
            $table->dropColumn('ax_listing_check_admin');
            $table->dropColumn('ax_listing_check_mitch');
            $table->dropColumn('outdoor_features');
            $table->dropColumn('indoor_features');
            $table->dropColumn('heating_cooling');
            $table->dropColumn('eco_friendly_features');
            $table->dropColumn('other_features');
        });
    }
};
