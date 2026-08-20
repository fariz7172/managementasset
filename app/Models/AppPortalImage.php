<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AppPortalImage extends Model
{
    protected $fillable = [
        'app_portal_id',
        'image_path',
    ];

    public function portal()
    {
        return $this->belongsTo(AppPortal::class, 'app_portal_id');
    }
}
