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
        Schema::table('contacts', function (Blueprint $table) {
            $table->unsignedBigInteger('residing_address')->nullable();
            $table->foreign('residing_address')->references('id')->on('addresses')->onDelete('cascade');

            $table->text('social_links')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('contacts', function (Blueprint $table) {
            $table->dropForeign('contacts_residing_address_foreign');

            $table->dropColumn('residing_address');
            $table->dropColumn('social_links');
        });
    }
};
