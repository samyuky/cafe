<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CUMA Cafe - @yield('title')</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;500;600;700&family=Inter:wght@300;400;500;600&display=swap" rel="stylesheet">
    <script src="https://unpkg.com/@phosphor-icons/web"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        'display': ['Playfair Display', 'serif'],
                        'body': ['Inter', 'sans-serif'],
                    },
                    colors: {
                        coffee: {
                            50: '#fdf8f0',
                            100: '#f9eddb',
                            200: '#f2d7b6',
                            300: '#e9bb87',
                            400: '#df9a56',
                            500: '#d48136',
                            600: '#c56a2b',
                            700: '#a45225',
                            800: '#844224',
                            900: '#6b3820',
                        }
                    }
                }
            }
        }
    </script>
    <style>
        body {
            font-family: 'Inter', sans-serif;
            background: linear-gradient(135deg, #fdf8f0 0%, #fef5ec 50%, #fff8f2 100%);
            color: #4a3728;
            min-height: 100vh;
        }
        .glass-nav {
            background: rgba(255, 255, 255, 0.8);
            backdrop-filter: blur(12px);
            border-bottom: 1px solid rgba(139, 94, 60, 0.1);
        }
        .card {
            background: white;
            border-radius: 20px;
            box-shadow: 0 4px 6px -1px rgba(139, 94, 60, 0.05), 0 2px 4px -2px rgba(139, 94, 60, 0.05);
            border: 1px solid rgba(139, 94, 60, 0.08);
            transition: all 0.3s ease;
        }
        .card:hover {
            box-shadow: 0 10px 25px -5px rgba(139, 94, 60, 0.1), 0 8px 10px -6px rgba(139, 94, 60, 0.05);
            transform: translateY(-2px);
        }
        .btn-coffee {
            background: linear-gradient(135deg, #8b5e3c 0%, #a0522d 100%);
            color: white;
            padding: 12px 24px;
            border-radius: 14px;
            font-weight: 600;
            letter-spacing: 0.3px;
            transition: all 0.3s ease;
            box-shadow: 0 4px 12px rgba(139, 94, 60, 0.2);
        }
        .btn-coffee:hover {
            transform: translateY(-1px);
            box-shadow: 0 6px 20px rgba(139, 94, 60, 0.3);
        }
        .btn-coffee:active {
            transform: translateY(0);
        }
        .menu-item {
            background: white;
            border: 2px solid #f2d7b6;
            border-radius: 16px;
            padding: 20px;
            cursor: pointer;
            transition: all 0.3s ease;
        }
        .menu-item:hover {
            border-color: #c56a2b;
            box-shadow: 0 8px 25px rgba(139, 94, 60, 0.12);
            transform: translateY(-3px);
        }
        .input-coffee {
            width: 100%;
            padding: 12px 16px;
            border: 2px solid #f2d7b6;
            border-radius: 12px;
            font-size: 15px;
            transition: all 0.2s;
            background: #fefaf5;
        }
        .input-coffee:focus {
            outline: none;
            border-color: #c56a2b;
            background: white;
            box-shadow: 0 0 0 3px rgba(197, 106, 43, 0.08);
        }
        .tag {
            display: inline-block;
            padding: 4px 10px;
            border-radius: 20px;
            font-size: 11px;
            font-weight: 600;
            letter-spacing: 0.5px;
            text-transform: uppercase;
        }
        .tag-food {
            background: #fff7ed;
            color: #c2410c;
        }
        .tag-drink {
            background: #f0f9ff;
            color: #0369a1;
        }
    </style>
</head>
<body>
    <!-- Navigation Bar -->
    <nav class="glass-nav sticky top-0 z-30">
        <div class="max-w-7xl mx-auto px-6 py-4">
            <div class="flex justify-between items-center">
                <!-- Logo -->
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 bg-gradient-to-br from-coffee-700 to-coffee-500 rounded-xl flex items-center justify-center shadow-lg">
                        <i class="ph ph-coffee text-white text-xl"></i>
                    </div>
                    <div>
                        <h1 class="font-display font-bold text-xl text-coffee-900">CUMA Cafe</h1>
                        <p class="text-xs text-coffee-400 font-medium">Kasir</p>
                    </div>
                </div>
                
                <!-- Right Section -->
                <div class="flex items-center gap-6">
                    <a href="{{ route('kasir.dashboard') }}" 
                       class="hidden sm:flex items-center gap-2 px-4 py-2 rounded-xl text-sm font-medium transition {{ request()->routeIs('kasir.dashboard') ? 'bg-coffee-800 text-white' : 'text-coffee-600 hover:bg-coffee-50' }}">
                        <i class="ph ph-shopping-cart"></i>
                        Transaksi
                    </a>
                    <a href="{{ route('kasir.transactions') }}" 
                       class="hidden sm:flex items-center gap-2 px-4 py-2 rounded-xl text-sm font-medium transition {{ request()->routeIs('kasir.transactions') ? 'bg-coffee-800 text-white' : 'text-coffee-600 hover:bg-coffee-50' }}">
                        <i class="ph ph-receipt"></i>
                        Riwayat
                    </a>
                    
                    <div class="h-8 w-px bg-coffee-200 hidden sm:block"></div>
                    
                    <div class="flex items-center gap-3">
                        <div class="text-right hidden sm:block">
                            <p class="text-sm font-semibold text-coffee-900">{{ auth()->user()->full_name }}</p>
                            <p class="text-xs text-coffee-400">Kasir</p>
                        </div>
                        <div class="w-9 h-9 bg-coffee-100 rounded-xl flex items-center justify-center">
                            <span class="text-coffee-700 font-bold text-sm">
                                {{ strtoupper(substr(auth()->user()->full_name, 0, 2)) }}
                            </span>
                        </div>
                        <form method="POST" action="{{ route('logout') }}" id="logoutForm">
                            @csrf
                            <button type="button" onclick="confirmLogout()" 
                                    class="w-9 h-9 bg-red-50 hover:bg-red-100 rounded-xl flex items-center justify-center transition">
                                <i class="ph ph-sign-out text-red-500"></i>
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </nav>
    
    <!-- Main Content -->
    <main class="max-w-7xl mx-auto px-6 py-8">
        @if(session('success'))
            <div class="mb-6 bg-emerald-50 border border-emerald-200 text-emerald-800 px-5 py-4 rounded-2xl flex items-center gap-3 animate-fade-in">
                <i class="ph ph-check-circle text-emerald-600 text-xl"></i>
                <span class="text-sm font-medium">{{ session('success') }}</span>
            </div>
        @endif
        
        @if(session('error'))
            <div class="mb-6 bg-red-50 border border-red-200 text-red-800 px-5 py-4 rounded-2xl flex items-center gap-3 animate-fade-in">
                <i class="ph ph-warning-circle text-red-600 text-xl"></i>
                <span class="text-sm font-medium">{{ session('error') }}</span>
            </div>
        @endif
        
        @yield('content')
    </main>
    
    @yield('scripts')
    
    <script>
        function confirmLogout() {
            if (confirm('Apakah Anda yakin ingin keluar?')) {
                document.getElementById('logoutForm').submit();
            }
        }
    </script>
</body>
</html>