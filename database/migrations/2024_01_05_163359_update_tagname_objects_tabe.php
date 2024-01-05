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
        Schema::table('tagname_objects', function (Blueprint $table) {
            $table->text('tag_name')->change();
            $table->string('tag_date')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('tagname_objects', function (Blueprint $table) {
            $table->string('tag_name')->change();
            $table->dropColumn('tag_date');
        });
    }
};
