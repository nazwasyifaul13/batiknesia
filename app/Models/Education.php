<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Education extends Model
{
    protected $table = 'education';
    
    protected $fillable = [
        'title', 'slug', 'type', 'content', 'youtube_url',
        'thumbnail', 'author', 'excerpt', 'views', 'is_published'
    ];
    
    protected $casts = [
        'is_published' => 'boolean',
        'views' => 'integer'
    ];
    
    public function getYoutubeEmbedUrlAttribute()
    {
        if ($this->youtube_url) {
            parse_str(parse_url($this->youtube_url, PHP_URL_QUERY), $params);
            $videoId = $params['v'] ?? null;
            if ($videoId) {
                return "https://www.youtube.com/embed/{$videoId}";
            }
        }
        return null;
    }
}