@extends('layouts.user')

@section('title', 'Virtual Try On')

@section('content')
@php
    use App\Models\Product;
    $sliderProducts = Product::where('is_active', 1)->latest()->take(6)->get();
@endphp

<x-hero-section 
    title="Virtual Try On" 
    subtitle="Batik" 
    :products="$sliderProducts" 
/>

<style>
    .tryon-container {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 28px;
        margin-bottom: 30px;
    }
    .tryon-card {
        background: var(--bg-card);
        backdrop-filter: blur(12px);
        border-radius: 28px;
        padding: 28px;
        border: 1px solid var(--border);
        transition: all 0.3s;
        box-shadow: var(--shadow);
    }
    .tryon-card:hover {
        transform: translateY(-5px);
        box-shadow: var(--shadow-hover);
    }
    .tryon-card h3 {
        font-size: 20px;
        font-weight: 700;
        margin-bottom: 20px;
        display: flex;
        align-items: center;
        gap: 10px;
        color: var(--text-primary);
    }
    .tryon-card h3 i {
        color: var(--accent);
        font-size: 24px;
    }

    /* UPLOAD AREA */
    .upload-main {
        border: 2px dashed var(--border);
        border-radius: 20px;
        padding: 50px 25px;
        text-align: center;
        cursor: pointer;
        transition: all 0.3s;
        margin-bottom: 20px;
        background: var(--accent-glow);
    }
    .upload-main:hover {
        border-color: var(--accent);
        background: rgba(184,134,11,0.1);
    }
    .upload-main i {
        font-size: 52px;
        color: var(--accent);
        margin-bottom: 15px;
    }
    .upload-main p {
        font-size: 14px;
        color: var(--text-secondary);
    }

    .btn-camera {
        background: linear-gradient(135deg, var(--accent), #8b7355);
        border: none;
        padding: 12px 24px;
        border-radius: 40px;
        color: #2c1810;
        font-weight: 600;
        font-size: 14px;
        cursor: pointer;
        transition: all 0.3s;
        display: inline-flex;
        align-items: center;
        gap: 8px;
        width: 100%;
        justify-content: center;
        margin-bottom: 20px;
    }
    .btn-camera:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 20px var(--accent-glow);
        color: white;
    }

    .motif-select {
        width: 100%;
        padding: 14px 18px;
        border-radius: 50px;
        border: 1.5px solid var(--border);
        background: var(--bg-card);
        color: var(--text-primary);
        font-size: 14px;
        margin-bottom: 20px;
        cursor: pointer;
    }
    .motif-select:focus {
        outline: none;
        border-color: var(--accent);
        box-shadow: 0 0 0 3px var(--accent-glow);
    }

    .result-image {
        width: 100%;
        border-radius: 20px;
        margin-bottom: 20px;
        border: 2px solid var(--accent);
        box-shadow: 0 8px 25px rgba(0,0,0,0.1);
    }
    .result-recommendation {
        background: var(--accent-glow);
        border-radius: 16px;
        padding: 18px;
        text-align: center;
        font-size: 14px;
        color: var(--text-primary);
        border-left: 3px solid var(--accent);
    }
    .result-actions {
        display: flex;
        gap: 12px;
        margin-top: 20px;
    }
    .btn-download, .btn-reset {
        flex: 1;
        padding: 12px;
        border-radius: 40px;
        font-weight: 600;
        font-size: 14px;
        cursor: pointer;
        transition: all 0.3s;
        text-align: center;
    }
    .btn-download {
        background: linear-gradient(135deg, var(--accent), #8b7355);
        color: white;
        border: none;
    }
    .btn-download:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 20px var(--accent-glow);
    }
    .btn-reset {
        background: transparent;
        border: 1.5px solid var(--accent);
        color: var(--text-primary);
    }
    .btn-reset:hover {
        background: var(--accent-glow);
        transform: translateY(-2px);
    }

    .empty-result {
        text-align: center;
        padding: 60px 20px;
        background: var(--accent-glow);
        border-radius: 20px;
    }
    .empty-result i {
        font-size: 64px;
        color: var(--accent);
        margin-bottom: 20px;
        display: block;
        opacity: 0.5;
    }

    .history-card {
        background: var(--bg-card);
        backdrop-filter: blur(12px);
        border-radius: 28px;
        padding: 28px;
        border: 1px solid var(--border);
        margin-top: 28px;
        box-shadow: var(--shadow);
    }
    .history-card h3 {
        font-size: 20px;
        font-weight: 700;
        margin-bottom: 20px;
        display: flex;
        align-items: center;
        gap: 10px;
        color: var(--text-primary);
    }
    .history-card h3 i {
        color: var(--accent);
        font-size: 24px;
    }
    .history-grid {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: 16px;
    }
    .history-item {
        text-align: center;
    }
    .history-item img {
        width: 100%;
        height: 100px;
        object-fit: cover;
        border-radius: 16px;
        border: 1px solid var(--border);
    }
    .history-item p {
        font-size: 11px;
        margin-top: 8px;
        color: var(--text-secondary);
    }

    .info-box {
        background: var(--accent-glow);
        border-radius: 16px;
        padding: 14px;
        margin-top: 20px;
        text-align: center;
        border-left: 3px solid var(--accent);
    }
    .info-box i {
        color: var(--accent);
        margin-right: 8px;
    }

    /* MODAL CAMERA */
    .camera-modal {
        display: none;
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: rgba(0,0,0,0.95);
        z-index: 1000;
        justify-content: center;
        align-items: center;
    }
    .camera-modal-content {
        background: var(--bg-card);
        border-radius: 28px;
        padding: 24px;
        max-width: 500px;
        width: 90%;
        text-align: center;
    }
    .camera-modal-content video {
        width: 100%;
        border-radius: 16px;
        background: #1a1a2e;
        margin-bottom: 15px;
    }
    .camera-modal-content canvas {
        width: 100%;
        border-radius: 16px;
        display: none;
        margin-bottom: 15px;
    }
    .camera-buttons {
        display: flex;
        gap: 12px;
        justify-content: center;
        margin-top: 15px;
    }
    @media (max-width: 768px) {
        .camera-buttons { flex-direction: column; }
    }
</style>

<div class="tryon-container">
    <div class="tryon-card">
        <h3><i class="fas fa-upload"></i> Langkah 1: Upload Foto</h3>
        
        <!-- Upload Area -->
        <div class="upload-main" onclick="document.getElementById('fileUpload').click()">
            <i class="fas fa-cloud-upload-alt"></i>
            <p>Klik untuk upload foto dari galeri</p>
            <p style="font-size: 11px; margin-top: 5px;">Format: JPG, PNG (Max 5MB)</p>
            <input type="file" id="fileUpload" accept="image/*" style="display:none;">
        </div>
        
        <!-- Tombol Kamera -->
        <button class="btn-camera" onclick="openCamera()">
            <i class="fas fa-camera"></i> Atau Ambil Foto dengan Kamera
        </button>
        
        <div class="info-box">
            <i class="fas fa-lightbulb"></i>
            <p>Gunakan foto dengan pencahayaan yang baik dan posisi menghadap kamera</p>
        </div>
        
        <h3><i class="fas fa-palette"></i> Langkah 2: Pilih Motif Batik</h3>
        <select id="motifSelect" class="motif-select">
            <option value="">-- Pilih Motif Batik --</option>
            @foreach($motifs as $motif)
            <option value="{{ $motif->id }}" data-name="{{ $motif->name }}">{{ $motif->name }} - {{ $motif->origin ?? 'Nusantara' }}</option>
            @endforeach
        </select>
        
        <button id="tryOnBtn" onclick="processTryOn()" class="btn-primary" style="width:100%; margin-top:10px; display:none;">
            <i class="fas fa-magic"></i> Coba Motif Ini
        </button>
    </div>
    
    <div class="tryon-card">
        <h3><i class="fas fa-star"></i> Langkah 3: Hasil Try On</h3>
        <div id="resultContainer" style="display:none;">
            <img id="resultImage" class="result-image" src="">
            <div id="resultRecommendation" class="result-recommendation"></div>
            <div class="result-actions">
                <button onclick="downloadResult()" class="btn-download"><i class="fas fa-download"></i> Simpan Hasil</button>
                <button onclick="resetTryOn()" class="btn-reset"><i class="fas fa-redo-alt"></i> Coba Lagi</button>
            </div>
        </div>
        <div id="emptyResult" class="empty-result">
            <i class="fas fa-tshirt"></i>
            <p>Upload foto, pilih motif, lalu klik "Coba Motif Ini"</p>
        </div>
    </div>
</div>

@if(isset($tryOnHistory) && $tryOnHistory->count() > 0)
<div class="history-card">
    <h3><i class="fas fa-history"></i> Riwayat Try On</h3>
    <div class="history-grid">
        @foreach($tryOnHistory->take(4) as $session)
        <div class="history-item">
            @if($session->generated_image)
                <img src="{{ asset($session->generated_image) }}" alt="Try On Result">
            @else
                <div style="height:100px; background:var(--accent-glow); border-radius:16px; display:flex; align-items:center; justify-content:center;">
                    <i class="fas fa-image" style="color: var(--accent); font-size: 24px;"></i>
                </div>
            @endif
            <p>{{ $session->created_at->format('d M Y') }}</p>
        </div>
        @endforeach
    </div>
</div>
@endif

<!-- MODAL CAMERA -->
<div id="cameraModal" class="camera-modal">
    <div class="camera-modal-content">
        <h3 style="margin-bottom: 15px;"><i class="fas fa-camera"></i> Ambil Foto</h3>
        <video id="modalVideo" autoplay playsinline></video>
        <canvas id="modalCanvas"></canvas>
        <div class="camera-buttons">
            <button id="captureModalBtn" class="btn-primary" style="flex:1"><i class="fas fa-camera"></i> Ambil Foto</button>
            <button id="closeModalBtn" class="btn-secondary" style="flex:1"><i class="fas fa-times"></i> Tutup</button>
        </div>
        <button id="retakeModalBtn" class="btn-secondary" style="display:none; width:100%; margin-top:10px;"><i class="fas fa-redo-alt"></i> Ambil Ulang</button>
        <button id="useModalBtn" class="btn-primary" style="display:none; width:100%; margin-top:10px;"><i class="fas fa-check"></i> Gunakan Foto Ini</button>
    </div>
</div>

<script>
let capturedImageBlob = null;
let capturedImageUrl = null;
let currentMotifId = null;
let currentMotifName = null;

// Modal Camera Elements
const modal = document.getElementById('cameraModal');
const modalVideo = document.getElementById('modalVideo');
const modalCanvas = document.getElementById('modalCanvas');
const captureBtn = document.getElementById('captureModalBtn');
const closeBtn = document.getElementById('closeModalBtn');
const retakeBtn = document.getElementById('retakeModalBtn');
const useBtn = document.getElementById('useModalBtn');
let modalStream = null;

// Buka modal kamera
function openCamera() {
    modal.style.display = 'flex';
    startModalCamera();
}

// Start camera di modal
async function startModalCamera() {
    try {
        if (modalStream) {
            modalStream.getTracks().forEach(track => track.stop());
        }
        const stream = await navigator.mediaDevices.getUserMedia({ 
            video: { facingMode: "user" } 
        });
        modalStream = stream;
        modalVideo.srcObject = stream;
        modalVideo.style.display = 'block';
        modalCanvas.style.display = 'none';
        captureBtn.style.display = 'block';
        retakeBtn.style.display = 'none';
        useBtn.style.display = 'none';
        await modalVideo.play();
    } catch (err) {
        Swal.fire({ 
            icon: 'error', 
            title: 'Gagal', 
            text: 'Tidak dapat mengakses kamera: ' + err.message,
            confirmButtonColor: '#b8860b'
        });
        closeModalCamera();
    }
}

// Capture foto
captureBtn.onclick = () => {
    const context = modalCanvas.getContext('2d');
    modalCanvas.width = modalVideo.videoWidth;
    modalCanvas.height = modalVideo.videoHeight;
    // Mirror image untuk selfie
    context.translate(modalCanvas.width, 0);
    context.scale(-1, 1);
    context.drawImage(modalVideo, 0, 0, modalCanvas.width, modalCanvas.height);
    
    modalVideo.style.display = 'none';
    modalCanvas.style.display = 'block';
    captureBtn.style.display = 'none';
    retakeBtn.style.display = 'block';
    useBtn.style.display = 'block';
};

// Retake
retakeBtn.onclick = () => {
    modalVideo.style.display = 'block';
    modalCanvas.style.display = 'none';
    captureBtn.style.display = 'block';
    retakeBtn.style.display = 'none';
    useBtn.style.display = 'none';
};

// Gunakan foto
useBtn.onclick = () => {
    modalCanvas.toBlob((blob) => {
        capturedImageBlob = blob;
        capturedImageUrl = URL.createObjectURL(blob);
        document.getElementById('tryOnBtn').style.display = 'block';
        document.getElementById('resultImage').src = capturedImageUrl;
        document.getElementById('resultContainer').style.display = 'block';
        document.getElementById('emptyResult').style.display = 'none';
        
        Swal.fire({ 
            icon: 'success', 
            title: 'Foto Tersimpan', 
            text: 'Sekarang pilih motif dan klik "Coba Motif Ini"', 
            confirmButtonColor: '#b8860b',
            timer: 2000,
            showConfirmButton: false
        });
        
        closeModalCamera();
    }, 'image/jpeg');
};

// Tutup modal
function closeModalCamera() {
    if (modalStream) {
        modalStream.getTracks().forEach(track => track.stop());
        modalStream = null;
    }
    modal.style.display = 'none';
}

closeBtn.onclick = closeModalCamera;

// Upload foto dari galeri
document.getElementById('fileUpload')?.addEventListener('change', function(e) {
    if(e.target.files.length > 0) {
        const file = e.target.files[0];
        if(file.size > 5 * 1024 * 1024) {
            Swal.fire({ icon: 'error', title: 'File Terlalu Besar', text: 'Maksimal 5MB', confirmButtonColor: '#b8860b' });
            return;
        }
        capturedImageBlob = file;
        capturedImageUrl = URL.createObjectURL(capturedImageBlob);
        document.getElementById('tryOnBtn').style.display = 'block';
        document.getElementById('resultImage').src = capturedImageUrl;
        document.getElementById('resultContainer').style.display = 'block';
        document.getElementById('emptyResult').style.display = 'none';
        Swal.fire({ icon: 'success', title: 'Foto Terupload', text: 'Pilih motif dan klik "Coba Motif Ini"', confirmButtonColor: '#b8860b' });
    }
});

document.getElementById('motifSelect')?.addEventListener('change', function() {
    currentMotifId = this.value;
    currentMotifName = this.options[this.selectedIndex]?.getAttribute('data-name');
});

function processTryOn() {
    if(!currentMotifId) {
        Swal.fire({ icon: 'warning', title: 'Pilih Motif', confirmButtonColor: '#b8860b' });
        return;
    }
    if(!capturedImageBlob) {
        Swal.fire({ icon: 'warning', title: 'Upload Foto', confirmButtonColor: '#b8860b' });
        return;
    }
    const formData = new FormData();
    formData.append('image', capturedImageBlob, 'photo.jpg');
    formData.append('motif_id', currentMotifId);
    Swal.fire({ title: 'Memproses...', allowOutsideClick: false, didOpen: () => Swal.showLoading() });
    fetch('{{ route("user.tryon.store") }}', {
        method: 'POST',
        headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}' },
        body: formData
    })
    .then(res => res.json())
    .then(data => {
        Swal.close();
        if(data.success) {
            document.getElementById('resultRecommendation').innerHTML = data.recommendation || 'Motif "' + currentMotifName + '" sangat cocok!';
            if(data.generated_image) document.getElementById('resultImage').src = data.generated_image;
            Swal.fire({ icon: 'success', title: 'Berhasil', timer: 2000, showConfirmButton: false });
            setTimeout(() => location.reload(), 2000);
        } else {
            Swal.fire({ icon: 'error', title: 'Gagal', text: data.error, confirmButtonColor: '#b8860b' });
        }
    }).catch(() => Swal.fire({ icon: 'error', title: 'Error', confirmButtonColor: '#b8860b' }));
}

function downloadResult() {
    const img = document.getElementById('resultImage');
    if(img && img.src) {
        const link = document.createElement('a');
        link.download = 'tryon-batik.png';
        link.href = img.src;
        link.click();
    }
}

function resetTryOn() {
    document.getElementById('resultContainer').style.display = 'none';
    document.getElementById('emptyResult').style.display = 'block';
    document.getElementById('tryOnBtn').style.display = 'none';
    capturedImageBlob = null;
    currentMotifId = null;
    document.getElementById('motifSelect').value = '';
    document.getElementById('fileUpload').value = '';
}
</script>
@endsection