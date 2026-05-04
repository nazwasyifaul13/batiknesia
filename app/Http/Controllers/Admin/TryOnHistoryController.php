<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\TryOnSession;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class TryOnHistoryController extends Controller
{
    public function index()
    {
        $tryOnSessions = TryOnSession::with('user', 'motif')->orderBy('created_at', 'desc')->paginate(15);
        return view('admin.tryon-history.index', compact('tryOnSessions'));
    }
    
    public function destroy($id)
    {
        $tryOn = TryOnSession::findOrFail($id);
        
        // Hapus file gambar
        if ($tryOn->original_image && File::exists(public_path($tryOn->original_image))) {
            File::delete(public_path($tryOn->original_image));
        }
        if ($tryOn->generated_image && File::exists(public_path($tryOn->generated_image))) {
            File::delete(public_path($tryOn->generated_image));
        }
        
        $tryOn->delete();
        
        return redirect()->route('admin.tryon-history.index')->with('success', 'Riwayat try on berhasil dihapus');
    }
}