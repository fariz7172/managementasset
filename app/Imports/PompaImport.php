<?php

namespace App\Imports;

use App\Models\Pompa;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class PompaImport implements ToModel, WithHeadingRow
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        // Skip empty rows
        if (!isset($row['nama']) && !isset($row['merk_pompa'])) {
            return null;
        }

        $model = new Pompa([
            'nama'            => $row['nama'] ?? null,
            'merk'            => $row['merk'] ?? null,
            'jumlah'          => isset($row['jumlah']) ? (int) $row['jumlah'] : null,
            'jenis_pompa'     => $row['jenis_pompa'] ?? null,
            'merk_pompa'      => $row['merk_pompa'] ?? null,
            'tahun'           => $row['tahun'] ?? null,
            'alamat'          => $row['alamat'] ?? null,
            'status'          => (empty($row['status']) || strtolower(trim($row['status'])) === 'tidak diketahui') ? 'Aktif' : $row['status'],
            'longitude'       => $row['longtitude'] ?? null, // typo in excel
            'latitude'        => $row['latitude'] ?? null,
            'photo'           => null // default to null
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
