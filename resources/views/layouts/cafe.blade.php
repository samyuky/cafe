<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CUMA Cafe - @yield('title')</title>
    
    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;500;600;700&family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <!-- Phosphor Icons (Professional Icon Library) -->
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
            background-color: #fdf8f0;
            color: #4a3728;
        }
        
        .sidebar {
            background: linear-gradient(180deg, #3c2415 0%, #5c3a28 100%);
            box-shadow: 4px 0 24px rgba(60, 36, 21, 0.12);
        }
        
        .card {
            background: white;
            border-radius: 16px;
            box-shadow: 0 1px 3px rgba(60, 36, 21, 0.04), 0 1px 2px rgba(60, 36, 21, 0.06);
            border: 1px solid #f2d7b6;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }
        
        .card:hover {
            box-shadow: 0 4px 6px rgba(60, 36, 21, 0.05), 0 10px 15px rgba(60, 36, 21, 0.1);
            border-color: #e9bb87;
        }
        
        .btn-primary {
            background: linear-gradient(135deg, #5c3a28 0%, #8b5e3c 100%);
            color: white;
            padding: 10px 24px;
            border-radius: 12px;
            font-weight: 500;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            box-shadow: 0 2px 4px rgba(60, 36, 21, 0.1);
        }
        
        .btn-primary:hover {
            transform: translateY(-1px);
            box-shadow: 0 4px 12px rgba(60, 36, 21, 0.2);
        }
        
        .btn-secondary {
            background: white;
            color: #5c3a28;
            padding: 10px 24px;
            border-radius: 12px;
            font-weight: 500;
            border: 1.5px solid #e9bb87;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }
        
        .btn-secondary:hover {
            background: #fdf8f0;
            border-color: #c56a2b;
        }
        
        .nav-item {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 12px 16px;
            color: #d4b896;
            border-radius: 12px;
            transition: all 0.2s ease;
            margin-bottom: 4px;
            font-size: 14px;
            font-weight: 500;
        }
        
        .nav-item:hover {
            background: rgba(255, 255, 255, 0.08);
            color: white;
        }
        
        .nav-item.active {
            background: rgba(255, 255, 255, 0.12);
            color: white;
            font-weight: 600;
        }
        
        .nav-item i {
            font-size: 20px;
            width: 24px;
            text-align: center;
        }
        
        .input-field {
            width: 100%;
            border: 1.5px solid #e9bb87;
            border-radius: 12px;
            padding: 10px 16px;
            font-size: 14px;
            transition: all 0.2s ease;
            background: white;
            color: #4a3728;
        }
        
        .input-field:focus {
            outline: none;
            border-color: #c56a2b;
            box-shadow: 0 0 0 3px rgba(197, 106, 43, 0.1);
        }
        
        .badge {
            display: inline-flex;
            align-items: center;
            padding: 4px 12px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 600;
            letter-spacing: 0.025em;
        }
        
        .badge-coffee {
            background: #fdf3e7;
            color: #8b5e3c;
        }
        
        .badge-success {
            background: #ecfdf5;
            color: #065f46;
        }
        
        .badge-danger {
            background: #fef2f2;
            color: #991b1b;
        }
        
        /* Scrollbar */
        ::-webkit-scrollbar {
            width: 6px;
        }
        
        ::-webkit-scrollbar-track {
            background: transparent;
        }
        
        ::-webkit-scrollbar-thumb {
            background: #e9bb87;
            border-radius: 3px;
        }
        
        ::-webkit-scrollbar-thumb:hover {
            background: #c56a2b;
        }

        /* Animation */
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(10px); }
            to { opacity: 1; transform: translateY(0); }
        }
        
        .animate-fade-in {
            animation: fadeIn 0.5s ease-out;
        }

        .stat-card {
            position: relative;
            overflow: hidden;
        }
        
        .stat-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 3px;
            background: linear-gradient(90deg, #c56a2b 0%, #e9bb87 100%);
        }
    </style>
</head>
<body class="flex min-h-screen">
    
    <!-- Sidebar -->
    <aside class="sidebar w-64 min-h-screen flex flex-col fixed left-0 top-0 z-30">
        <!-- Logo -->
        <div class="p-6 border-b border-white/10">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 bg-white/10 rounded-xl flex items-center justify-center">
                    <i class="ph ph-coffee text-white text-xl"></i>
                </div>
                <div>
                    <h1 class="text-white font-display font-bold text-lg leading-tight">CUMA</h1>
                    <p class="text-white/50 text-xs tracking-wider">CAFE KASIR</p>
                </div>
            </div>
        </div>
        
        <!-- Navigation -->
        <nav class="flex-1 p-4 space-y-1 overflow-y-auto">
            @if(auth()->user()->role == 'kasir')
                <a href="{{ route('kasir.dashboard') }}" 
                   class="nav-item {{ request()->routeIs('kasir.dashboard') ? 'active' : '' }}">
                    <i class="ph ph-shopping-cart"></i>
                    <span>Transaksi Baru</span>
                </a>
                <a href="{{ route('kasir.transactions') }}" 
                   class="nav-item {{ request()->routeIs('kasir.transactions') ? 'active' : '' }}">
                    <i class="ph ph-receipt"></i>
                    <span>Riwayat Transaksi</span>
                </a>
            @endif
            
            @if(auth()->user()->role == 'manager')
                <a href="{{ route('manager.dashboard') }}" 
                   class="nav-item {{ request()->routeIs('manager.dashboard') ? 'active' : '' }}">
                    <i class="ph ph-chart-bar"></i>
                    <span>Dashboard</span>
                </a>
                <a href="{{ route('manager.menus') }}" 
                   class="nav-item {{ request()->routeIs('manager.menus') ? 'active' : '' }}">
                    <i class="ph ph-list-dashes"></i>
                    <span>Kelola Menu</span>
                </a>
                <a href="{{ route('manager.reports') }}" 
                   class="nav-item {{ request()->routeIs('manager.reports') ? 'active' : '' }}">
                    <i class="ph ph-chart-line"></i>
                    <span>Laporan</span>
                </a>
                <a href="{{ route('manager.activity-log') }}" 
                   class="nav-item {{ request()->routeIs('manager.activity-log') ? 'active' : '' }}">
                    <i class="ph ph-clock-history"></i>
                    <span>Log Aktivitas</span>
                </a>
            @endif
            
            @if(auth()->user()->role == 'admin')
                <a href="{{ route('admin.dashboard') }}" 
                   class="nav-item {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                    <i class="ph ph-users"></i>
                    <span>Kelola User</span>
                </a>
                <a href="{{ route('admin.activity-log') }}" 
                   class="nav-item {{ request()->routeIs('admin.activity-log') ? 'active' : '' }}">
                    <i class="ph ph-clock-history"></i>
                    <span>Log Aktivitas</span>
                </a>
            @endif
        </nav>
        
        <!-- User Info -->
        <div class="p-4 border-t border-white/10">
            <div class="flex items-center gap-3 mb-3">
                <div class="w-10 h-10 bg-white/10 rounded-xl flex items-center justify-center">
                    <span class="text-white font-semibold text-sm">
                        {{ strtoupper(substr(auth()->user()->full_name, 0, 2)) }}
                    </span>
                </div>
                <div class="flex-1 min-w-0">
                    <p class="text-white font-medium text-sm truncate">{{ auth()->user()->full_name }}</p>
                    <p class="text-white/50 text-xs">{{ ucfirst(auth()->user()->role) }}</p>
                </div>
            </div>
            
            <form method="POST" action="{{ route('logout') }}" id="logoutForm">
                @csrf
                <button type="button" onclick="confirmLogout()" 
                        class="w-full flex items-center justify-center gap-2 px-4 py-2.5 rounded-xl text-white/70 hover:text-white hover:bg-white/10 transition text-sm">
                    <i class="ph ph-sign-out"></i>
                    <span>Keluar</span>
                </button>
            </form>
        </div>
    </aside>
    
    <!-- Main Content Area -->
    <div class="flex-1 ml-64">
        <!-- Top Bar -->
        <header class="bg-white/80 backdrop-blur-sm border-b border-coffee-200 sticky top-0 z-20">
            <div class="px-8 py-4 flex justify-between items-center">
                <div>
                    <h2 class="text-lg font-semibold text-coffee-900">@yield('page-title', 'Dashboard')</h2>
                    <p class="text-sm text-coffee-500" id="currentDate"></p>
                </div>
                
                <div class="flex items-center gap-4">
                    <div class="text-right hidden md:block">
                        <p class="text-sm font-medium text-coffee-900">{{ auth()->user()->full_name }}</p>
                        <p class="text-xs text-coffee-500">{{ ucfirst(auth()->user()->role) }}</p>
                    </div>
                    <div class="w-10 h-10 bg-coffee-100 rounded-xl flex items-center justify-center md:hidden">
                        <span class="text-coffee-700 font-semibold text-sm">
                            {{ strtoupper(substr(auth()->user()->full_name, 0, 2)) }}
                        </span>
                    </div>
                </div>
            </div>
        </header>
        
        <!-- Page Content -->
        <main class="p-8 animate-fade-in">
            @if(session('success'))
                <div class="mb-6 bg-green-50 border border-green-200 text-green-800 px-6 py-4 rounded-2xl flex items-center gap-3">
                    <i class="ph ph-check-circle text-green-600 text-xl"></i>
                    <span>{{ session('success') }}</span>
                </div>
            @endif
            
            @if(session('error'))
                <div class="mb-6 bg-red-50 border border-red-200 text-red-800 px-6 py-4 rounded-2xl flex items-center gap-3">
                    <i class="ph ph-warning-circle text-red-600 text-xl"></i>
                    <span>{{ session('error') }}</span>
                </div>
            @endif
            
            @yield('content')
        </main>
    </div>
    
    <!-- Scripts -->
    <script>
        // Update date
        function updateDate() {
            const now = new Date();
            const options = { 
                weekday: 'long', 
                year: 'numeric', 
                month: 'long', 
                day: 'numeric' 
            };
            document.getElementById('currentDate').textContent = now.toLocaleDateString('id-ID', options);
        }
        updateDate();
        
        // Logout confirmation
        function confirmLogout() {
            if (confirm('Apakah Anda yakin ingin keluar dari sistem?')) {
                document.getElementById('logoutForm').submit();
            }
        }
        
        // Mobile sidebar toggle (for responsive)
        function toggleSidebar() {
            const sidebar = document.querySelector('aside');
            sidebar.classList.toggle('-translate-x-full');
        }
    </script>
    
    @yield('scripts')
</body>
</html>