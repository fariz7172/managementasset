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
        Schema::create('pompa_mobiles', function (Blueprint $table) {
            $table->id();
            $table->string('lokasi')->nullable();
            $table->string('jenis_type')->nullable();
            $table->string('no_seri_plat')->nullable();
            $table->string('merk')->nullable();
            $table->string('kapasitas')->nullable();
            $table->string('tahun_pembuatan')->nullable();
            $table->string('kewenangan')->nullable();
            $table->integer('total')->nullable();
            $table->integer('baik')->nullable();
            $table->integer('rusak')->nullable();
            $table->string('longitude')->nullable();
            $table->string('latitude')->nullable();
            $table->text('keterangan')->nullable();
            $table->json('photo')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pompa_mobiles');
    }
};
