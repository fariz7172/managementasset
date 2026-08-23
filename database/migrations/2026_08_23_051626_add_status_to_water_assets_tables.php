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
        Schema::table('sub_polders', function (Blueprint $table) {
            $table->tinyInteger('status')->default(1)->comment('1 = Aktif, 0 = Perbaikan');
        });
        
        Schema::table('pompa_mobiles', function (Blueprint $table) {
            $table->tinyInteger('status')->default(1)->comment('1 = Aktif, 0 = Perbaikan');
        });
        
        Schema::table('pintu_airs', function (Blueprint $table) {
            $table->tinyInteger('status')->default(1)->comment('1 = Aktif, 0 = Perbaikan');
        });
        
        // Note: 'pompas' already has a 'status' column (string), so we don't add it here.
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('sub_polders', function (Blueprint $table) {
            $table->dropColumn('status');
        });
        
        Schema::table('pompa_mobiles', function (Blueprint $table) {
            $table->dropColumn('status');
        });
        
        Schema::table('pintu_airs', function (Blueprint $table) {
            $table->dropColumn('status');
        });
    }
};
