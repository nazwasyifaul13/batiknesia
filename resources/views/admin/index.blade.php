@extends('layouts.admin')

@section('title', 'Pesan Customer')
@section('subtitle', 'Balas pertanyaan pengguna')

@section('content')
<style>
    .chat-container {
        display: flex;
        gap: 25px;
        height: calc(100vh - 150px);
    }
    
    .chat-list {
        width: 350px;
        background: var(--bg-card);
        border-radius: 20px;
        border: 1px solid var(--border);
        overflow: hidden;
        display: flex;
        flex-direction: column;
    }
    
    .chat-list-header {
        padding: 18px;
        background: linear-gradient(135deg, #c4a747, #8b7355);
        color: white;
    }
    
    .chat-users {
        flex: 1;
        overflow-y: auto;
    }
    
    .chat-user-item {
        padding: 15px;
        border-bottom: 1px solid var(--border);
        cursor: pointer;
        transition: all 0.3s;
    }
    
    .chat-user-item:hover {
        background: rgba(196,167,71,0.1);
    }
    
    .chat-user-item.active {
        background: rgba(196,167,71,0.15);
        border-left: 3px solid #c4a747;
    }
    
    .chat-user-name {
        font-weight: 600;
        color: var(--text-primary);
    }
    
    .chat-user-last {
        font-size: 11px;
        color: var(--text-muted);
        margin-top: 5px;
    }
    
    .chat-detail {
        flex: 1;
        background: var(--bg-card);
        border-radius: 20px;
        border: 1px solid var(--border);
        display: flex;
        flex-direction: column;
        overflow: hidden;
    }
    
    .chat-header {
        padding: 18px;
        border-bottom: 1px solid var(--border);
        background: var(--bg-primary);
    }
    
    .chat-messages-area {
        flex: 1;
        padding: 20px;
        overflow-y: auto;
        display: flex;
        flex-direction: column;
        gap: 12px;
    }
    
    .message-user {
        align-self: flex-start;
        background: #e8dcca;
        padding: 10px 15px;
        border-radius: 18px;
        max-width: 70%;
        color: #5c4033;
        border-bottom-left-radius: 5px;
    }
    
    .message-admin {
        align-self: flex-end;
        background: linear-gradient(135deg, #c4a747, #8b7355);
        color: white;
        padding: 10px 15px;
        border-radius: 18px;
        max-width: 70%;
        border-bottom-right-radius: 5px;
    }
    
    .chat-input-area {
        padding: 15px;
        border-top: 1px solid var(--border);
        display: flex;
        gap: 10px;
    }
    
    .chat-reply-input {
        flex: 1;
        padding: 12px;
        border: 1px solid var(--border);
        border-radius: 30px;
        background: var(--bg-primary);
        color: var(--text-primary);
    }
    
    .btn-send {
        background: linear-gradient(135deg, #c4a747, #8b7355);
        border: none;
        padding: 10px 20px;
        border-radius: 30px;
        color: white;
        cursor: pointer;
    }
    
    .unread-badge {
        background: #ef4444;
        color: white;
        border-radius: 20px;
        padding: 2px 8px;
        font-size: 10px;
        margin-left: 8px;
    }
    
    .empty-state {
        text-align: center;
        padding: 50px;
        color: var(--text-muted);
    }
</style>

<div class="chat-container">
    <!-- Chat List -->
    <div class="chat-list">
        <div class="chat-list-header">
            <h4><i class="fas fa-comments"></i> Percakapan</h4>
            <p class="text-sm mt-1" style="color: rgba(255,255,255,0.8);">{{ $unreadCount }} pesan belum dibaca</p>
        </div>
        <div class="chat-users" id="chatUsersList">
            @forelse($chats as $userId => $userChats)
                @php
                    $user = $userChats->first()->user;
                    $lastChat = $userChats->first();
                    $unreadFromUser = $userChats->where('is_read_admin', false)->count();
                @endphp
                <div class="chat-user-item" data-user-id="{{ $userId }}" onclick="selectUser({{ $userId }}, '{{ addslashes($user->name) }}')">
                    <div class="chat-user-name">
                        {{ $user->name }}
                        @if($unreadFromUser > 0)
                            <span class="unread-badge">{{ $unreadFromUser }}</span>
                        @endif
                    </div>
                    <div class="chat-user-last">
                        {{ Str::limit($lastChat->message, 40) }}
                    </div>
                    <div style="font-size: 10px; color: var(--text-muted); margin-top: 4px;">
                        {{ $lastChat->created_at->diffForHumans() }}
                    </div>
                </div>
            @empty
                <div class="empty-state">
                    <i class="fas fa-inbox" style="font-size: 40px; margin-bottom: 10px;"></i>
                    <p>Belum ada pesan dari customer</p>
                </div>
            @endforelse
        </div>
    </div>
    
    <!-- Chat Detail -->
    <div class="chat-detail" id="chatDetail">
        <div class="empty-state" style="height: 100%; display: flex; flex-direction: column; justify-content: center;">
            <i class="fas fa-comment-dots" style="font-size: 50px; margin-bottom: 15px;"></i>
            <p>Pilih percakapan untuk membalas pesan customer</p>
        </div>
    </div>
</div>

<script>
let currentUserId = null;
let pollingInterval = null;

function selectUser(userId, userName) {
    currentUserId = userId;
    
    // Update chat detail
    fetch(`/admin/chats/messages/${userId}`)
        .then(res => res.json())
        .then(data => {
            const chatDetail = document.getElementById('chatDetail');
            chatDetail.innerHTML = `
                <div class="chat-header">
                    <h4><i class="fas fa-user"></i> ${userName}</h4>
                    <p style="font-size: 11px; color: var(--text-muted);">Balas pesan customer di sini</p>
                </div>
                <div class="chat-messages-area" id="chatMessagesArea">
                    ${data.messages.map(msg => `
                        <div class="message-${msg.sender}">
                            <strong>${msg.sender === 'user' ? userName : 'Admin'}:</strong><br>
                            ${msg.message}
                            <div style="font-size: 10px; margin-top: 5px; opacity: 0.6;">${new Date(msg.created_at).toLocaleString()}</div>
                        </div>
                    `).join('')}
                </div>
                <div class="chat-input-area">
                    <input type="text" class="chat-reply-input" id="replyInput" placeholder="Tulis balasan...">
                    <button class="btn-send" onclick="sendReply()"><i class="fas fa-paper-plane"></i> Kirim</button>
                </div>
            `;
            
            // Mark as read
            markAsRead(userId);
            
            // Scroll to bottom
            const messagesArea = document.getElementById('chatMessagesArea');
            if (messagesArea) messagesArea.scrollTop = messagesArea.scrollHeight;
            
            // Focus input
            document.getElementById('replyInput')?.focus();
        });
}

function sendReply() {
    const replyInput = document.getElementById('replyInput');
    const reply = replyInput.value.trim();
    
    if (!reply || !currentUserId) return;
    
    fetch('/admin/chats/reply', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': '{{ csrf_token() }}'
        },
        body: JSON.stringify({
            user_id: currentUserId,
            reply: reply
        })
    })
    .then(res => res.json())
    .then(data => {
        if (data.success) {
            replyInput.value = '';
            // Refresh chat area
            selectUser(currentUserId, document.querySelector('.chat-header h4')?.innerText?.replace(/[^\w\s]/g, '') || 'Customer');
        }
    });
}

function markAsRead(userId) {
    fetch(`/admin/chats/mark-read/${userId}`, {
        method: 'POST',
        headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}' }
    });
}

// Polling for new messages
function startPolling() {
    if (pollingInterval) clearInterval(pollingInterval);
    pollingInterval = setInterval(() => {
        if (currentUserId) {
            fetch(`/admin/chats/messages/${currentUserId}`)
                .then(res => res.json())
                .then(data => {
                    const messagesArea = document.getElementById('chatMessagesArea');
                    if (messagesArea && data.messages.length > 0) {
                        // Update if new messages
                        const currentMessageCount = messagesArea.children.length;
                        if (data.messages.length > currentMessageCount) {
                            selectUser(currentUserId, document.querySelector('.chat-header h4')?.innerText || 'Customer');
                        }
                    }
                });
        }
        // Update unread badge on user list
        fetch('/admin/chats/unread-count')
            .then(res => res.json())
            .then(data => {
                const unreadBadges = document.querySelectorAll('.unread-badge');
                if (data.count > 0) {
                    // Update UI
                }
            });
    }, 5000);
}

startPolling();
</script>
@endsection