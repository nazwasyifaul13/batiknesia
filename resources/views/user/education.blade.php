@extends('layouts.user')

@section('title', 'Edukasi Batik')

@section('content')
<style>
    .hero-education {
        background: linear-gradient(135deg, var(--accent), #8b7355, #5c4033);
        border-radius: 32px;
        padding: 40px;
        margin-bottom: 40px;
        position: relative;
        overflow: hidden;
        text-align: center;
    }
    .hero-education::before {
        content: '';
        position: absolute;
        top: -30%;
        right: -10%;
        width: 250px;
        height: 250px;
        background: radial-gradient(circle, rgba(255,255,255,0.15), transparent);
        border-radius: 50%;
        animation: floatGlow 8s ease-in-out infinite;
    }
    .hero-education::after {
        content: '';
        position: absolute;
        bottom: -20%;
        left: -5%;
        width: 200px;
        height: 200px;
        background: radial-gradient(circle, rgba(255,255,255,0.1), transparent);
        border-radius: 50%;
        animation: floatGlow 6s ease-in-out infinite reverse;
    }
    @keyframes floatGlow {
        0%,100% { transform: translate(0,0) scale(1); opacity: 0.5; }
        50% { transform: translate(-20px, -20px) scale(1.1); opacity: 0.8; }
    }
    .hero-education h1 {
        font-family: 'Poppins', sans-serif;
        font-size: 32px;
        font-weight: 800;
        color: white;
        margin-bottom: 12px;
        position: relative;
        z-index: 1;
    }
    .hero-education p {
        color: rgba(255,255,255,0.9);
        font-size: 15px;
        position: relative;
        z-index: 1;
    }
    .hero-education .badge-date {
        background: rgba(255,255,255,0.2);
        backdrop-filter: blur(12px);
        padding: 8px 20px;
        border-radius: 50px;
        font-size: 12px;
        color: white;
        display: inline-flex;
        align-items: center;
        gap: 8px;
        margin-top: 20px;
    }

    /* Scanner Card */
    .scanner-card {
        background: var(--bg-card);
        backdrop-filter: blur(12px);
        border-radius: 28px;
        padding: 28px;
        margin-bottom: 40px;
        border: 1px solid var(--border);
        transition: all 0.3s;
        text-align: center;
    }
    .scanner-card h3 {
        font-size: 22px;
        font-weight: 700;
        margin-bottom: 10px;
        color: var(--text-primary);
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 10px;
    }
    .scanner-card h3 i { color: var(--accent); font-size: 28px; }
    .scanner-card p { color: var(--text-secondary); font-size: 14px; margin-bottom: 20px; }
    #qr-reader { width: 100%; max-width: 500px; margin: 0 auto; border-radius: 20px; overflow: hidden; }
    #qr-reader video { border-radius: 20px; width: 100%; }
    .scanner-status {
        margin-top: 15px;
        padding: 12px;
        background: rgba(196,167,71,0.1);
        border-radius: 16px;
        font-size: 13px;
        color: var(--text-secondary);
    }
    .scanner-buttons {
        display: flex;
        gap: 12px;
        justify-content: center;
        margin-top: 15px;
        flex-wrap: wrap;
    }
    .btn-scanner {
        padding: 10px 20px;
        border-radius: 40px;
        font-weight: 600;
        font-size: 13px;
        cursor: pointer;
        transition: all 0.3s;
        border: none;
    }
    .btn-scanner-start {
        background: linear-gradient(135deg, var(--accent), #8b7355);
        color: #2c1810;
    }
    .btn-scanner-start:hover { transform: translateY(-2px); box-shadow: 0 5px 15px rgba(196,167,71,0.4); color: white; }
    .btn-scanner-stop {
        background: #dc2626;
        color: white;
    }
    .btn-scanner-stop:hover { transform: translateY(-2px); background: #b91c1c; }
    .btn-scanner-capture {
        background: #3b82f6;
        color: white;
    }
    .btn-scanner-capture:hover { transform: translateY(-2px); background: #2563eb; }
    .qr-scan-result {
        margin-top: 20px;
        padding: 15px;
        background: rgba(196,167,71,0.08);
        border-radius: 16px;
        display: none;
    }

    /* Education Grid */
    .education-grid {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 28px;
        margin-bottom: 40px;
    }
    .education-card {
        background: var(--bg-card);
        backdrop-filter: blur(12px);
        border-radius: 24px;
        overflow: hidden;
        border: 1px solid var(--border);
        transition: all 0.4s cubic-bezier(0.2, 0.9, 0.4, 1.1);
    }
    .education-card:hover {
        transform: translateY(-8px);
        box-shadow: 0 20px 40px rgba(0,0,0,0.1);
    }
    .education-img {
        height: 200px;
        background: linear-gradient(145deg, var(--accent-light), rgba(196,167,71,0.05));
        display: flex;
        align-items: center;
        justify-content: center;
        overflow: hidden;
        position: relative;
    }
    .education-img img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: transform 0.5s;
    }
    .education-card:hover .education-img img {
        transform: scale(1.05);
    }
    .education-img i {
        font-size: 55px;
        color: var(--accent);
    }
    .education-content {
        padding: 22px;
    }
    .education-title {
        font-family: 'Poppins', sans-serif;
        font-size: 18px;
        font-weight: 700;
        margin-bottom: 10px;
        color: var(--text-primary);
    }
    .education-desc {
        font-size: 13px;
        color: var(--text-secondary);
        line-height: 1.6;
        margin-bottom: 15px;
    }
    
    /* QR Code Section pada setiap card */
    .qr-section {
        display: flex;
        align-items: center;
        gap: 12px;
        padding: 12px;
        background: rgba(196,167,71,0.08);
        border-radius: 16px;
        margin: 15px 0;
    }
    .qr-code-img {
        width: 45px;
        height: 45px;
        cursor: pointer;
        border-radius: 10px;
        transition: all 0.2s;
        background: white;
        padding: 5px;
    }
    .qr-code-img:hover {
        transform: scale(1.05);
        box-shadow: 0 0 10px rgba(196,167,71,0.5);
    }
    .qr-text {
        font-size: 11px;
        color: var(--text-secondary);
        flex: 1;
    }
    .btn-scan-qr {
        background: none;
        border: none;
        color: var(--accent);
        cursor: pointer;
        font-size: 18px;
        transition: all 0.2s;
    }
    .btn-scan-qr:hover {
        transform: scale(1.1);
    }
    
    .btn-read {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        background: linear-gradient(135deg, var(--accent), #8b7355);
        color: #2c1810;
        padding: 10px 24px;
        border-radius: 40px;
        font-size: 13px;
        font-weight: 600;
        text-decoration: none;
        transition: all 0.3s;
        width: 100%;
        justify-content: center;
    }
    .btn-read:hover {
        transform: translateY(-2px);
        gap: 12px;
        box-shadow: 0 8px 20px rgba(196,167,71,0.4);
        color: white;
    }

    /* QR Modal */
    .qr-modal {
        display: none;
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: rgba(0,0,0,0.85);
        z-index: 1000;
        justify-content: center;
        align-items: center;
    }
    .qr-modal-content {
        background: var(--bg-card);
        border-radius: 28px;
        padding: 30px;
        max-width: 380px;
        width: 90%;
        text-align: center;
        position: relative;
        animation: modalFadeIn 0.3s ease;
    }
    @keyframes modalFadeIn {
        from { opacity: 0; transform: scale(0.9); }
        to { opacity: 1; transform: scale(1); }
    }
    .qr-modal-close {
        position: absolute;
        top: 15px;
        right: 20px;
        font-size: 28px;
        cursor: pointer;
        color: var(--text-secondary);
        transition: all 0.2s;
    }
    .qr-modal-close:hover { color: var(--accent); }
    .qr-modal-title {
        font-family: 'Poppins', sans-serif;
        font-size: 20px;
        font-weight: 700;
        color: var(--text-primary);
        margin-bottom: 20px;
    }
    .qr-modal-image {
        width: 200px;
        height: 200px;
        margin: 0 auto 20px;
        display: block;
        background: white;
        padding: 10px;
        border-radius: 16px;
    }
    .qr-modal-text {
        color: var(--text-secondary);
        font-size: 13px;
        margin: 15px 0;
        line-height: 1.5;
    }
    .qr-download-btn {
        display: inline-block;
        background: linear-gradient(135deg, var(--accent), #8b7355);
        color: #2c1810;
        padding: 10px 24px;
        border-radius: 40px;
        text-decoration: none;
        font-weight: 600;
        margin-top: 10px;
        transition: all 0.2s;
    }
    .qr-download-btn:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 20px rgba(196,167,71,0.4);
        color: white;
    }

    /* Pagination */
    .pagination-wrapper {
        display: flex;
        justify-content: center;
        margin-top: 20px;
    }
    .pagination .page-item .page-link {
        background: var(--bg-card);
        border: 1px solid var(--border);
        color: var(--text-primary);
        border-radius: 12px;
        margin: 0 4px;
        padding: 8px 14px;
        transition: all 0.3s;
    }
    .pagination .page-item.active .page-link {
        background: var(--accent);
        border-color: var(--accent);
        color: #2c1810;
    }
    .pagination .page-item .page-link:hover {
        background: var(--accent);
        color: #2c1810;
        transform: translateY(-2px);
    }

    /* Empty State */
    .empty-state {
        text-align: center;
        padding: 60px;
        background: var(--bg-card);
        border-radius: 28px;
        border: 1px solid var(--border);
    }
    .empty-state i {
        font-size: 55px;
        color: var(--accent);
        margin-bottom: 15px;
        opacity: 0.5;
    }

    @media (max-width: 1024px) {
        .education-grid { grid-template-columns: repeat(2, 1fr); gap: 20px; }
    }
    @media (max-width: 768px) {
        .education-grid { grid-template-columns: 1fr; }
        .hero-education { padding: 30px; }
        .hero-education h1 { font-size: 24px; }
    }
</style>

<div class="hero-education">
    <h1>Edukasi Batik Nusantara</h1>
    <p>Pelajari sejarah, filosofi, dan makna di balik setiap motif batik</p>
    <div class="badge-date">
        <i class="fas fa-calendar-alt"></i> {{ now()->translatedFormat('l, d F Y') }}
    </div>
</div>

<!-- WEBCAM QR SCANNER -->
<div class="scanner-card">
    <h3><i class="fas fa-qrcode"></i> Scan QR Code Batik</h3>
    <p>Arahkan kamera ke QR code pada tag batik untuk mendapatkan informasi lengkap</p>
    <div id="qr-reader"></div>
    <div id="qr-scan-result" class="qr-scan-result">
        <i class="fas fa-spinner fa-spin"></i> Memproses...
    </div>
    <div class="scanner-buttons">
        <button id="btn-start-cam" class="btn-scanner btn-scanner-start"><i class="fas fa-play"></i> Start Camera</button>
        <button id="btn-stop-cam" class="btn-scanner btn-scanner-stop" style="display: none;"><i class="fas fa-stop"></i> Stop Camera</button>
        <button id="btn-capture" class="btn-scanner btn-scanner-capture" style="display: none;"><i class="fas fa-camera"></i> Ambil Foto</button>
    </div>
    <div class="scanner-status">
        <i class="fas fa-info-circle"></i> Pastikan QR code berada dalam frame kamera
    </div>
</div>

<div class="education-grid">
    @forelse($articles ?? [] as $article)
    <div class="education-card">
        <div class="education-img">
            @if($article->image && file_exists(public_path($article->image)))
                <img src="{{ asset($article->image) }}" alt="{{ $article->title }}">
            @else
                <i class="fas fa-palette"></i>
            @endif
        </div>
        <div class="education-content">
            <h3 class="education-title">{{ $article->title }}</h3>
            <p class="education-desc">{{ Str::limit($article->description ?? $article->content ?? 'Pelajari lebih lanjut tentang keindahan batik Nusantara', 100) }}</p>
            
            <div class="qr-section">
                <img src="https://api.qrserver.com/v1/create-qr-code/?size=100x100&data={{ urlencode(route('user.education.detail', $article->id)) }}" 
                     class="qr-code-img" 
                     onclick="openQRModal('{{ route('user.education.detail', $article->id) }}', '{{ $article->title }}')">
                <div class="qr-text">
                    <i class="fas fa-qrcode"></i> Scan QR untuk akses artikel
                </div>
                <button class="btn-scan-qr" onclick="openQRModal('{{ route('user.education.detail', $article->id) }}', '{{ $article->title }}')">
                    <i class="fas fa-expand"></i>
                </button>
            </div>
            
            <a href="{{ route('user.education.detail', $article->id) }}" class="btn-read">
                Baca Selengkapnya <i class="fas fa-arrow-right"></i>
            </a>
        </div>
    </div>
    @empty
    <div class="empty-state">
        <i class="fas fa-book-open"></i>
        <p>Belum ada artikel edukasi.</p>
        <p style="font-size: 12px; margin-top: 8px;">Artikel akan segera ditambahkan</p>
    </div>
    @endforelse
</div>

@if(isset($articles) && method_exists($articles, 'links'))
<div class="pagination-wrapper">
    {{ $articles->links() }}
</div>
@endif

<!-- QR Modal -->
<div id="qrModal" class="qr-modal">
    <div class="qr-modal-content">
        <span class="qr-modal-close" onclick="closeQRModal()">&times;</span>
        <h3 class="qr-modal-title" id="qrModalTitle">QR Code Artikel</h3>
        <img id="qrModalImage" class="qr-modal-image" src="" alt="QR Code">
        <p class="qr-modal-text">
            <i class="fas fa-camera"></i> Scan QR code dengan kamera ponsel Anda<br>
            untuk langsung membaca artikel ini di perangkat mobile.
        </p>
        <a id="qrDownloadLink" href="#" download="qrcode.png" class="qr-download-btn">
            <i class="fas fa-download"></i> Download QR Code
        </a>
    </div>
</div>

<script src="https://unpkg.com/html5-qrcode@2.3.8/html5-qrcode.min.js"></script>
<script>
    let html5QrCode;
    let isScannerRunning = false;
    let currentStream = null;
    
    // Elemen
    const btnStart = document.getElementById('btn-start-cam');
    const btnStop = document.getElementById('btn-stop-cam');
    const btnCapture = document.getElementById('btn-capture');
    const qrReaderDiv = document.getElementById('qr-reader');
    const scanResultDiv = document.getElementById('qr-scan-result');
    
    // Start Camera
    btnStart.addEventListener('click', async () => {
        try {
            // Request camera permission
            const stream = await navigator.mediaDevices.getUserMedia({ video: { facingMode: "environment" } });
            currentStream = stream;
            
            // Initialize Html5Qrcode
            html5QrCode = new Html5Qrcode("qr-reader");
            await html5QrCode.start({ facingMode: "environment" }, { fps: 10, qrbox: 250 }, onQrCodeSuccess);
            
            isScannerRunning = true;
            btnStart.style.display = 'none';
            btnStop.style.display = 'inline-flex';
            btnCapture.style.display = 'inline-flex';
        } catch (err) {
            Swal.fire({ icon: 'error', title: 'Error', text: 'Tidak dapat mengakses kamera: ' + err.message, confirmButtonColor: '#c4a747' });
        }
    });
    
    // Stop Camera
    btnStop.addEventListener('click', async () => {
        if (html5QrCode && isScannerRunning) {
            await html5QrCode.stop();
            if (currentStream) {
                currentStream.getTracks().forEach(track => track.stop());
                currentStream = null;
            }
            isScannerRunning = false;
            btnStart.style.display = 'inline-flex';
            btnStop.style.display = 'none';
            btnCapture.style.display = 'none';
        }
    });
    
    // Ambil Foto (Capture)
    btnCapture.addEventListener('click', () => {
        const videoElement = document.querySelector('#qr-reader video');
        if (videoElement && videoElement.videoWidth > 0) {
            const canvas = document.createElement('canvas');
            canvas.width = videoElement.videoWidth;
            canvas.height = videoElement.videoHeight;
            canvas.getContext('2d').drawImage(videoElement, 0, 0, canvas.width, canvas.height);
            
            // Save image
            const link = document.createElement('a');
            link.download = 'qr-capture-' + Date.now() + '.png';
            link.href = canvas.toDataURL('image/png');
            link.click();
            
            Swal.fire({ icon: 'success', title: 'Foto Tersimpan', text: 'Gambar berhasil disimpan', confirmButtonColor: '#c4a747', timer: 1500, showConfirmButton: false });
        } else {
            Swal.fire({ icon: 'warning', title: 'Tidak Ada Gambar', text: 'Pastikan kamera sudah menyala', confirmButtonColor: '#c4a747' });
        }
    });
    
    // Callback QR Code Success
    const onQrCodeSuccess = (decodedText) => {
        if (!isScannerRunning) return;
        
        // Stop scanner temporarily
        if (html5QrCode) html5QrCode.stop();
        isScannerRunning = false;
        scanResultDiv.style.display = 'block';
        
        fetch('{{ route("user.qr.process") }}', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': '{{ csrf_token() }}' },
            body: JSON.stringify({ code: decodedText })
        })
        .then(res => res.json())
        .then(data => {
            if (data.success) {
                Swal.fire({ icon: 'success', title: data.title, text: 'Membuka halaman...', confirmButtonColor: '#c4a747', timer: 1500, showConfirmButton: false });
                setTimeout(() => window.open(data.url, '_blank'), 1500);
                // Restart scanner after 3 seconds
                setTimeout(() => restartScanner(), 3000);
            } else {
                Swal.fire({ icon: 'error', title: 'QR Tidak Valid', text: 'QR code tidak dikenali', confirmButtonColor: '#c4a747' });
                setTimeout(() => restartScanner(), 2000);
            }
            scanResultDiv.style.display = 'none';
        });
    };
    
    function restartScanner() {
        if (!isScannerRunning && html5QrCode) {
            html5QrCode.start({ facingMode: "environment" }, { fps: 10, qrbox: 250 }, onQrCodeSuccess)
                .then(() => { isScannerRunning = true; })
                .catch(err => console.error(err));
        }
    }
    
    // QR Modal Functions
    function openQRModal(url, title) {
        const qrUrl = `https://api.qrserver.com/v1/create-qr-code/?size=200x200&data=${encodeURIComponent(url)}`;
        document.getElementById('qrModalTitle').innerHTML = title;
        document.getElementById('qrModalImage').src = qrUrl;
        document.getElementById('qrDownloadLink').href = qrUrl;
        document.getElementById('qrModal').style.display = 'flex';
        document.body.style.overflow = 'hidden';
    }
    
    function closeQRModal() {
        document.getElementById('qrModal').style.display = 'none';
        document.body.style.overflow = 'auto';
    }
    
    document.getElementById('qrModal').addEventListener('click', function(e) {
        if (e.target === this) closeQRModal();
    });
</script>

@if(session('success'))
<script>
    Swal.fire({ icon: 'success', title: 'Berhasil!', text: '{{ session('success') }}', confirmButtonColor: '#c4a747' });
</script>
@endif
@endsection