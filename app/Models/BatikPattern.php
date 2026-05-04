<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class BatikPattern extends Model
{
    use HasFactory;

    protected $table = 'batik_patterns';

    protected $fillable = [
        'name',
        'slug',
        'origin',
        'philosophy',
        'description',
        'image',
        'video_url',
        'color_palette',
        'suitable_skin_tone',
        'is_active',
        'views_count'
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'views_count' => 'integer',
        'color_palette' => 'array',
    ];

    public function products()
    {
        return $this->hasMany(Product::class, 'motif_id');
    }
}