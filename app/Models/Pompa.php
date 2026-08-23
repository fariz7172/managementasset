<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pompa extends Model
{
    use HasFactory;

    protected $fillable = [
        'nama',
        'merk',
        'jumlah',
        'jenis_pompa',
        'merk_pompa',
        'tahun',
        'alamat',
        'titik_koordinat',
        'status',
        'deskripsi',
        'longitude',
        'latitude',
        'photo',
    ];

    protected $casts = [
        'photo' => 'array',
    ];
}
