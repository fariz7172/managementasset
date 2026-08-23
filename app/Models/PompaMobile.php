<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PompaMobile extends Model
{
    protected $fillable = [
        'lokasi',
        'jenis_type',
        'no_seri_plat',
        'merk',
        'kapasitas',
        'tahun_pembuatan',
        'kewenangan',
        'total',
        'baik',
        'rusak',
        'longitude',
        'latitude',
        'keterangan',
        'status',
        'photo',
    ];

    protected $casts = [
        'photo' => 'array',
    ];
}
