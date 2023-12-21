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
        Schema::table('appraisals', function (Blueprint $table) {
            $table->unsignedBigInteger('contact_id')->nullable();
            $table->foreign('contact_id')->references('id')->on('contacts')->onDelete('cascade');

            $table->unsignedBigInteger('address_id')->nullable();
            $table->foreign('address_id')->references('id')->on('addresses')->onDelete('cascade');

            $table->double('price_min')->nullable();
            $table->double('price_max')->nullable();
            $table->double('appraisal_value')->nullable();
            $table->string('due_date')->nullable();
            $table->string('status')->nullable();
            $table->string('delivered_date')->nullable();
            $table->string('delivery_type')->nullable();
            $table->text('reason_lost')->nullable();
            $table->string('interest')->nullable();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('appraisals', function (Blueprint $table) {
            $table->dropForeign('appraisals_contact_id_foreign');
            $table->dropForeign('appraisals_address_id_foreign');
            $table->dropColumn('contact_id');
            $table->dropColumn('address_id');
            $table->dropColumn('price_min');
            $table->dropColumn('price_max');
            $table->dropColumn('appraisal_value');
            $table->dropColumn('due_date');
            $table->dropColumn('status');
            $table->dropColumn('delivered_date');
            $table->dropColumn('delivery_type');
            $table->dropColumn('reason_lost');
            $table->dropColumn('interest');
            $table->dropColumn('deleted_at');
        });
    }
};
