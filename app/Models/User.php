<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    protected $fillable = [
        'name', 'email', 'password', 'role', 'seller_status',
        'store_name', 'store_description', 'avatar'
    ];

    // Relasi ke chats (user mengirim chat)
    public function chats()
    {
        return $this->hasMany(Chat::class, 'user_id');
    }
    
    // Relasi ke chats (admin yang membalas)
    public function adminChats()
    {
        return $this->hasMany(Chat::class, 'admin_id');
    }

    public function isAdmin() { return $this->role === 'admin'; }
    public function isSeller() { return $this->role === 'seller'; }
    public function isUser() { return $this->role === 'user'; }
    public function isSellerApproved() { return $this->seller_status === 'approved'; }
    
    public function products()
    {
        return $this->hasMany(Product::class, 'seller_id');
    }
    
    public function ordersAsSeller()
    {
        return $this->hasMany(Order::class, 'seller_id');
    }
}