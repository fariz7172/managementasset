<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SubPolder extends Model
{
    protected $fillable = [
        'nama_lokasi',
        'jumlah_unit',
        'total_kapasitas',
        'jenis_pompa',
        'merk_pompa',
        'alamat',
        'latitude',
        'longitude',
        'status',
        'photo',
        'deskripsi',
    ];

    protected $casts = [
        'photo' => 'array',
    ];
}
