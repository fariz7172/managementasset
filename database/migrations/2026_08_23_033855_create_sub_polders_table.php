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
        Schema::create('sub_polders', function (Blueprint $table) {
            $table->id();
            $table->string('nama_lokasi')->nullable();
            $table->integer('jumlah_unit')->nullable();
            $table->decimal('total_kapasitas', 8, 2)->nullable();
            $table->string('jenis_pompa')->nullable();
            $table->string('merk_pompa')->nullable();
            $table->text('alamat')->nullable();
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
        Schema::dropIfExists('sub_polders');
    }
};
