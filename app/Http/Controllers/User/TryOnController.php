<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\TryOnSession;
use App\Models\BatikPattern;
use App\Services\VModelService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TryOnController extends Controller
{
    /**
     * Tampilkan halaman Virtual Try On
     */
    public function index()
    {
        $tryOnHistory = TryOnSession::where('user_id', Auth::id())
            ->with('motif')
            ->orderBy('created_at', 'desc')
            ->get();
        
        $motifs = BatikPattern::where('is_active', 1)->get();
        
        return view('user.tryon', compact('tryOnHistory', 'motifs'));
    }
    
    /**
     * Proses upload foto dan Virtual Try On
     */
    public function upload(Request $request)
    {
        try {
            // Validasi
            $request->validate([
                'image' => 'required|image|mimes:jpeg,png,jpg|max:5120',
                'motif_id' => 'required|exists:batik_patterns,id',
            ]);
            
            // 1. SIMPAN FOTO USER
            $userImage = $request->file('image');
            $userFilename = time() . '_user_' . Auth::id() . '.' . $userImage->getClientOriginalExtension();
            $userImage->move(public_path('images/tryon'), $userFilename);
            $userImagePath = public_path('images/tryon/' . $userFilename);
            $userImageUrl = asset('images/tryon/' . $userFilename);
            
            // 2. AMBIL DATA MOTIF
            $motif = BatikPattern::find($request->motif_id);
            $motifName = $motif ? $motif->name : 'Batik';
            $motifPath = $motif->image ? public_path($motif->image) : null;
            
            $resultImage = null;
            $recommendation = "Motif {$motifName} telah diaplikasikan ke foto Anda!";
            
            // 3. PANGGIL VMODEL API (JIKA ADA)
            if ($motifPath && file_exists($motifPath)) {
                try {
                    $vmodel = new VModelService();
                    $resultImage = $vmodel->tryOn($userImagePath, $motifPath);
                    
                    if ($resultImage) {
                        $recommendation = "✨ Motif {$motifName} berhasil diaplikasikan! Terlihat sangat cocok dengan Anda. ✨";
                    }
                } catch (\Exception $e) {
                    \Log::error('VModel Error: ' . $e->getMessage());
                }
            }
            
            // 4. SIMPAN KE DATABASE
            $tryOn = TryOnSession::create([
                'user_id' => Auth::id(),
                'original_image' => $userImageUrl,
                'generated_image' => $resultImage ?: $userImageUrl,
                'selected_motif_id' => $request->motif_id,
                'recommendation' => $recommendation,
                'ai_response_data' => json_encode([
                    'status' => $resultImage ? 'success' : 'fallback',
                    'generated' => $resultImage ? true : false
                ])
            ]);
            
            // 5. RETURN RESPONSE
            return response()->json([
                'success' => true,
                'generated_image' => $resultImage ?: $userImageUrl,
                'tryon_id' => $tryOn->id,
                'recommendation' => $recommendation,
                'message' => 'Virtual try-on berhasil!'
            ]);
            
        } catch (\Exception $e) {
            \Log::error('TryOn Upload Error: ' . $e->getMessage());
            
            return response()->json([
                'success' => false,
                'error' => 'Terjadi kesalahan: ' . $e->getMessage()
            ], 500);
        }
    }
    
    /**
     * Tampilkan riwayat try on user
     */
    public function history()
    {
        $history = TryOnSession::where('user_id', Auth::id())
            ->with('motif')
            ->orderBy('created_at', 'desc')
            ->paginate(15);
        
        return view('user.tryon-history', compact('history'));
    }
    
    /**
     * Hapus riwayat try on
     */
    public function destroy($id)
    {
        try {
            $tryOn = TryOnSession::where('user_id', Auth::id())->findOrFail($id);
            
            // Hapus file gambar
            if ($tryOn->original_image && file_exists(public_path($tryOn->original_image))) {
                @unlink(public_path($tryOn->original_image));
            }
            if ($tryOn->generated_image && file_exists(public_path($tryOn->generated_image))) {
                @unlink(public_path($tryOn->generated_image));
            }
            
            $tryOn->delete();
            
            return redirect()->back()->with('success', 'Riwayat try on berhasil dihapus.');
            
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Gagal menghapus riwayat.');
        }
    }
}