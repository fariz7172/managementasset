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
        Schema::create('assets', function (Blueprint $table) {
            $table->id();
            $table->string('api_payment_id')->nullable();
            $table->foreignId('dewan_id')->nullable()->constrained('dewans')->onDelete('set null');
            $table->foreignId('kecamatan_id')->nullable()->constrained('kecamatans')->onDelete('set null');
            $table->foreignId('kelurahan_id')->nullable()->constrained('kelurahans')->onDelete('set null');
            $table->text('lokasi')->nullable();
            $table->string('latitude')->nullable();
            $table->string('longtitude')->nullable();
            $table->text('permintaan')->nullable();
            $table->date('tanggal_reses')->nullable();
            $table->string('status')->nullable();
            $table->decimal('lebar', 10, 2)->nullable();
            $table->decimal('tinggi', 10, 2)->nullable();
            $table->decimal('panjang', 10, 2)->nullable();
            $table->decimal('volume', 10, 2)->nullable();
            $table->decimal('biaya', 15, 2)->nullable();
            $table->text('keterangan')->nullable();
            $table->string('foto')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('assets');
    }
};
