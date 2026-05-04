<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Chat;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ChatController extends Controller
{
    public function index()
    {
        // Ambil semua user yang pernah chat
        $users = User::whereHas('chats', function($query) {
            $query->where('sender', 'user');
        })->with('chats')->get();
        
        // Untuk setiap user, hitung pesan belum dibaca admin
        foreach ($users as $user) {
            $user->unread_count = Chat::where('user_id', $user->id)
                ->where('sender', 'user')
                ->where('is_read', false)
                ->count();
        }
        
        return view('admin.chats', compact('users'));
    }
    
    public function getMessages($userId)
    {
        $messages = Chat::where('user_id', $userId)
            ->orderBy('created_at', 'asc')
            ->get();
        
        // Tandai pesan user sebagai sudah dibaca
        Chat::where('user_id', $userId)
            ->where('sender', 'user')
            ->where('is_read', false)
            ->update(['is_read' => true]);
        
        return response()->json(['messages' => $messages]);
    }
    
    public function sendReply(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'message' => 'required|string|max:500'
        ]);
        
        $chat = Chat::create([
            'user_id' => $request->user_id,
            'admin_id' => Auth::id(),
            'message' => $request->message,
            'sender' => 'admin',
            'is_read' => false
        ]);
        
        return response()->json(['success' => true, 'chat' => $chat]);
    }
}