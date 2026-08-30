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
        Schema::create('pendataan_sensuses', function (Blueprint $table) {
            $table->id();
                        $table->text('kategori_pencatatan')->nullable();
            $table->text('status_pelaksanaan')->nullable();
            $table->text('tahap_data')->nullable();
            $table->text('kode_kib_rekon')->nullable();
            $table->text('kib_rekon')->nullable();
            $table->text('qr_code')->nullable();
            $table->text('guid_id')->nullable();
            $table->text('guid_sensus')->nullable();
            $table->text('kode_barang')->nullable();
            $table->text('nama_barang')->nullable();
            $table->text('nomor_register')->nullable();
            $table->date('tanggal_perolehan')->nullable();
            $table->decimal('harga', 20, 2)->nullable();
            $table->text('kolok_skpd')->nullable();
            $table->text('nalok_skpd')->nullable();
            $table->text('kolok_ukpd')->nullable();
            $table->text('nalok_ukpd')->nullable();
            $table->text('kolok_kolok_upb')->nullable();
            $table->text('nalok_nalok_upb')->nullable();
            $table->text('kolok_bkd')->nullable();
            $table->text('nalok_bkd')->nullable();
            $table->text('objek')->nullable();
            $table->text('nama_objek')->nullable();
            $table->text('sub_rincian_objek')->nullable();
            $table->text('nama_sub_rincian_objek')->nullable();
            $table->text('kode_bahan')->nullable();
            $table->text('bahan')->nullable();
            $table->text('kode_kondisi')->nullable();
            $table->text('kondisi')->nullable();
            $table->decimal('panjang', 20, 2)->nullable();
            $table->decimal('lebar', 20, 2)->nullable();
            $table->text('ukuran')->nullable();
            $table->text('satuan')->nullable();
            $table->decimal('luas_fisik', 20, 2)->nullable();
            $table->decimal('luas_bebas', 20, 2)->nullable();
            $table->text('nama_jalan_alamat')->nullable();
            $table->text('nomor_jalan')->nullable();
            $table->text('rt')->nullable();
            $table->text('rw')->nullable();
            $table->text('kode_kelurahan')->nullable();
            $table->text('kelurahan')->nullable();
            $table->text('kecamatan')->nullable();
            $table->text('kode_pos')->nullable();
            $table->text('latitude')->nullable();
            $table->text('longitude')->nullable();
            $table->text('merk')->nullable();
            $table->text('tipe')->nullable();
            $table->text('asal_daerah')->nullable();
            $table->text('kdasal_oleh')->nullable();
            $table->text('kd_subasal_oleh')->nullable();
            $table->text('asal_oleh')->nullable();
            $table->text('keterangan_asal_oleh')->nullable();
            $table->text('penggunaan')->nullable();
            $table->text('ket_masalah')->nullable();
            $table->date('tanggal_dokumen')->nullable();
            $table->text('nomor_dokumen')->nullable();
            $table->text('komponen')->nullable();
            $table->text('masa_manfaat')->nullable();
            $table->text('dokumen_tanah')->nullable();
            $table->text('bangunan')->nullable();
            $table->text('kolok_tanah')->nullable();
            $table->text('kode_barang_tanah')->nullable();
            $table->text('nomor_register_tanah')->nullable();
            $table->decimal('luas_tanah', 20, 2)->nullable();
            $table->text('status_tanah')->nullable();
            $table->text('status_bangunan')->nullable();
            $table->text('pengembang')->nullable();
            $table->text('kolok_upb')->nullable();
            $table->text('kode_fisik_pendataan')->nullable();
            $table->text('fisik_pendataan')->nullable();
            $table->text('kode_sebab_tidak_ditemukan')->nullable();
            $table->text('sebab_tidak_ditemukan')->nullable();
            $table->text('kronologis')->nullable();
            $table->text('kode_dokumen_pendukung')->nullable();
            $table->text('dokumen_pendukung')->nullable();
            $table->text('dokumen_pendukung_berupa')->nullable();
            $table->text('kode_kib_pendataan')->nullable();
            $table->text('kib_pendataan')->nullable();
            $table->text('kode_kesesuaian_kode_barang')->nullable();
            $table->text('kesesuaian_kode_barang')->nullable();
            $table->text('kode_barang_seharusnya')->nullable();
            $table->text('nama_barang_seharusnya')->nullable();
            $table->text('kode_kondisi_fisik_bmd')->nullable();
            $table->text('kondisi_fisik_bmd')->nullable();
            $table->text('keterangan_kondisi_fisik')->nullable();
            $table->text('pemetaan_geospasial')->nullable();
            $table->text('kode_status_inventarisasi_mobile')->nullable();
            $table->text('status_inventarisasi_mobile')->nullable();
            $table->text('alamat_pendataan')->nullable();
            $table->text('kode_pengguna_bmd')->nullable();
            $table->text('pengguna_bmd')->nullable();
            $table->text('kolok_pengguna_bmd')->nullable();
            $table->text('instansi_pengguna_bmd')->nullable();
            $table->text('keterangan_pendataan')->nullable();
            $table->text('kode_indikasi_gabungan')->nullable();
            $table->text('indikasi_gabungan')->nullable();
            $table->text('kolok_induk_gabungan')->nullable();
            $table->text('kode_kib_induk_gabungan')->nullable();
            $table->text('kib_induk_gabungan')->nullable();
            $table->text('pendataan_kode_barang_induk_gabungan')->nullable();
            $table->text('nama_barang_induk_gabungan')->nullable();
            $table->text('pendataan_nomor_register_induk_gabungan')->nullable();
            $table->text('guid_aset_induk_gabungan')->nullable();
            $table->decimal('pendataan_total_harga_induk_gabungan', 20, 2)->nullable();
            $table->text('kode_indikasi_ganda')->nullable();
            $table->text('indikasi_ganda')->nullable();
            $table->text('kode_ganda_dengan')->nullable();
            $table->text('ganda_dengan')->nullable();
            $table->text('kolok_induk_ganda')->nullable();
            $table->text('kode_kib_induk_ganda')->nullable();
            $table->text('kib_induk_ganda')->nullable();
            $table->text('kode_barang_induk_ganda')->nullable();
            $table->text('nomor_register_induk_ganda')->nullable();
            $table->text('guid_aset_induk_ganda')->nullable();
            $table->decimal('harga_induk_ganda', 20, 2)->nullable();
            $table->text('instansi_induk_ganda')->nullable();
            $table->text('url_foto_awal')->nullable();
            $table->text('latitude_foto_awal')->nullable();
            $table->text('longitude_foto_awal')->nullable();
            $table->text('alamat_foto_awal')->nullable();
            $table->text('url_foto_akhir')->nullable();
            $table->text('latitude_foto_akhir')->nullable();
            $table->text('longitude_foto_akhir')->nullable();
            $table->text('alamat_foto_akhir')->nullable();
            $table->text('url_foto_pendataan')->nullable();
            $table->text('titik_koordinat_hasil_sensus_latitude')->nullable();
            $table->text('titik_koordinat_hasil_sensus_longitude')->nullable();
            $table->text('alamat_foto_pendataan')->nullable();
            $table->text('kode_kesesuaian_jalan')->nullable();
            $table->text('kesesuaian_jalan')->nullable();
            $table->text('nama_jalan_seharusnya')->nullable();
            $table->text('kode_kesesuaian_perkerasan_jalan')->nullable();
            $table->text('kesesuaian_perkerasan_jalan')->nullable();
            $table->text('kode_perkerasan_jalan_seharusnya')->nullable();
            $table->text('perkerasan_jalan')->nullable();
            $table->text('kode_jalan_di_atas_tanah_milik_hasil_sensus')->nullable();
            $table->text('jalan_di_atas_tanah_milik_hasil_sensus')->nullable();
            $table->text('rincian_jalan_di_atas_tanah_milik_hasil_sensus_kolok')->nullable();
            $table->text('rincian_jalan_di_atas_tanah_milik_hasil_sensus_instansi')->nullable();
            $table->text('jenis_objek_kib_d')->nullable();
            $table->date('dibuat_diperbaharui_pada')->nullable();
            $table->text('dibuat_diperbaharui_oleh')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pendataan_sensuses');
    }
};
