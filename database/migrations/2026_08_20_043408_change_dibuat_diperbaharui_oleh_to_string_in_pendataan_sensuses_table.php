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
        Schema::table('pendataan_sensuses', function (Blueprint $table) {
            $table->string('dibuat_diperbaharui_oleh')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('pendataan_sensuses', function (Blueprint $table) {
            //
        });
    }
};
