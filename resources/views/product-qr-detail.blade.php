<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $product->name }} - Batiknesia</title>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;500;600;700&family=Poppins:wght@300;400;500;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body {
            font-family: 'Poppins', sans-serif;
            background: #2c1810;
            min-height: 100vh;
            padding: 20px;
        }
        .container { max-width: 800px; margin: 0 auto; }
        .card {
            background: rgba(255,252,245,0.96);
            border-radius: 24px;
            padding: 30px;
            margin-bottom: 20px;
            border: 1px solid rgba(196,167,71,0.2);
        }
        .product-image {
            width: 100%;
            max-height: 300px;
            object-fit: cover;
            border-radius: 16px;
            margin-bottom: 20px;
        }
        h1 { font-family: 'Playfair Display', serif; font-size: 28px; color: #2c1810; }
        .price { font-size: 24px; font-weight: 700; color: #c4a747; margin: 10px 0; }
        .video-container {
            position: relative;
            padding-bottom: 56.25%;
            height: 0;
            overflow: hidden;
            border-radius: 16px;
            margin: 20px 0;
        }
        .video-container iframe {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
        }
        .btn-back {
            background: #c4a747;
            color: #2c1810;
            padding: 10px 24px;
            border-radius: 40px;
            text-decoration: none;
            display: inline-block;
            font-weight: 600;
        }
        @media (max-width: 768px) {
            .card { padding: 20px; }
            h1 { font-size: 22px; }
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="card">
            @if($product->image)
                <img src="{{ asset($product->image) }}" class="product-image">
            @endif
            
            <h1>{{ $product->name }}</h1>
            <div class="price">Rp {{ number_format($product->price, 0, ',', '.') }}</div>
            
            @if($motif)
            <div style="background: rgba(196,167,71,0.1); border-radius: 16px; padding: 15px; margin: 15px 0;">
                <h3>Motif: {{ $motif->name }}</h3>
                <p>Asal: {{ $motif->origin ?? 'Tidak diketahui' }}</p>
                <p>Filosofi: {{ $motif->philosophy ?? 'Tidak ada informasi' }}</p>
            </div>
            @endif
            
            @if($education)
                @if($education->video_url)
                <div class="video-container">
                    @php
                        $videoUrl = $education->video_url;
                        if(strpos($videoUrl, 'youtu.be/') !== false) {
                            $videoId = substr($videoUrl, strpos($videoUrl, 'youtu.be/') + 9);
                            $embedUrl = 'https://www.youtube.com/embed/' . $videoId;
                        } elseif(strpos($videoUrl, 'watch?v=') !== false) {
                            $videoId = substr($videoUrl, strpos($videoUrl, 'watch?v=') + 8);
                            $embedUrl = 'https://www.youtube.com/embed/' . $videoId;
                        } else {
                            $embedUrl = $videoUrl;
                        }
                    @endphp
                    <iframe src="{{ $embedUrl }}" frameborder="0" allowfullscreen></iframe>
                </div>
                @endif
                
                <div style="margin-top: 20px;">
                    <h3>📖 Tentang Batik Ini</h3>
                    <p style="margin-top: 10px; line-height: 1.6;">{{ Str::limit($education->content, 500) }}</p>
                    @if(strlen($education->content) > 500)
                        <button onclick="showFullArticle()" style="color: #c4a747; background: none; border: none; cursor: pointer; margin-top: 10px;">Baca Selengkapnya →</button>
                    @endif
                </div>
            @endif
            
            <div style="margin-top: 30px;">
                <a href="{{ url('/') }}" class="btn-back">← Kembali ke Beranda</a>
            </div>
        </div>
    </div>
    
    <script>
    function showFullArticle() {
        Swal.fire({
            title: '{{ $education->title }}',
            html: `<div style="text-align:left; max-height:400px; overflow-y:auto;">{{ nl2br(e($education->content)) }}</div>`,
            confirmButtonColor: '#c4a747'
        });
    }
    </script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</body>
</html>