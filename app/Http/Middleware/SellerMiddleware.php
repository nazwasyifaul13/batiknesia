<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class SellerMiddleware
{
    public function handle($request, Closure $next)
    {
        if (Auth::check() && Auth::user()->role === 'seller' && Auth::user()->seller_status === 'approved') {
            return $next($request);
        }
        return redirect('/')->with('error', 'Akses ditolak!');
    }
}