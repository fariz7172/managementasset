<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use App\Models\Kecamatan;
use App\Models\Kelurahan;

class JakartaUtaraSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            'Cilincing' => [
                ['nama_kelurahan' => 'Cilincing', 'kode_pos' => '14120'],
                ['nama_kelurahan' => 'Kalibaru', 'kode_pos' => '14110'],
                ['nama_kelurahan' => 'Marunda', 'kode_pos' => '14150'],
                ['nama_kelurahan' => 'Rorotan', 'kode_pos' => '14140'],
                ['nama_kelurahan' => 'Semper Barat', 'kode_pos' => '14130'],
                ['nama_kelurahan' => 'Semper Timur', 'kode_pos' => '14130'],
                ['nama_kelurahan' => 'Sukapura', 'kode_pos' => '14140'],
            ],
            'Koja' => [
                ['nama_kelurahan' => 'Koja', 'kode_pos' => '14220'],
                ['nama_kelurahan' => 'Lagoa', 'kode_pos' => '14270'],
                ['nama_kelurahan' => 'Rawa Badak Selatan', 'kode_pos' => '14230'],
                ['nama_kelurahan' => 'Rawa Badak Utara', 'kode_pos' => '14230'],
                ['nama_kelurahan' => 'Tugu Selatan', 'kode_pos' => '14260'],
                ['nama_kelurahan' => 'Tugu Utara', 'kode_pos' => '14260'],
            ],
            'Kelapa Gading' => [
                ['nama_kelurahan' => 'Kelapa Gading Barat', 'kode_pos' => '14240'],
                ['nama_kelurahan' => 'Kelapa Gading Timur', 'kode_pos' => '14240'],
                ['nama_kelurahan' => 'Pegangsaan Dua', 'kode_pos' => '14250'],
            ],
            'Tanjung Priok' => [
                ['nama_kelurahan' => 'Kebon Bawang', 'kode_pos' => '14320'],
                ['nama_kelurahan' => 'Papanggo', 'kode_pos' => '14340'],
                ['nama_kelurahan' => 'Sungai Bambu', 'kode_pos' => '14330'],
                ['nama_kelurahan' => 'Sunter Agung', 'kode_pos' => '14350'],
                ['nama_kelurahan' => 'Sunter Jaya', 'kode_pos' => '14360'],
                ['nama_kelurahan' => 'Tanjung Priok', 'kode_pos' => '14310'],
                ['nama_kelurahan' => 'Warakas', 'kode_pos' => '14370'],
            ],
            'Pademangan' => [
                ['nama_kelurahan' => 'Ancol', 'kode_pos' => '14430'],
                ['nama_kelurahan' => 'Pademangan Barat', 'kode_pos' => '14420'],
                ['nama_kelurahan' => 'Pademangan Timur', 'kode_pos' => '14410'],
            ],
            'Penjaringan' => [
                ['nama_kelurahan' => 'Kamal Muara', 'kode_pos' => '14470'],
                ['nama_kelurahan' => 'Kapuk Muara', 'kode_pos' => '14460'],
                ['nama_kelurahan' => 'Pejagalan', 'kode_pos' => '14450'],
                ['nama_kelurahan' => 'Penjaringan', 'kode_pos' => '14440'],
                ['nama_kelurahan' => 'Pluit', 'kode_pos' => '14450'],
            ],
        ];

        foreach ($data as $kecamatanName => $kelurahans) {
            $kecamatan = Kecamatan::firstOrCreate(['nama_kecamatan' => $kecamatanName]);

            foreach ($kelurahans as $kel) {
                Kelurahan::firstOrCreate([
                    'kecamatan_id' => $kecamatan->id,
                    'nama_kelurahan' => $kel['nama_kelurahan']
                ], [
                    'kode_pos' => $kel['kode_pos']
                ]);
            }
        }
    }
}
