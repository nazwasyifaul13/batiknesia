<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Payment;
use App\Models\TryOnSession;
use App\Models\ChatHistory;
use App\Models\Product;
use App\Models\Education;
use App\Models\BatikPattern;
use App\Services\VModelService;
use App\Services\GeminiService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use App\Services\SegmindService;

class UserDashboardController extends Controller
{
    /**
     * Dashboard utama user
     */
    public function index()
    {
        $userId = Auth::id();
        
        $totalOrders = Order::where('user_id', $userId)->count();
        $pendingOrders = Order::where('user_id', $userId)->where('status', 'pending')->count();
        $completedOrders = Order::where('user_id', $userId)->where('status', 'delivered')->count();
        $totalTryOn = TryOnSession::where('user_id', $userId)->count();
        $recentOrders = Order::where('user_id', $userId)->latest()->take(5)->get();
        
        $recommendedProducts = Product::where('is_active', 1)
            ->inRandomOrder()
            ->limit(4)
            ->get();
        
        return view('user.dashboard', compact(
            'totalOrders', 'pendingOrders', 'completedOrders', 'totalTryOn',
            'recentOrders', 'recommendedProducts'
        ));
    }
    
    /**
     * Halaman produk / toko
     */
    public function products()
    {
        $products = Product::where('is_active', 1)->paginate(12);
        return view('user.products', compact('products'));
    }
    
    /**
     * Halaman toko (alias dari products)
     */
    public function shop()
    {
        $products = Product::where('is_active', 1)->paginate(12);
        return view('user.products', compact('products'));
    }
    
    /**
     * Detail produk
     */
    public function productDetail($id)
    {
        $product = Product::where('is_active', 1)->findOrFail($id);
        $relatedProducts = Product::where('is_active', 1)
            ->where('id', '!=', $id)
            ->inRandomOrder()
            ->limit(4)
            ->get();
        
        return view('user.product-detail', compact('product', 'relatedProducts'));
    }
    
    /**
     * Halaman cart / keranjang
     */
    public function cart()
    {
        $cart = session()->get('cart', []);
        $total = 0;
        
        foreach ($cart as $item) {
            $total += $item['price'] * $item['quantity'];
        }
        
        return view('user.cart', compact('cart', 'total'));
    }
    
    /**
     * Tambah ke keranjang
     */
    public function addToCart(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|integer|min:1'
        ]);
        
        $product = Product::findOrFail($request->product_id);
        $cart = session()->get('cart', []);
        
        if (isset($cart[$product->id])) {
            $cart[$product->id]['quantity'] += $request->quantity;
        } else {
            $cart[$product->id] = [
                'id' => $product->id,
                'name' => $product->name,
                'price' => $product->price,
                'image' => $product->image,
                'quantity' => $request->quantity
            ];
        }
        
        session()->put('cart', $cart);
        
        return response()->json([
            'success' => true,
            'message' => 'Produk ditambahkan ke keranjang',
            'cart_count' => count($cart)
        ]);
    }
    
    /**
     * Hapus dari keranjang
     */
    public function removeFromCart(Request $request)
    {
        $request->validate(['product_id' => 'required']);
        
        $cart = session()->get('cart', []);
        
        if (isset($cart[$request->product_id])) {
            unset($cart[$request->product_id]);
            session()->put('cart', $cart);
        }
        
        return response()->json([
            'success' => true,
            'message' => 'Produk dihapus dari keranjang'
        ]);
    }
    
    /**
     * Update keranjang
     */
    public function updateCart(Request $request)
    {
        $request->validate([
            'product_id' => 'required',
            'quantity' => 'required|integer|min:1'
        ]);
        
        $cart = session()->get('cart', []);
        
        if (isset($cart[$request->product_id])) {
            $cart[$request->product_id]['quantity'] = $request->quantity;
            session()->put('cart', $cart);
        }
        
        return response()->json([
            'success' => true,
            'message' => 'Keranjang diperbarui'
        ]);
    }
    
    /**
     * Halaman Virtual Try On
     */
    public function tryon()
    {
        $tryOnSessions = TryOnSession::where('user_id', Auth::id())->latest()->get();
        $tryOnHistory = $tryOnSessions; // alias untuk view

        $sliderProducts = Product::where('is_active', 1)->latest()->take(6)->get();
        $motifs = BatikPattern::where('is_active', 1)->get();
        return view('user.tryon', compact('tryOnSessions', 'tryOnHistory', 'motifs'));
    }
    
    /**
     * Proses Virtual Try On dengan VModel API
     */
    public function storeTryon(Request $request)
    {
        try {
            $request->validate([
                'image' => 'required|image|max:5120',
                'motif_id' => 'required|exists:batik_patterns,id',
                'model' => 'nullable|string'
            ]);

            // 1. Simpan foto user
            $userImage = $request->file('image');
            $userFilename = time() . '_user.' . $userImage->getClientOriginalExtension();
            $userImage->move(public_path('images/tryon'), $userFilename);
            
            $userImageUrl = asset('images/tryon/' . $userFilename);

            // 2. Ambil URL gambar motif
            $motif = BatikPattern::find($request->motif_id);
            $motifImageUrl = $motif->image ? asset($motif->image) : null;

            if (!$motifImageUrl) {
                return response()->json([
                    'success' => false, 
                    'error' => 'Gambar motif tidak ditemukan'
                ], 400);
            }

            // 3. Panggil VModel API
            $vmodel = new VModelService();
            $resultImage = $vmodel->virtualTryOn($userImageUrl, $motifImageUrl);

            // 4. Simpan ke database
            TryOnSession::create([
                'user_id' => Auth::id(),
                'original_image' => $userImageUrl,
                'generated_image' => $resultImage ?? $userImageUrl,
                'selected_motif_id' => $request->motif_id,
                'recommendation' => $motif->name . ' cocok untuk Anda!',
            ]);

            return response()->json([
                'success' => true,
                'generated_image' => $resultImage ?? $userImageUrl,
                'message' => 'Virtual try-on berhasil!'
            ]);

        } catch (\Exception $e) {
            Log::error('TryOn Error: ' . $e->getMessage());
            return response()->json([
                'success' => false, 
                'error' => $e->getMessage()
            ], 500);
        }
    }
    
    /**
     * Hapus riwayat try on
     */
    public function deleteTryon($id)
    {
        try {
            $tryOn = TryOnSession::where('user_id', Auth::id())->findOrFail($id);
            
            // Hapus file gambar jika ada
            if ($tryOn->original_image && file_exists(public_path(str_replace(asset(''), '', $tryOn->original_image)))) {
                @unlink(public_path(str_replace(asset(''), '', $tryOn->original_image)));
            }
            if ($tryOn->generated_image && file_exists(public_path(str_replace(asset(''), '', $tryOn->generated_image)))) {
                @unlink(public_path(str_replace(asset(''), '', $tryOn->generated_image)));
            }
            
            $tryOn->delete();
            
            return redirect()->back()->with('success', 'Riwayat try on berhasil dihapus.');
            
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Gagal menghapus riwayat.');
        }
    }
    
    /**
     * Rekomendasi produk berdasarkan motif
     */
    public function getProductRecommendation(Request $request)
    {
        $motifId = $request->get('motif_id');
        
        $products = Product::where('motif_id', $motifId)
            ->where('is_active', 1)
            ->get();
        
        if ($products->isEmpty()) {
            $products = Product::where('is_active', 1)->inRandomOrder()->limit(4)->get();
        }
        
        $recommendations = [];
        foreach ($products as $product) {
            $recommendations[] = [
                'id' => $product->id,
                'name' => $product->name,
                'price' => $product->price,
                'image' => $product->image ? asset($product->image) : null,
                'url' => route('user.checkout', ['product_id' => $product->id, 'quantity' => 1])
            ];
        }
        
        return response()->json([
            'success' => true,
            'recommendations' => $recommendations
        ]);
    }
    
    /**
     * Halaman edukasi
     */
    public function education()
    {
        $articles = Education::where('is_published', 1)->latest()->paginate(9);
        return view('user.education', compact('articles'));
    }
    
    /**
     * Halaman pesanan
     */
    public function orders()
    {
        $orders = Order::where('user_id', Auth::id())
            ->with('items.product')
            ->orderBy('created_at', 'desc')
            ->paginate(10);
        
        return view('user.orders', compact('orders'));
    }
    
    /**
     * Detail pesanan
     */
    public function orderDetail($id)
    {
        $order = Order::where('user_id', Auth::id())
            ->with('items.product')
            ->findOrFail($id);
        
        return view('user.order-detail', compact('order'));
    }
    
    /**
     * Batalkan pesanan
     */
    public function cancelOrder($id)
    {
        $order = Order::where('user_id', Auth::id())
            ->where('status', 'pending')
            ->findOrFail($id);
        
        $order->update(['status' => 'cancelled']);
        
        return redirect()->back()->with('success', 'Pesanan berhasil dibatalkan.');
    }
    
    /**
     * Halaman checkout
     */
    public function checkout(Request $request)
    {
        $productId = $request->get('product_id');
        $quantity = $request->get('quantity', 1);
        $product = Product::findOrFail($productId);
        $totalPrice = $product->price * $quantity;
        
        return view('user.checkout', compact('product', 'quantity', 'totalPrice'));
    }
    
    /**
     * Proses checkout
     */
    public function storeCheckout(Request $request)
    {
        $request->validate([
            'product_id' => 'required',
            'quantity' => 'required|integer|min:1',
            'receiver_name' => 'required|string',
            'address' => 'required|string',
            'phone' => 'required|string',
            'payment_method' => 'required',
        ]);
        
        $product = Product::findOrFail($request->product_id);
        $subtotal = $product->price * $request->quantity;
        $shippingCost = 15000;
        $totalAmount = $subtotal + $shippingCost;
        
        $shippingAddress = json_encode([
            'name' => $request->receiver_name,
            'address' => $request->address,
            'phone' => $request->phone,
            'notes' => $request->notes
        ]);
        
        $order = Order::create([
            'order_number' => 'INV-' . time() . '-' . Auth::id(),
            'user_id' => Auth::id(),
            'total_amount' => $totalAmount,
            'shipping_cost' => $shippingCost,
            'status' => 'pending',
            'payment_status' => 'unpaid',
            'shipping_address' => $shippingAddress,
            'phone' => $request->phone,
            'notes' => $request->notes,
        ]);
        
        OrderItem::create([
            'order_id' => $order->id,
            'product_id' => $product->id,
            'quantity' => $request->quantity,
            'price' => $product->price,
            'total' => $subtotal,
        ]);
        
        Payment::create([
            'order_id' => $order->id,
            'payment_method' => $request->payment_method,
            'amount' => $totalAmount,
            'status' => 'pending',
        ]);
        
        // Clear cart setelah checkout
        session()->forget('cart');
        
        return redirect()->route('user.invoice', $order->id)->with('success', 'Pesanan berhasil dibuat!');
    }
    
    /**
     * Halaman invoice
     */
    public function invoice($id)
    {
        $order = Order::with('items.product', 'payment')->findOrFail($id);
        return view('user.invoice', compact('order'));
    }
    
    /**
     * Halaman profil user
     */
    public function profile()
    {
        return view('user.profile');
    }
    
    /**
     * Update profil user (termasuk upload avatar)
     */
    public function updateProfile(Request $request)
    {
        $user = Auth::user();
        
        // Validasi input
        $request->validate([
            'name' => 'nullable|string|max:255',
            'avatar' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);
        
        // Update nama
        if ($request->filled('name')) {
            $user->name = $request->name;
        }
        
        // Update avatar
        if ($request->hasFile('avatar')) {
            // Hapus avatar lama jika ada
            if ($user->avatar && file_exists(public_path($user->avatar))) {
                @unlink(public_path($user->avatar));
            }
            
            $filename = time() . '_' . $user->id . '.' . $request->avatar->extension();
            $request->avatar->move(public_path('images/avatars'), $filename);
            $user->avatar = 'images/avatars/' . $filename;
        }
        
        $user->save();
        
        return redirect()->back()->with('success', 'Profil berhasil diperbarui!');
    }
    
    /**
     * Chatbot dengan Gemini AI
     */
    public function sendChat(Request $request)
    {
        $request->validate(['message' => 'required|string|max:500']);
        
        try {
            $gemini = new GeminiService();
            $response = $gemini->chat($request->message);
        } catch (\Exception $e) {
            $response = $this->getFallbackResponse($request->message);
        }
        
        ChatHistory::create([
            'user_id' => Auth::id(),
            'session_id' => session()->getId(),
            'user_message' => $request->message,
            'bot_response' => $response,
            'intent' => 'general',
        ]);
        
        return response()->json(['bot_response' => nl2br($response)]);
    }
    
    /**
     * Fallback response jika Gemini API gagal
     */
    private function getFallbackResponse($message)
    {
        $msg = strtolower($message);
        
        $responses = [
            'halo' => "👋 Halo! Selamat datang di Batiknesia! Ada yang bisa saya bantu?",
            'hai' => "👋 Hai! Ada yang bisa saya bantu tentang batik?",
            'help' => "💡 Saya bisa membantu: informasi motif batik, rekomendasi warna, harga batik, dan virtual try on!",
            'parang' => "🟤 Motif Parang dari Yogyakarta. Melambangkan kesinambungan dan kekuatan. Cocok untuk acara formal!",
            'kawung' => "🟢 Motif Kawung dari Yogyakarta. Melambangkan kesucian dan harapan. Cocok untuk sehari-hari!",
            'mega mendung' => "☁️ Motif Mega Mendung khas Cirebon. Melambangkan kesabaran dan ketenangan!",
            'truntum' => "💛 Motif Truntum dari Solo. Melambangkan cinta yang tumbuh kembali. Cocok untuk pernikahan!",
            'sidomukti' => "💚 Motif Sidomukti dari Solo. Melambangkan kemakmuran dan kebahagiaan!",
            'kulit sawo' => "🎨 Untuk kulit sawo matang: Motif Parang warna coklat keemasan sangat cocok!",
            'kulit putih' => "🎨 Untuk kulit putih: Motif Mega Mendung warna biru akan terlihat elegan!",
            'kulit gelap' => "🎨 Untuk kulit gelap: Motif Kawung warna cerah seperti kuning atau emas cocok!",
            'harga' => "💰 Harga batik: Tulis Rp500.000-2.000.000, Cap Rp200.000-500.000, Printing Rp150.000-300.000",
            'rekomendasi' => "🎯 Rekomendasi: Parang (formal), Kawung (sehari-hari), Mega Mendung (artistik)",
            'terima kasih' => "🙏 Sama-sama! Senang bisa membantu. Ada lagi yang ingin ditanyakan?",
            'makasih' => "🙏 Sama-sama! Selamat berbelanja batik di Batiknesia!"
        ];
        
        foreach ($responses as $key => $response) {
            if (strpos($msg, $key) !== false) {
                return $response;
            }
        }
        
        return "🤖 Halo! Saya asisten AI Batiknesia. Coba tanyakan: 'motif parang', 'kulit sawo matang', 'rekomendasi batik', atau 'harga batik'.";
    }
    public function uploadProof(Request $request)
{
    $request->validate([
        'order_id' => 'required|exists:orders,id',
        'proof' => 'required|image|mimes:jpg,jpeg,png|max:2048'
    ]);
    
    $order = Order::where('user_id', Auth::id())->findOrFail($request->order_id);
    
    if ($request->hasFile('proof')) {
        $file = $request->file('proof');
        $filename = 'payment_' . $order->id . '_' . time() . '.' . $file->getClientOriginalExtension();
        $path = 'uploads/payments/';
        
        if (!file_exists(public_path($path))) {
            mkdir(public_path($path), 0777, true);
        }
        
        $file->move(public_path($path), $filename);
        $order->payment_proof = $path . $filename;
        $order->payment_status = 'pending_verifikasi';
        $order->save();
        
        return response()->json(['success' => true, 'message' => 'Bukti pembayaran terupload']);
    }
    
    return response()->json(['success' => false, 'message' => 'Upload gagal']);
}
}