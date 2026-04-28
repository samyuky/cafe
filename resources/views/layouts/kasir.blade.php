<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CUMA Cafe - @yield('title')</title>
    
    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,400;0,500;0,600;0,700;0,800;0,900;1,400&family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    
    <!-- Phosphor Icons -->
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
                            950: '#4a2515',
                        }
                    }
                }
            }
        }
    </script>
    
    <style>
        body {
            font-family: 'Inter', sans-serif;
            background: #fdf8f0;
            color: #3c2415;
            min-height: 100vh;
        }
        
        /* Background Pattern */
        .bg-pattern {
            position: fixed;
            inset: 0;
            background-image: 
                radial-gradient(circle at 10% 20%, rgba(139, 94, 60, 0.04) 0%, transparent 50%),
                radial-gradient(circle at 90% 80%, rgba(197, 106, 43, 0.03) 0%, transparent 50%);
            pointer-events: none;
            z-index: 0;
        }
        
        /* Navigation Bar */
        .navbar {
            position: sticky;
            top: 0;
            z-index: 40;
            background: rgba(255, 255, 255, 0.85);
            backdrop-filter: blur(20px);
            border-bottom: 1px solid rgba(139, 94, 60, 0.08);
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.02);
        }
        
        .navbar-inner {
            max-width: 1400px;
            margin: 0 auto;
            padding: 16px 32px;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }
        
        .logo-section {
            display: flex;
            align-items: center;
            gap: 14px;
        }
        
        .logo-icon {
            width: 44px;
            height: 44px;
            background: linear-gradient(135deg, #3c2415 0%, #6b3820 50%, #8b4513 100%);
            border-radius: 14px;
            display: flex;
            align-items: center;
            justify-content: center;
            box-shadow: 0 4px 15px rgba(107, 56, 32, 0.25);
        }
        
        .logo-icon i {
            font-size: 22px;
            color: white;
        }
        
        .logo-text h1 {
            font-family: 'Playfair Display', serif;
            font-weight: 700;
            font-size: 20px;
            color: #3c2415;
            line-height: 1.1;
        }
        
        .logo-text span {
            font-size: 11px;
            color: #a45225;
            letter-spacing: 2px;
            text-transform: uppercase;
            font-weight: 600;
        }
        
        .nav-links {
            display: flex;
            align-items: center;
            gap: 6px;
        }
        
        .nav-link {
            padding: 10px 18px;
            border-radius: 12px;
            font-size: 14px;
            font-weight: 500;
            color: #6b3820;
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
            gap: 8px;
            text-decoration: none;
        }
        
        .nav-link:hover {
            background: rgba(139, 94, 60, 0.06);
            color: #3c2415;
        }
        
        .nav-link.active {
            background: linear-gradient(135deg, #3c2415 0%, #6b3820 100%);
            color: white;
            box-shadow: 0 4px 12px rgba(107, 56, 32, 0.2);
        }
        
        .user-section {
            display: flex;
            align-items: center;
            gap: 16px;
        }
        
        .user-info {
            text-align: right;
        }
        
        .user-info .name {
            font-size: 14px;
            font-weight: 600;
            color: #3c2415;
        }
        
        .user-info .role {
            font-size: 11px;
            color: #a45225;
            font-weight: 500;
            letter-spacing: 1px;
            text-transform: uppercase;
        }
        
        .avatar {
            width: 40px;
            height: 40px;
            background: linear-gradient(135deg, #f9eddb, #f2d7b6);
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 700;
            font-size: 14px;
            color: #6b3820;
        }
        
        .logout-btn {
            width: 40px;
            height: 40px;
            border-radius: 12px;
            border: 1.5px solid rgba(139, 94, 60, 0.15);
            background: white;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            transition: all 0.3s ease;
            color: #a45225;
        }
        
        .logout-btn:hover {
            background: #fef2f2;
            border-color: #fecaca;
            color: #dc2626;
        }
        
        /* Main Content */
        .main-content {
            position: relative;
            z-index: 1;
            max-width: 1400px;
            margin: 0 auto;
            padding: 32px;
        }
        
        /* Card */
        .card {
            background: white;
            border-radius: 24px;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.03), 0 8px 30px rgba(0, 0, 0, 0.04);
            border: 1px solid rgba(139, 94, 60, 0.06);
            transition: all 0.4s cubic-bezier(0.16, 1, 0.3, 1);
        }
        
        .card:hover {
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.04), 0 12px 40px rgba(0, 0, 0, 0.06);
        }
        
        /* Button */
        .btn-primary {
            background: linear-gradient(135deg, #3c2415 0%, #6b3820 50%, #8b4513 100%);
            color: white;
            padding: 12px 24px;
            border-radius: 14px;
            font-weight: 600;
            font-size: 14px;
            border: none;
            cursor: pointer;
            transition: all 0.3s ease;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            letter-spacing: 0.3px;
        }
        
        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(107, 56, 32, 0.3);
        }
        
        .btn-primary:active {
            transform: translateY(0);
        }
        
        .btn-secondary {
            background: white;
            color: #6b3820;
            padding: 12px 24px;
            border-radius: 14px;
            font-weight: 600;
            font-size: 14px;
            border: 2px solid #f2d7b6;
            cursor: pointer;
            transition: all 0.3s ease;
            display: inline-flex;
            align-items: center;
            gap: 8px;
        }
        
        .btn-secondary:hover {
            border-color: #c56a2b;
            background: #fdf8f0;
        }
        
        /* Input */
        .input-premium {
            width: 100%;
            padding: 12px 16px;
            background: #fdf8f0;
            border: 2px solid #f2d7b6;
            border-radius: 14px;
            font-size: 14px;
            font-family: 'Inter', sans-serif;
            color: #3c2415;
            transition: all 0.3s ease;
            outline: none;
        }
        
        .input-premium:focus {
            border-color: #c56a2b;
            background: white;
            box-shadow: 0 0 0 4px rgba(197, 106, 43, 0.06);
        }
        
        .input-premium::placeholder {
            color: #c5a582;
        }
        
        /* Badge */
        .badge {
            display: inline-flex;
            align-items: center;
            padding: 6px 14px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 600;
            letter-spacing: 0.5px;
        }
        
        .badge-food {
            background: #fff7ed;
            color: #c2410c;
        }
        
        .badge-drink {
            background: #f0f9ff;
            color: #0369a1;
        }
        
        .badge-success {
            background: #ecfdf5;
            color: #065f46;
        }
        
        /* Scrollbar */
        ::-webkit-scrollbar {
            width: 5px;
        }
        
        ::-webkit-scrollbar-track {
            background: transparent;
        }
        
        ::-webkit-scrollbar-thumb {
            background: #e9bb87;
            border-radius: 10px;
        }
        
        ::-webkit-scrollbar-thumb:hover {
            background: #c56a2b;
        }
        
        /* Animation */
        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
        
        .animate-in {
            animation: fadeInUp 0.5s cubic-bezier(0.16, 1, 0.3, 1);
        }
        
        /* Menu Card */
        .menu-card {
            background: white;
            border-radius: 20px;
            overflow: hidden;
            border: 2px solid #f2d7b6;
            cursor: pointer;
            transition: all 0.4s cubic-bezier(0.16, 1, 0.3, 1);
        }
        
        .menu-card:hover {
            border-color: #c56a2b;
            box-shadow: 0 20px 40px rgba(107, 56, 32, 0.12);
            transform: translateY(-4px);
        }
        
        .menu-card:active {
            transform: scale(0.97);
        }
        
        /* Payment Method Card */
        .payment-method-card input:checked + div {
            border-color: #c56a2b !important;
            background: #fdf8f0 !important;
            box-shadow: 0 4px 15px rgba(197, 106, 43, 0.15);
        }
        
        /* Modal */
        .modal-overlay {
            background: rgba(0, 0, 0, 0.6);
            backdrop-filter: blur(4px);
        }
        
        .modal-content {
            background: white;
            border-radius: 28px;
            box-shadow: 0 25px 80px rgba(0, 0, 0, 0.25);
            animation: modalIn 0.4s cubic-bezier(0.16, 1, 0.3, 1);
        }
        
        @keyframes modalIn {
            from {
                opacity: 0;
                transform: scale(0.95) translateY(20px);
            }
            to {
                opacity: 1;
                transform: scale(1) translateY(0);
            }
        }
        
        /* Alert */
        .alert {
            padding: 16px 20px;
            border-radius: 16px;
            display: flex;
            align-items: center;
            gap: 12px;
            font-size: 14px;
            font-weight: 500;
            animation: fadeInUp 0.5s cubic-bezier(0.16, 1, 0.3, 1);
        }
        
        .alert-success {
            background: #ecfdf5;
            border: 1px solid #a7f3d0;
            color: #065f46;
        }
        
        .alert-error {
            background: #fef2f2;
            border: 1px solid #fecaca;
            color: #991b1b;
        }
        
        /* Responsive */
        @media (max-width: 768px) {
            .navbar-inner {
                padding: 12px 16px;
            }
            
            .main-content {
                padding: 16px;
            }
            
            .nav-links {
                display: none;
            }
            
            .user-info {
                display: none;
            }
        }
    </style>
</head>
<body>
    <div class="bg-pattern"></div>
    
    <!-- Navigation -->
    <nav class="navbar">
        <div class="navbar-inner">
            <div class="logo-section">
                <div class="logo-icon">
                    <i class="ph ph-coffee"></i>
                </div>
                <div class="logo-text">
                    <h1>CUMA</h1>
                    <span>Kasir</span>
                </div>
            </div>
            
            <div class="nav-links">
                <a href="{{ route('kasir.dashboard') }}" 
                   class="nav-link {{ request()->routeIs('kasir.dashboard') ? 'active' : '' }}">
                    <i class="ph ph-shopping-cart"></i>
                    Transaksi
                </a>
                <a href="{{ route('kasir.transactions') }}" 
                   class="nav-link {{ request()->routeIs('kasir.transactions') ? 'active' : '' }}">
                    <i class="ph ph-receipt"></i>
                    Riwayat
                </a>
            </div>
            
            <div class="user-section">
                <div class="user-info">
                    <div class="name">{{ auth()->user()->full_name }}</div>
                    <div class="role">Kasir</div>
                </div>
                <div class="avatar">
                    {{ strtoupper(substr(auth()->user()->full_name, 0, 2)) }}
                </div>
                <form method="POST" action="{{ route('logout') }}" id="logoutForm" class="m-0">
                    @csrf
                    <button type="button" onclick="confirmLogout()" class="logout-btn">
                        <i class="ph ph-sign-out"></i>
                    </button>
                </form>
            </div>
        </div>
    </nav>
    
    <!-- Main Content -->
    <main class="main-content">
        @if(session('success'))
            <div class="alert alert-success mb-6">
                <i class="ph ph-check-circle text-xl"></i>
                {{ session('success') }}
            </div>
        @endif
        
        @if(session('error'))
            <div class="alert alert-error mb-6">
                <i class="ph ph-warning-circle text-xl"></i>
                {{ session('error') }}
            </div>
        @endif
        
        <div class="animate-in">
            @yield('content')
        </div>
    </main>
    
    <!-- QR Code & Barcode Libraries -->
    <script src="https://cdn.jsdelivr.net/npm/qrcode@1.5.1/build/qrcode.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/jsbarcode@3.11.5/dist/JsBarcode.all.min.js"></script>
    
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