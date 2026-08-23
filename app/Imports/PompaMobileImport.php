<?php

namespace App\Imports;

use App\Models\PompaMobile;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class PompaMobileImport implements ToModel, WithHeadingRow
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        // Skip empty rows
        if (empty($row['lokasi_penempatan_pompa_saat_ini'])) {
            return null;
        }

        $model = new PompaMobile([
            'lokasi'          => $row['lokasi_penempatan_pompa_saat_ini'] ?? null,
            'jenis_type'      => $row['jenis_type'] ?? null,
            'no_seri_plat'    => $row['no_seri_plat_no'] ?? null,
            'merk'            => $row['merk'] ?? null,
            'kapasitas'       => isset($row['kapasitas_lps']) ? (string) $row['kapasitas_lps'] : null,
            'tahun_pembuatan' => isset($row['tahun_pembuatan']) ? (string) $row['tahun_pembuatan'] : null,
            'kewenangan'      => $row['kewenangan'] ?? null,
            'total'           => isset($row['total']) ? (int) $row['total'] : null,
            'baik'            => isset($row['baik']) ? (int) $row['baik'] : null,
            'rusak'           => isset($row['rusak']) ? (int) $row['rusak'] : null,
            'latitude'        => self::cleanCoordinate($row['x'] ?? null),
            'longitude'       => self::cleanCoordinate($row['y'] ?? null),
            'keterangan'      => $row['keterangan'] ?? null,
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
        
        // Remove spaces, newlines, and any other garbage
        $cleaned = trim(preg_replace('/\s+/', '', $value));
        
        // Remove commas (like in 1,067,370,596)
        $cleaned = str_replace(',', '', $cleaned);
        
        // If it's a huge number without a decimal point, insert the decimal point based on its apparent length.
        // For latitude in Jakarta: usually -6.xxxxxx
        // For longitude in Jakarta: usually 106.xxxxxx
        if (strpos($cleaned, '.') === false) {
            if (substr($cleaned, 0, 1) === '-' && strlen($cleaned) > 2) {
                // Example: -6117734801 -> -6.117734801
                $cleaned = substr($cleaned, 0, 2) . '.' . substr($cleaned, 2);
            } elseif (strlen($cleaned) > 3) {
                // Example: 1067370596 -> 106.7370596
                $cleaned = substr($cleaned, 0, 3) . '.' . substr($cleaned, 3);
            }
        }
        
        return $cleaned;
    }
}
