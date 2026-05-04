<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'slug',
        'description',
        'price',
        'stock',
        'image',
        'qr_code',       
        'motif_id',  
        'category_id',
        'motif_id',
        'is_active',
        'is_featured',
        'weight'
    ];

    protected $casts = [
        'price' => 'decimal:2',
        'is_active' => 'boolean',
        'is_featured' => 'boolean',
    ];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function motif()
    {
        return $this->belongsTo(BatikPattern::class, 'motif_id');
    }

    public function orderItems()
    {
        return $this->hasMany(OrderItem::class);
    }
}