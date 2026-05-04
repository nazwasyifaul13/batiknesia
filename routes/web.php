<?php

use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\OrderController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\BatikPatternController;
use App\Http\Controllers\Admin\EducationController;
use App\Http\Controllers\Admin\ReportController;
use App\Http\Controllers\Admin\TryOnHistoryController;
use App\Http\Controllers\User\UserDashboardController;
use App\Http\Controllers\ProductQRController;
use App\Http\Controllers\User\TrackingController;
use App\Http\Controllers\User\ProfileController;
use App\Http\Controllers\User\QRScannerController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

// ==================== QR CODE ROUTE ====================
Route::get('/product/qr/{slug}', [ProductQRController::class, 'detail'])->name('product.qr.detail');

// ==================== HALAMAN DEPAN ====================
Route::get('/', function () {
    return view('landing');
});

// ==================== HALAMAN LOGIN ====================
Route::get('/login', function () {
    return view('auth.login');
})->name('login');

// ==================== PROSES LOGIN ====================
Route::post('/login', function (\Illuminate\Http\Request $request) {
    $credentials = $request->validate([
        'email' => ['required', 'email'],
        'password' => ['required'],
    ]);

    if (Auth::attempt($credentials, $request->remember)) {
        $request->session()->regenerate();
        
        $selectedRole = $request->role;
        $userRole = Auth::user()->role;
        
        if ($selectedRole == 'admin' && $userRole == 'admin') {
            return redirect()->route('admin.dashboard')->with('success', 'Login sebagai Admin berhasil!');
        } elseif ($selectedRole == 'user') {
            return redirect()->route('user.dashboard')->with('success', 'Login sebagai User berhasil!');
        } else {
            Auth::logout();
            return back()->withErrors(['role' => 'Anda tidak memiliki akses sebagai ' . $selectedRole]);
        }
    }

    return back()->withErrors(['email' => 'Email atau password salah.']);
});

// ==================== HALAMAN REGISTER ====================
Route::get('/register', function () {
    return view('auth.register');
})->name('register');

Route::post('/register', function (\Illuminate\Http\Request $request) {
    $request->validate([
        'name' => 'required|string|max:255',
        'email' => 'required|string|email|max:255|unique:users',
        'password' => 'required|string|min:6|confirmed',
    ]);

    $user = \App\Models\User::create([
        'name' => $request->name,
        'email' => $request->email,
        'password' => bcrypt($request->password),
        'role' => 'user',
    ]);

    Auth::login($user);
    return redirect()->route('user.dashboard')->with('success', 'Selamat datang ' . $user->name . '! Pendaftaran berhasil.');
});

// ==================== LOGOUT ====================
Route::post('/logout', function (\Illuminate\Http\Request $request) {
    Auth::logout();
    $request->session()->invalidate();
    $request->session()->regenerateToken();
    return redirect('/login');
})->name('logout');

// ==================== ADMIN ROUTES ====================
Route::prefix('admin')->middleware(['auth'])->name('admin.')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::resource('products', ProductController::class);
    Route::resource('orders', OrderController::class);
    Route::resource('users', UserController::class);
    Route::resource('batik-patterns', BatikPatternController::class);
    Route::resource('education', EducationController::class);
    Route::get('/reports', [ReportController::class, 'index'])->name('reports.index');
    Route::put('/orders/{id}/status', [OrderController::class, 'updateStatus'])->name('orders.update-status');
    Route::get('/tryon-history', [TryOnHistoryController::class, 'index'])->name('tryon-history.index');
    Route::delete('/tryon-history/{id}', [TryOnHistoryController::class, 'destroy'])->name('tryon-history.destroy');
    // TAMBAHKAN ROUTE CHAT
    Route::get('/chats', [App\Http\Controllers\Admin\ChatController::class, 'index'])->name('chats');
    Route::get('/chats/messages/{userId}', [App\Http\Controllers\Admin\ChatController::class, 'getMessages'])->name('chats.messages');
    Route::post('/chats/reply', [App\Http\Controllers\Admin\ChatController::class, 'sendReply'])->name('chats.reply');
});

// ==================== USER ROUTES ====================
Route::prefix('user')->middleware(['auth'])->name('user.')->group(function () {
    Route::get('/dashboard', [UserDashboardController::class, 'index'])->name('dashboard');
    Route::get('/products', [UserDashboardController::class, 'products'])->name('products');
    Route::get('/product/detail/{id}', [UserDashboardController::class, 'productDetail'])->name('product.detail');
    Route::get('/tryon', [UserDashboardController::class, 'tryon'])->name('tryon');
    Route::post('/tryon', [UserDashboardController::class, 'storeTryon'])->name('tryon.store');
    Route::delete('/tryon/{id}', [UserDashboardController::class, 'deleteTryon'])->name('tryon.delete');
    Route::get('/orders', [UserDashboardController::class, 'orders'])->name('orders');
    Route::get('/orders/{id}', [UserDashboardController::class, 'orderDetail'])->name('order.detail');
    Route::post('/orders/{id}/cancel', [UserDashboardController::class, 'cancelOrder'])->name('order.cancel');
    Route::get('/checkout', [UserDashboardController::class, 'checkout'])->name('checkout');
    Route::post('/checkout', [UserDashboardController::class, 'storeCheckout'])->name('checkout.store');
    Route::get('/invoice/{id}', [UserDashboardController::class, 'invoice'])->name('invoice');
    Route::get('/education', [UserDashboardController::class, 'education'])->name('education');
    Route::get('/education/detail/{id}', [UserDashboardController::class, 'educationDetail'])->name('education.detail');
    Route::post('/chat/send', [UserDashboardController::class, 'sendChat'])->name('chat.send');
    Route::get('/chat/messages', [UserDashboardController::class, 'getChatMessages'])->name('chat.messages');
    Route::get('/chat/unread', [UserDashboardController::class, 'getUnreadCount'])->name('chat.unread');
    Route::get('/get-product-recommendation', [UserDashboardController::class, 'getProductRecommendation'])->name('product.recommendation');
    
    Route::get('/tracking', [TrackingController::class, 'index'])->name('tracking');
    Route::get('/tracking/update/{id}', [TrackingController::class, 'getLocation'])->name('tracking.update');
    Route::get('/profile', [ProfileController::class, 'index'])->name('profile');
    Route::post('/profile/update', [ProfileController::class, 'update'])->name('profile.update');
    Route::get('/qr-scanner', [QRScannerController::class, 'index'])->name('qr.scanner');
    Route::post('/qr/process', [QRScannerController::class, 'process'])->name('qr.process');
    Route::post('/order/upload-proof', [UserDashboardController::class, 'uploadProof'])->name('order.upload-proof');
});