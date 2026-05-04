@extends('layouts.admin')

@section('title', 'Chat User')
@section('subtitle', 'Kelola pesan dari user')

@push('styles')
<style>
    .chat-container {
        display: flex;
        gap: 24px;
        height: 70vh;
    }
    .user-list {
        width: 320px;
        background: var(--bg-card);
        border-radius: 20px;
        border: 1px solid var(--border);
        overflow-y: auto;
    }
    .user-item {
        padding: 15px;
        border-bottom: 1px solid var(--border);
        cursor: pointer;
        transition: all 0.3s;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }
    .user-item:hover { background: var(--accent-glow); }
    .user-item.active { background: var(--accent-glow); border-left: 3px solid var(--accent); }
    .user-name { font-weight: 600; color: var(--text-primary); }
    .user-email { font-size: 11px; color: var(--text-secondary); margin-top: 2px; }
    .unread-badge {
        background: #ef4444;
        color: white;
        border-radius: 30px;
        padding: 2px 8px;
        font-size: 10px;
        font-weight: 600;
    }
    .chat-area {
        flex: 1;
        background: var(--bg-card);
        border-radius: 20px;
        border: 1px solid var(--border);
        display: flex;
        flex-direction: column;
    }
    .chat-header {
        padding: 15px 20px;
        border-bottom: 1px solid var(--border);
        font-weight: 600;
        color: var(--text-primary);
    }
    .chat-messages {
        flex: 1;
        padding: 20px;
        overflow-y: auto;
        display: flex;
        flex-direction: column;
        gap: 12px;
    }
    .message {
        max-width: 70%;
        padding: 10px 16px;
        border-radius: 20px;
        font-size: 13px;
    }
    .message.user {
        align-self: flex-start;
        background: var(--bg-primary);
        border: 1px solid var(--border);
        color: var(--text-primary);
    }
    .message.admin {
        align-self: flex-end;
        background: linear-gradient(135deg, var(--accent), #8b7355);
        color: #2c1810;
    }
    .message-time { font-size: 10px; opacity: 0.6; margin-top: 5px; display: block; }
    .chat-input-area {
        padding: 15px;
        border-top: 1px solid var(--border);
        display: flex;
        gap: 10px;
    }
    .chat-input {
        flex: 1;
        padding: 12px;
        border: 1px solid var(--border);
        border-radius: 30px;
        background: var(--bg-primary);
        color: var(--text-primary);
    }
    .chat-input:focus { outline: none; border-color: var(--accent); }
    .btn-send {
        background: var(--accent);
        border: none;
        padding: 0 24px;
        border-radius: 30px;
        color: #2c1810;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.3s;
    }
    .btn-send:hover { background: #8b7355; color: white; transform: scale(1.02); }
    .empty-chat {
        display: flex;
        align-items: center;
        justify-content: center;
        height: 100%;
        color: var(--text-secondary);
        flex-direction: column;
        gap: 10px;
    }
    @media (max-width: 768px) {
        .chat-container { flex-direction: column; height: auto; }
        .user-list { width: 100%; height: 250px; }
        .chat-area { min-height: 400px; }
    }
</style>
@endpush

@section('content')
<div class="chat-container">
    <div class="user-list">
        <div class="user-item" style="background: var(--accent-glow); font-weight: 600;">
            <span><i class="fas fa-users"></i> Daftar User</span>
        </div>
        @foreach($users as $user)
        <div class="user-item" data-id="{{ $user->id }}" data-name="{{ $user->name }}">
            <div>
                <div class="user-name">{{ $user->name }}</div>
                <div class="user-email">{{ $user->email }}</div>
            </div>
            @if(isset($user->unread_count) && $user->unread_count > 0)
            <span class="unread-badge">{{ $user->unread_count }}</span>
            @endif
        </div>
        @endforeach
        @if($users->count() == 0)
        <div style="padding: 20px; text-align: center; color: var(--text-secondary);">
            <i class="fas fa-comment-slash"></i>
            <p style="margin-top: 10px;">Belum ada chat dari user</p>
        </div>
        @endif
    </div>
    
    <div class="chat-area">
        <div class="chat-header" id="chatHeader">
            <i class="fas fa-comment"></i> Pilih user untuk memulai chat
        </div>
        <div class="chat-messages" id="chatMessages">
            <div class="empty-chat">
                <i class="fas fa-inbox" style="font-size: 48px; opacity: 0.5;"></i>
                <p>Pilih user di sebelah kiri untuk melihat pesan</p>
            </div>
        </div>
        <div class="chat-input-area" id="chatInputArea" style="display: none;">
            <input type="text" id="messageInput" class="chat-input" placeholder="Ketik pesan balasan...">
            <button class="btn-send" onclick="sendReply()"><i class="fas fa-paper-plane"></i> Kirim</button>
        </div>
    </div>
</div>

<script>
    let currentUserId = null;
    
    document.querySelectorAll('.user-item[data-id]').forEach(el => {
        el.addEventListener('click', function() {
            document.querySelectorAll('.user-item').forEach(e => e.classList.remove('active'));
            this.classList.add('active');
            currentUserId = this.dataset.id;
            document.getElementById('chatHeader').innerHTML = '<i class="fas fa-comment"></i> Chat dengan ' + this.dataset.name;
            document.getElementById('chatInputArea').style.display = 'flex';
            loadMessages(currentUserId);
        });
    });
    
    function loadMessages(userId) {
        fetch(`/admin/chats/messages/${userId}`)
            .then(res => res.json())
            .then(data => {
                const container = document.getElementById('chatMessages');
                container.innerHTML = '';
                if (data.messages.length === 0) {
                    container.innerHTML = '<div class="empty-chat"><i class="fas fa-comment-alt" style="font-size: 48px; opacity: 0.5;"></i><p>Belum ada pesan</p></div>';
                } else {
                    data.messages.forEach(msg => {
                        const div = document.createElement('div');
                        div.className = `message ${msg.sender}`;
                        div.innerHTML = `${msg.message}<span class="message-time">${new Date(msg.created_at).toLocaleString()}</span>`;
                        container.appendChild(div);
                    });
                }
                container.scrollTop = container.scrollHeight;
            });
    }
    
    function sendReply() {
        const message = document.getElementById('messageInput').value;
        if (!message || !currentUserId) return;
        
        fetch('{{ route("admin.chats.reply") }}', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': '{{ csrf_token() }}' },
            body: JSON.stringify({ user_id: currentUserId, message: message })
        }).then(() => {
            document.getElementById('messageInput').value = '';
            loadMessages(currentUserId);
        });
    }
    
    document.getElementById('messageInput')?.addEventListener('keypress', (e) => {
        if (e.key === 'Enter') sendReply();
    });
</script>
@endsection