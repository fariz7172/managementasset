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
        Schema::create('pintu_airs', function (Blueprint $table) {
            $table->id();
            $table->string('alamat')->nullable();
            $table->string('nama')->nullable();
            $table->string('google_map')->nullable();
            $table->string('koordinat')->nullable();
            $table->string('tahun_pekerjaan')->nullable();
            $table->string('kelurahan')->nullable();
            $table->string('kecamatan')->nullable();
            $table->integer('jumlah_pintu')->nullable();
            $table->text('keterangan')->nullable();
            $table->string('kib_d')->nullable();
            $table->string('latitude')->nullable();
            $table->string('longitude')->nullable();
            $table->json('photo')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pintu_airs');
    }
};
