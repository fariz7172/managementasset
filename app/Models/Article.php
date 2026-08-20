<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Article extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'slug',
        'content',
        'activity_date',
        'status',
    ];

    protected $casts = [
        'activity_date' => 'date',
    ];

    public function images()
    {
        return $this->hasMany(ArticleImage::class);
    }
}
