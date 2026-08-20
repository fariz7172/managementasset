<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AppPortal extends Model
{
    protected $fillable = [
        'title',
        'slug',
        'description',
        'url',
        'status',
    ];

    public function images()
    {
        return $this->hasMany(AppPortalImage::class);
    }
}
