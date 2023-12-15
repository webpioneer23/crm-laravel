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
        Schema::create('contracts', function (Blueprint $table) {
            $table->id();
            $table->string('purchaser_name')->nullable();
            $table->string('vendor_name')->nullable();
            $table->string('contract_accepted_date')->nullable();
            $table->string('unconditional_date')->nullable();
            $table->string('settlement_date')->nullable();
            $table->string('deposit_due_date')->nullable();
            $table->string('deposit_received_date')->nullable();
            $table->string('commission')->nullable();
            $table->text('comment')->nullable();

            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('contracts');
    }
};
