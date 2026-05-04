<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class TryOnSession extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'original_image',
        'generated_image',
        'selected_motif_id',
        'recommendation',
        'ai_response_data',
        'skin_tone_detected'
    ];

    protected $casts = [
        'ai_response_data' => 'array',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function motif()
    {
        return $this->belongsTo(BatikPattern::class, 'selected_motif_id');
    }
}