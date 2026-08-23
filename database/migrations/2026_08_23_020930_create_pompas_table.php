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
        Schema::create('pompas', function (Blueprint $table) {
            $table->id();
            $table->string('nama')->nullable();
            $table->string('merk')->nullable();
            $table->integer('jumlah')->nullable();
            $table->string('jenis_pompa')->nullable();
            $table->string('merk_pompa')->nullable();
            $table->string('tahun')->nullable();
            $table->text('alamat')->nullable();
            $table->string('titik_koordinat')->nullable();
            $table->string('status')->nullable();
            $table->string('longitude')->nullable();
            $table->string('latitude')->nullable();
            $table->string('photo')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pompas');
    }
};
