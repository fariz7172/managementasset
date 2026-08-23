<?php

namespace App\Imports;

use App\Models\PintuAir;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class PintuAirImport implements ToModel, WithHeadingRow
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        // Skip empty rows
        if (empty($row['nama_pintu_air'])) {
            return null;
        }

        // Parse Koordinat (Format usually: "lat, lng" or "lat; lng")
        $latitude = null;
        $longitude = null;
        
        if (!empty($row['koordinat'])) {
            $koorString = $row['koordinat'];
            $parts = preg_split('/[,;\s]+/', trim($koorString));
            if (count($parts) >= 2) {
                $latitude = self::cleanCoordinate($parts[0]);
                $longitude = self::cleanCoordinate($parts[1]);
            }
        }

        $model = new PintuAir([
            'nama'            => $row['nama_pintu_air'] ?? null,
            'alamat'          => $row['alamat'] ?? null,
            'google_map'      => $row['google_map'] ?? null,
            'koordinat'       => $row['koordinat'] ?? null,
            'tahun_pekerjaan' => isset($row['tahun_pekerjaan']) ? (string) $row['tahun_pekerjaan'] : null,
            'kelurahan'       => $row['kelurahan'] ?? null,
            'kecamatan'       => $row['kecamatan'] ?? null,
            'jumlah_pintu'    => isset($row['jumlah_pintu']) ? (int) $row['jumlah_pintu'] : null,
            'keterangan'      => $row['keterangan'] ?? null,
            'kib_d'           => $row['kib_d'] ?? null,
            'latitude'        => $latitude,
            'longitude'       => $longitude,
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

    /**
     * Clean and format coordinate string
     */
    private static function cleanCoordinate($value)
    {
        if (empty($value)) return null;
        
        $cleaned = trim(preg_replace('/[^0-9\.\-]/', '', $value));
        
        if (strpos($cleaned, '.') === false) {
            if (substr($cleaned, 0, 1) === '-' && strlen($cleaned) > 2) {
                $cleaned = substr($cleaned, 0, 2) . '.' . substr($cleaned, 2);
            } elseif (strlen($cleaned) > 3) {
                $cleaned = substr($cleaned, 0, 3) . '.' . substr($cleaned, 3);
            }
        }
        
        return $cleaned;
    }
}
