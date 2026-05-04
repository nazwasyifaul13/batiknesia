<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Chat extends Model
{
    protected $table = 'chats';
    
    protected $fillable = [
        'user_id', 'admin_id', 'message', 'sender', 'is_read'
    ];
    
    protected $casts = [
        'is_read' => 'boolean'
    ];
    
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
    
    public function admin()
    {
        return $this->belongsTo(User::class, 'admin_id');
    }
}