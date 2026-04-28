<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>404 - Halaman Tidak Ditemukan | CUMA Cafe</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background: linear-gradient(135deg, #FFF8F0 0%, #FFE8D6 100%);
            min-height: 100vh;
        }
    </style>
</head>
<body class="flex items-center justify-center min-h-screen p-4">
    <div class="text-center">
        <div class="text-9xl mb-8">☕</div>
        <h1 class="text-6xl font-bold text-amber-900 mb-4">404</h1>
        <p class="text-2xl text-gray-600 mb-8">Ups! Pesanan Anda tidak ditemukan...</p>
        <p class="text-gray-500 mb-8">Halaman yang Anda cari mungkin sudah habis atau tidak tersedia.</p>
        <a href="{{ url('/') }}" 
           class="inline-block bg-gradient-to-r from-amber-700 to-amber-500 text-white px-8 py-4 rounded-xl font-bold text-lg hover:shadow-lg transition transform hover:-translate-y-1">
            🏠 Kembali ke Menu Utama
        </a>
    </div>
</body>
</html>