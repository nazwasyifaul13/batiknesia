@extends('layouts.user')

@section('title', 'Scan QR Batik')

@push('styles')
<style>
    .qr-scanner-card {
        background: var(--bg-card);
        backdrop-filter: blur(12px);
        border-radius: 32px;
        padding: 32px;
        text-align: center;
        border: 1px solid var(--border);
    }
    #qr-reader {
        width: 100%;
        max-width: 500px;
        margin: 0 auto;
        border-radius: 24px;
        overflow: hidden;
    }
    #qr-reader video {
        border-radius: 24px;
        width: 100%;
    }
    .scanner-status {
        margin-top: 20px;
        padding: 15px;
        background: rgba(196,167,71,0.1);
        border-radius: 16px;
        color: var(--text-secondary);
    }
    .scanner-status i {
        color: var(--accent);
        margin-right: 8px;
    }
</style>
@endpush

@section('content')
<div class="page-header">
    <h1>Scan QR Code Batik</h1>
    <p>Arahkan kamera ke QR code pada tag batik untuk mendapatkan informasi lengkap</p>
    <div class="decorative-line"></div>
</div>

<div class="qr-scanner-card">
    <div id="qr-reader"></div>
    <div id="qr-result" style="display: none; margin-top: 20px; padding: 20px; background: rgba(196,167,71,0.1); border-radius: 16px;">
        <i class="fas fa-spinner fa-spin"></i> Memproses...
    </div>
    <div class="scanner-status">
        <i class="fas fa-info-circle"></i> Pastikan QR code berada dalam frame kamera
    </div>
</div>

<script src="https://unpkg.com/html5-qrcode@2.3.8/html5-qrcode.min.js"></script>
<script>
    const html5QrCode = new Html5Qrcode("qr-reader");
    let isScanning = true;
    
    const qrCodeSuccessCallback = (decodedText) => {
        if (!isScanning) return;
        isScanning = false;
        html5QrCode.stop();
        document.getElementById('qr-result').style.display = 'block';
        
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
            } else {
                Swal.fire({ icon: 'error', title: 'QR Tidak Valid', text: 'QR code tidak dikenali', confirmButtonColor: '#c4a747' });
                setTimeout(() => { startScanner(); isScanning = true; }, 2000);
            }
            document.getElementById('qr-result').style.display = 'none';
        });
    };
    
    function startScanner() {
        html5QrCode.start({ facingMode: "environment" }, { fps: 10, qrbox: 250 }, qrCodeSuccessCallback)
            .catch(err => Swal.fire({ icon: 'error', title: 'Error', text: 'Tidak dapat mengakses kamera', confirmButtonColor: '#c4a747' }));
    }
    
    startScanner();
</script>
@endsection