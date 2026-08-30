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
        Schema::create('api_payments', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('api_id')->unique();
            $table->string('no_spd')->nullable();
            $table->string('kode_rek')->nullable();
            $table->string('no_spp')->nullable();
            $table->string('no_spm')->nullable();
            $table->string('no_bast')->nullable();
            $table->bigInteger('jumlah')->nullable();
            $table->string('terbilang')->nullable();
            $table->text('keperluan')->nullable();
            $table->bigInteger('denda')->nullable();
            $table->string('vendor_nama')->nullable();
            $table->string('vendor_npwp')->nullable();
            $table->string('contract_nomor')->nullable();
            $table->date('contract_tgl')->nullable();
            $table->json('raw_data')->nullable(); // Store the full original object
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('api_payments');
    }
};
