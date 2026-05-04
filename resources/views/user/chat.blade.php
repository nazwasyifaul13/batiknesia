@extends('layouts.user')

@section('title', 'Chat Admin')

@section('content')
<style>
    .chat-page-container {
        background: var(--bg-card);
        backdrop-filter: blur(12px);
        border-radius: 28px;
        border: 1px solid var(--border);
        overflow: hidden;
        height: 70vh;
        display: flex;
        flex-direction: column;
    }
    .chat-page-header {
        background: linear-gradient(135deg, var(--accent), #8b7355);
        padding: 18px 24px;
    }
    .chat-page-header h2 {
        color: white;
        margin: 0;
        font-size: 20px;
        font-weight: 700;
    }
    .chat-page-header p {
        color: rgba(255,255,255,0.85);
        margin: 5px 0 0;
        font-size: 13px;
    }
    .chat-page-messages {
        flex: 1;
        padding: 20px;
        overflow-y: auto;
        display: flex;
        flex-direction: column;
        gap: 12px;
        background: var(--bg-primary);
    }
    .chat-page-message {
        max-width: 70%;
        padding: 12px 18px;
        border-radius: 20px;
        font-size: 14px;
        line-height: 1.4;
    }
    .chat-page-message.user {
        align-self: flex-end;
        background: linear-gradient(135deg, var(--accent), #8b7355);
        color: #2c1810;
        border-bottom-right-radius: 5px;
    }
    .chat-page-message.admin {
        align-self: flex-start;
        background: var(--bg-card);
        border: 1px solid var(--border);
        color: var(--text-primary);
        border-bottom-left-radius: 5px;
    }
    .chat-page-time {
        font-size: 10px;
        opacity: 0.6;
        margin-top: 5px;
        display: block;
    }
    .chat-page-input {
        padding: 16px 20px;
        border-top: 1px solid var(--border);
        background: var(--bg-card);
        display: flex;
        gap: 12px;
    }
    .chat-page-input input {
        flex: 1;
        padding: 12px 18px;
        border: 1px solid var(--border);
        border-radius: 40px;
        background: var(--bg-primary);
        color: var(--text-primary);
        font-size: 14px;
    }
    .chat-page-input input:focus {
        outline: none;
        border-color: var(--accent);
    }
    .chat-page-input button {
        background: var(--accent);
        border: none;
        padding: 0 24px;
        border-radius: 40px;
        color: #2c1810;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.3s;
    }
    .chat-page-input button:hover {
        background: #8b7355;
        color: white;
        transform: translateY(-2px);
    }
    @media (max-width: 768px) {
        .chat-page-message { max-width: 85%; font-size: 12px; }
    }
</style>

<div class="page-header">
    <h1>Chat dengan Admin</h1>
    <p>Diskusikan pesanan atau pertanyaan Anda di sini</p>
    <div class="decorative-line"></div>
</div>

<div class="chat-page-container">
    <div class="chat-page-header">
        <h2><i class="fas fa-headset"></i> Batiknesia Support</h2>
        <p>Admin akan merespon pesan Anda sesegera mungkin</p>
    </div>
    
    <div class="chat-page-messages" id="chatPageMessages">
        @foreach($messages as $message)
        <div class="chat-page-message {{ $message->sender_id == Auth::id() ? 'user' : 'admin' }}">
            {{ $message->message }}
            <span class="chat-page-time">{{ $message->created_at->format('H:i') }}</span>
        </div>
        @endforeach
        <div id="loadingMessages" style="display: none; text-align: center;"><i class="fas fa-spinner fa-spin"></i> Loading...</div>
    </div>
    
    <div class="chat-page-input">
        <input type="text" id="chatPageInput" placeholder="Ketik pesan...">
        <button onclick="sendPageMessage()"><i class="fas fa-paper-plane"></i> Kirim</button>
    </div>
</div>

<script>
    const messagesContainer = document.getElementById('chatPageMessages');
    let lastPageChatId = {{ $lastId ?? 0 }};
    
    function scrollToBottom() {
        messagesContainer.scrollTop = messagesContainer.scrollHeight;
    }
    scrollToBottom();
    
    function sendPageMessage() {
        const input = document.getElementById('chatPageInput');
        const message = input.value.trim();
        if (!message) return;
        
        // Append user message immediately
        const userMsgDiv = document.createElement('div');
        userMsgDiv.className = 'chat-page-message user';
        userMsgDiv.innerHTML = `${message}<span class="chat-page-time">${new Date().toLocaleTimeString([], {hour:'2-digit', minute:'2-digit'})}</span>`;
        messagesContainer.appendChild(userMsgDiv);
        input.value = '';
        scrollToBottom();
        
        fetch('{{ route("user.chat.send") }}', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': '{{ csrf_token() }}' },
            body: JSON.stringify({ message: message })
        }).catch(err => console.error(err));
    }
    
    // Polling for new messages
    setInterval(() => {
        fetch('{{ route("user.chat.messages") }}?last_id=' + lastPageChatId)
            .then(res => res.json())
            .then(data => {
                if (data.messages && data.messages.length > 0) {
                    data.messages.forEach(msg => {
                        if (msg.id > lastPageChatId) {
                            const msgDiv = document.createElement('div');
                            msgDiv.className = `chat-page-message ${msg.sender === 'admin' ? 'admin' : 'user'}`;
                            msgDiv.innerHTML = `${msg.message}<span class="chat-page-time">${new Date(msg.created_at).toLocaleTimeString([], {hour:'2-digit', minute:'2-digit'})}</span>`;
                            messagesContainer.appendChild(msgDiv);
                            lastPageChatId = msg.id;
                        }
                    });
                    scrollToBottom();
                }
            });
    }, 3000);
    
    document.getElementById('chatPageInput').addEventListener('keypress', (e) => {
        if (e.key === 'Enter') sendPageMessage();
    });
</script>
@endsection