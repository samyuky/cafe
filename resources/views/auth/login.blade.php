<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - CUMA Cafe</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;500;600;700&family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <script src="https://unpkg.com/@phosphor-icons/web"></script>
    <style>
        body {
            font-family: 'Inter', sans-serif;
            background: linear-gradient(135deg, #3c2415 0%, #5c3a28 50%, #8b5e3c 100%);
            min-height: 100vh;
        }
        .login-card {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(20px);
            border-radius: 24px;
            box-shadow: 0 25px 50px rgba(0, 0, 0, 0.25);
        }
        .input-login {
            width: 100%;
            padding: 12px 16px;
            border: 2px solid #e9bb87;
            border-radius: 12px;
            transition: all 0.2s;
            font-size: 14px;
        }
        .input-login:focus {
            outline: none;
            border-color: #8b5e3c;
            box-shadow: 0 0 0 3px rgba(139, 94, 60, 0.1);
        }
    </style>
</head>
<body class="flex items-center justify-center min-h-screen p-4">
    <div class="w-full max-w-md login-card p-8">
        <!-- Logo -->
        <div class="text-center mb-8">
            <div class="w-20 h-20 bg-gradient-to-br from-coffee-700 to-coffee-500 rounded-2xl flex items-center justify-center mx-auto mb-4 shadow-lg">
                <i class="ph ph-coffee text-white text-3xl"></i>
            </div>
            <h1 class="text-3xl font-display font-bold text-coffee-900">CUMA Cafe</h1>
            <p class="text-coffee-500 mt-2 text-sm">Sistem Manajemen Kasir</p>
        </div>
        
        <form method="POST" action="{{ route('login') }}">
            @csrf
            
            <div class="space-y-4">
                <div>
                    <label class="block text-sm font-medium text-coffee-700 mb-2">
                        <i class="ph ph-envelope inline-block mr-1"></i> Email
                    </label>
                    <input type="email" name="email" value="{{ old('email') }}" required autofocus
                           class="input-login" placeholder="nama@email.com">
                    @error('email')
                        <p class="text-red-600 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>
                
                <div>
                    <label class="block text-sm font-medium text-coffee-700 mb-2">
                        <i class="ph ph-lock inline-block mr-1"></i> Password
                    </label>
                    <input type="password" name="password" required
                           class="input-login" placeholder="Masukkan password">
                    @error('password')
                        <p class="text-red-600 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>
                
                <button type="submit" 
                        class="w-full bg-gradient-to-r from-coffee-800 to-coffee-600 text-white py-3 rounded-xl font-semibold hover:shadow-lg transition-all duration-300 transform hover:-translate-y-0.5">
                    <i class="ph ph-sign-in mr-2"></i> Masuk ke Sistem
                </button>
            </div>
        </form>
        
        <div class="text-center mt-6">
            <p class="text-coffee-400 text-xs">© 2024 CUMA Cafe. All rights reserved.</p>
        </div>
    </div>
</body>
</html>