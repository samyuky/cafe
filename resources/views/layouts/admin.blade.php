<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CUMA Cafe - @yield('title')</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <script src="https://unpkg.com/@phosphor-icons/web"></script>
    <style>
        body {
            font-family: 'Inter', sans-serif;
            background: #f8fafc;
            color: #334155;
        }
        .sidebar-admin {
            background: #1e293b;
        }
        .nav-admin {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 10px 16px;
            color: #94a3b8;
            border-radius: 10px;
            transition: all 0.2s;
            font-size: 14px;
        }
        .nav-admin:hover {
            background: rgba(255,255,255,0.05);
            color: white;
        }
        .nav-admin.active {
            background: #8b5cf6;
            color: white;
        }
        .card-admin {
            background: white;
            border-radius: 16px;
            box-shadow: 0 1px 3px rgba(0,0,0,0.05);
            border: 1px solid #e2e8f0;
        }
        .btn-purple {
            background: #8b5cf6;
            color: white;
            padding: 10px 20px;
            border-radius: 10px;
            font-weight: 600;
            transition: all 0.2s;
        }
        .btn-purple:hover {
            background: #7c3aed;
        }
    </style>
</head>
<body class="flex">
    <aside class="sidebar-admin w-64 min-h-screen fixed left-0 top-0 flex flex-col">
        <div class="p-6 border-b border-white/10">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 bg-purple-500/20 rounded-xl flex items-center justify-center">
                    <i class="ph ph-shield-check text-purple-400 text-xl"></i>
                </div>
                <div>
                    <h1 class="text-white font-bold text-lg">CUMA Cafe</h1>
                    <p class="text-purple-300 text-xs">Admin Panel</p>
                </div>
            </div>
        </div>
        
        <nav class="flex-1 p-4 space-y-1">
            <a href="{{ route('admin.dashboard') }}" 
               class="nav-admin {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                <i class="ph ph-users text-lg"></i>
                Kelola User
            </a>
            <a href="{{ route('admin.activity-log') }}" 
               class="nav-admin {{ request()->routeIs('admin.activity-log') ? 'active' : '' }}">
                <i class="ph ph-clock-history text-lg"></i>
                Log Aktivitas
            </a>
        </nav>
        
        <div class="p-4 border-t border-white/10">
            <div class="flex items-center gap-3 mb-4">
                <div class="w-10 h-10 bg-white/10 rounded-xl flex items-center justify-center">
                    <span class="text-white font-semibold text-sm">A</span>
                </div>
                <div>
                    <p class="text-purple-300 text-xs">Admin</p>
                </div>
            </div>
            <form method="POST" action="{{ route('logout') }}" id="logoutForm">
                @csrf
                <button type="button" onclick="confirmLogout()" 
                        class="w-full px-4 py-2.5 rounded-xl bg-white/5 text-red-400 hover:bg-white/10 transition text-sm">
                    <i class="ph ph-sign-out mr-2"></i>Keluar
                </button>
            </form>
        </div>
    </aside>
    
    <div class="flex-1 ml-64">
        <header class="bg-white border-b border-gray-200 sticky top-0 z-20">
            <div class="px-8 py-4 flex justify-between items-center">
                <div>
                    <h2 class="text-xl font-bold text-gray-900">@yield('page-title')</h2>
                </div>
                <span class="px-3 py-1 bg-purple-100 text-purple-700 rounded-lg text-sm font-medium">Admin</span>
            </div>
        </header>
        
        <main class="p-8">
            @if(session('success'))
                <div class="mb-6 bg-green-50 border border-green-200 text-green-800 px-5 py-4 rounded-2xl flex items-center gap-3">
                    <i class="ph ph-check-circle text-green-600 text-xl"></i>
                    {{ session('success') }}
                </div>
            @endif
            @yield('content')
        </main>
    </div>
    
    <script>
        function confirmLogout() {
            if (confirm('Apakah Anda yakin ingin keluar?')) {
                document.getElementById('logoutForm').submit();
            }
        }
    </script>
    @yield('scripts')
</body>
</html>