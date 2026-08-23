<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PintuAir extends Model
{
    protected $fillable = [
        'alamat',
        'nama',
        'google_map',
        'koordinat',
        'tahun_pekerjaan',
        'kelurahan',
        'kecamatan',
        'jumlah_pintu',
        'keterangan',
        'kib_d',
        'latitude',
        'longitude',
        'status',
        'photo',
    ];

    protected $casts = [
        'photo' => 'array',
    ];
}
