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
        Schema::table('a_files', function (Blueprint $table) {
            $table->string("file_name")->nullable();
            $table->string("file_ext")->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('a_files', function (Blueprint $table) {
            $table->dropColumn('file_name');
            $table->dropColumn('file_ext');
        });
    }
};
