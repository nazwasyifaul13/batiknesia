<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Chat;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ChatController extends Controller
{
    public function send(Request $request)
    {
        $request->validate([
            'message' => 'required|string|max:1000'
        ]);
        
        $chat = Chat::create([
            'user_id' => Auth::id(),
            'message' => $request->message,
            'sender' => 'user',
            'status' => 'pending',
            'is_read_admin' => false
        ]);
        
        return response()->json([
            'success' => true,
            'chat_id' => $chat->id
        ]);
    }
    
    public function getMessages(Request $request)
    {
        $lastId = $request->get('last_id', 0);
        
        $messages = Chat::where('user_id', Auth::id())
            ->where('sender', 'admin')
            ->where('id', '>', $lastId)
            ->orderBy('id', 'asc')
            ->get();
        
        return response()->json([
            'messages' => $messages
        ]);
    }
    public function unreadCount()
{
    $count = Chat::where('user_id', Auth::id())
        ->where('sender', 'admin')
        ->where('is_read_user', false)
        ->count();
    
    return response()->json(['count' => $count]);
}
}