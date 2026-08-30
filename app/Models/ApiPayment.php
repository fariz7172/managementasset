<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ApiPayment extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected $casts = [
        'contract_tgl' => 'date',
        'raw_data' => 'array',
    ];
}
