<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>☕ Cafe Kasir - @yield('title')</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background-color: #FFF8F0;
        }
        .cafe-gradient {
            background: linear-gradient(135deg, #6F4E37 0%, #A67B5B 100%);
        }
        .cafe-card {
            background: white;
            border-radius: 20px;
            box-shadow: 0 4px 15px rgba(111, 78, 55, 0.1);
        }
        .cafe-button {
            background: linear-gradient(135deg, #6F4E37 0%, #A67B5B 100%);
            color: white;
            padding: 10px 25px;
            border-radius: 50px;
            font-weight: 600;
            transition: all 0.3s;
        }
        .cafe-button:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(111, 78, 55, 0.3);
        }
    </style>
</head>
<body>
    <!-- Navbar -->
    <nav class="cafe-gradient p-4 shadow-lg">
        <div class="container mx-auto flex justify-between items-center">
            <div class="flex items-center space-x-3">
                <span class="text-3xl">☕</span>
                <h1 class="text-white text-2xl font-bold">CUMA Cafe</h1>
            </div>
            <div class="flex items-center space-x-4">
                <span class="text-white">{{ auth()->user()->full_name }}</span>
                <span class="bg-white/20 text-white px-3 py-1 rounded-full text-sm">
                    {{ ucfirst(auth()->user()->role) }}
                </span>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button class="text-white hover:text-gray-200">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                        </svg>
                    </button>
                </form>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <main class="container mx-auto mt-8 px-4">
        @yield('content')
    </main>

    @yield('scripts')
</body>
</html>