<?php

namespace App\Imports;

use App\Models\SubPolder;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class SubPolderImport implements ToModel, WithHeadingRow
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        // Skip empty rows
        if (empty($row['nama_lokasi'])) {
            return null;
        }

        $model = new SubPolder([
            'nama_lokasi'     => $row['nama_lokasi'] ?? null,
            'jumlah_unit'     => isset($row['jumlah_unit_kapasitas_pompa']) ? (int) $row['jumlah_unit_kapasitas_pompa'] : null,
            'total_kapasitas' => isset($row['total_kapasitas_m3s']) ? (float) $row['total_kapasitas_m3s'] : null,
            'jenis_pompa'     => $row['jenis_pompa'] ?? null,
            'merk_pompa'      => $row['merk_pompa'] ?? null,
            'alamat'          => $row['alamat'] ?? null,
            'latitude'        => $row['latitude'] ?? null,
            'longitude'       => $row['longitude'] ?? null,
            'photo'           => null
        ]);
        
        // Smart Coordinate Swapping
        $lat = (float) $model->latitude;
        $lng = (float) $model->longitude;
        
        // If latitude is not between -90 and 90, it's likely longitude. Swap them.
        if ($lat != 0 && ($lat < -90 || $lat > 90)) {
            $model->latitude = $lng;
            $model->longitude = $lat;
        }

        return $model;
    }
}
