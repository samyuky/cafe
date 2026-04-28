<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CUMA Cafe - @yield('title')</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <script src="https://unpkg.com/@phosphor-icons/web"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        'sans': ['Inter', 'sans-serif'],
                    },
                    colors: {
                        slate: {
                            850: '#1e293b',
                        }
                    }
                }
            }
        }
    </script>
    <style>
        body {
            font-family: 'Inter', sans-serif;
            background-color: #f1f5f9;
            color: #1e293b;
            min-height: 100vh;
        }
        .sidebar-manager {
            background: linear-gradient(180deg, #0f172a 0%, #1e293b 100%);
        }
        .nav-manager {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 10px 16px;
            color: #94a3b8;
            border-radius: 10px;
            transition: all 0.2s;
            font-size: 14px;
            font-weight: 500;
        }
        .nav-manager:hover {
            background: rgba(255, 255, 255, 0.05);
            color: #e2e8f0;
        }
        .nav-manager.active {
            background: #3b82f6;
            color: white;
        }
        .card-manager {
            background: white;
            border-radius: 16px;
            box-shadow: 0 1px 3px rgba(0,0,0,0.04);
            border: 1px solid #e2e8f0;
        }
        .stat-card {
            background: white;
            border-radius: 16px;
            padding: 24px;
            border-left: 4px solid #3b82f6;
        }
        .btn-blue {
            background: #3b82f6;
            color: white;
            padding: 10px 20px;
            border-radius: 10px;
            font-weight: 600;
            font-size: 14px;
            transition: all 0.2s;
        }
        .btn-blue:hover {
            background: #2563eb;
        }
    </style>
</head>
<body class="flex">
    <!-- Sidebar -->
    <aside class="sidebar-manager w-64 min-h-screen fixed left-0 top-0 z-30 flex flex-col">
        <div class="p-6 border-b border-white/10">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 bg-blue-500/20 rounded-xl flex items-center justify-center">
                    <i class="ph ph-coffee text-blue-400 text-xl"></i>
                </div>
                <div>
                    <h1 class="text-white font-bold text-lg">CUMA Cafe</h1>
                    <p class="text-blue-300 text-xs">Manager Panel</p>
                </div>
            </div>
        </div>
        
        <nav class="flex-1 p-4 space-y-1">
            <a href="{{ route('manager.dashboard') }}" 
               class="nav-manager {{ request()->routeIs('manager.dashboard') ? 'active' : '' }}">
                <i class="ph ph-chart-pie text-lg"></i>
                Dashboard
            </a>
            <a href="{{ route('manager.menus') }}" 
               class="nav-manager {{ request()->routeIs('manager.menus') ? 'active' : '' }}">
                <i class="ph ph-list-dashes text-lg"></i>
                Kelola Menu
            </a>
            <a href="{{ route('manager.reports') }}" 
               class="nav-manager {{ request()->routeIs('manager.reports') ? 'active' : '' }}">
                <i class="ph ph-chart-bar text-lg"></i>
                Laporan
            </a>
            <a href="{{ route('manager.activity-log') }}" 
               class="nav-manager {{ request()->routeIs('manager.activity-log') ? 'active' : '' }}">
                <i class="ph ph-clock-history text-lg"></i>
                Log Aktivitas
            </a>
        </nav>
        
        <div class="p-4 border-t border-white/10">
            <div class="flex items-center gap-3 mb-4">
                <div class="w-10 h-10 bg-white/10 rounded-xl flex items-center justify-center">
                    <span class="text-white font-semibold text-sm">{{ strtoupper(substr(auth()->user()->full_name, 0, 2)) }}</span>
                </div>
                <div>
                    <p class="text-white text-sm font-medium">{{ auth()->user()->full_name }}</p>
                    <p class="text-blue-300 text-xs">Manager</p>
                </div>
            </div>
            <form method="POST" action="{{ route('logout') }}" id="logoutForm">
                @csrf
                <button type="button" onclick="confirmLogout()" 
                        class="w-full px-4 py-2.5 rounded-xl bg-white/5 text-red-400 hover:bg-white/10 transition text-sm font-medium">
                    <i class="ph ph-sign-out mr-2"></i>Keluar
                </button>
            </form>
        </div>
    </aside>
    
    <!-- Main Content -->
    <div class="flex-1 ml-64">
        <!-- Top Bar -->
        <header class="bg-white border-b border-gray-200 sticky top-0 z-20">
            <div class="px-8 py-4 flex justify-between items-center">
                <div>
                    <h2 class="text-xl font-bold text-gray-900">@yield('page-title')</h2>
                    <p class="text-sm text-gray-500" id="currentDate"></p>
                </div>
                <div class="flex items-center gap-4">
                    <span class="px-3 py-1 bg-blue-100 text-blue-700 rounded-lg text-sm font-medium">
                        Manager
                    </span>
                </div>
            </div>
        </header>
        
        <main class="p-8">
            @if(session('success'))
                <div class="mb-6 bg-green-50 border border-green-200 text-green-800 px-5 py-4 rounded-2xl flex items-center gap-3">
                    <i class="ph ph-check-circle text-green-600 text-xl"></i>
                    {{ session('success') }}
                </div>
            @endif
            @if(session('error'))
                <div class="mb-6 bg-red-50 border border-red-200 text-red-800 px-5 py-4 rounded-2xl flex items-center gap-3">
                    <i class="ph ph-warning-circle text-red-600 text-xl"></i>
                    {{ session('error') }}
                </div>
            @endif
            @yield('content')
        </main>
    </div>
    
    <script>
        function updateDate() {
            const now = new Date();
            document.getElementById('currentDate').textContent = now.toLocaleDateString('id-ID', { 
                weekday: 'long', year: 'numeric', month: 'long', day: 'numeric' 
            });
        }
        updateDate();
        function confirmLogout() {
            if (confirm('Apakah Anda yakin ingin keluar?')) {
                document.getElementById('logoutForm').submit();
            }
        }
    </script>
    @yield('scripts')
</body>
</html>