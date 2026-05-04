@extends('layouts.user')

@section('title', 'Scan QR Batik')

@push('styles')
<style>
    #qr-reader { width: 100%; max-width: 500px; margin: 0 auto; border-radius: 20px; overflow: hidden; }
    #qr-reader video { border-radius: 20px; }
    .result-card { background: var(--card); border-radius: 20px; padding: 20px; margin-top: 20px; }
</style>
@endpush

@section('content')
<div class="container-fluid">
    <div class="card-dashboard p-4 mb-4 text-center">
        <h3><i class="fas fa-qrcode text-accent me-2"></i>Scan QR Code pada Tag Batik</h3>
        <p class="text-muted">Arahkan kamera ke QR code pada tag batik untuk mendapatkan informasi lengkap tentang motif tersebut</p>
    </div>

    <div class="row">
        <div class="col-md-6 mx-auto">
            <div class="card-dashboard p-4">
                <div id="qr-reader"></div>
                <div id="qr-result" class="result-card text-center" style="display: none;">
                    <i class="fas fa-spinner fa-spin fa-2x text-accent mb-3"></i>
                    <h5>Memuat informasi batik...</h5>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
    const html5QrCode = new Html5Qrcode("qr-reader");
    const qrCodeSuccessCallback = (decodedText, decodedResult) => {
        html5QrCode.stop();
        document.getElementById('qr-result').style.display = 'block';
        
        // Redirect atau tampilkan konten berdasarkan QR code
        fetch('/user/qr/scan', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': '{{ csrf_token() }}' },
            body: JSON.stringify({ code: decodedText })
        })
        .then(res => res.json())
        .then(data => {
            if (data.type === 'article') {
                Swal.fire({ icon: 'success', title: data.title, text: 'Membuka artikel...', confirmButtonColor: '#c9a03d' });
                setTimeout(() => window.open(data.url, '_blank'), 1500);
            } else if (data.type === 'youtube') {
                Swal.fire({ icon: 'info', title: 'Video YouTube', text: 'Memutar video edukasi...', confirmButtonColor: '#c9a03d' });
                setTimeout(() => window.open(data.url, '_blank'), 1500);
            } else {
                Swal.fire({ icon: 'error', title: 'QR Tidak Valid', text: 'QR code tidak dikenali', confirmButtonColor: '#c9a03d' });
            }
            html5QrCode.start({ facingMode: "environment" }, { fps: 10, qrbox: 250 }, qrCodeSuccessCallback);
            document.getElementById('qr-result').style.display = 'none';
        });
    };
    
    html5QrCode.start({ facingMode: "environment" }, { fps: 10, qrbox: 250 }, qrCodeSuccessCallback)
        .catch(err => Swal.fire({ icon: 'error', title: 'Error', text: 'Tidak dapat mengakses kamera', confirmButtonColor: '#c9a03d' }));
</script>
@endpush
@endsection