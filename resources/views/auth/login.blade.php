<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - CUMA Cafe</title>
    
    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,400;0,500;0,600;0,700;0,800;0,900;1,400&family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
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
            background: #1a0f0a;
            min-height: 100vh;
            overflow: hidden;
        }
        
        .bg-pattern {
            position: fixed;
            inset: 0;
            background-image: 
                radial-gradient(circle at 20% 50%, rgba(139, 94, 60, 0.15) 0%, transparent 50%),
                radial-gradient(circle at 80% 20%, rgba(197, 106, 43, 0.1) 0%, transparent 50%),
                radial-gradient(circle at 50% 80%, rgba(107, 56, 32, 0.12) 0%, transparent 50%);
            z-index: 0;
        }
        
        .coffee-beans {
            position: fixed;
            inset: 0;
            z-index: 0;
            opacity: 0.03;
            background-image: url("data:image/svg+xml,%3Csvg width='60' height='60' viewBox='0 0 60 60' xmlns='http://www.w3.org/2000/svg'%3E%3Cg fill='none' fill-rule='evenodd'%3E%3Cg fill='%23ffffff' fill-opacity='1'%3E%3Cpath d='M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E");
        }
        
        .login-container {
            position: relative;
            z-index: 10;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
        }
        
        .login-wrapper {
            display: flex;
            max-width: 1000px;
            width: 100%;
            min-height: 600px;
            border-radius: 32px;
            overflow: hidden;
            box-shadow: 0 25px 80px rgba(0, 0, 0, 0.5), 0 0 120px rgba(139, 94, 60, 0.15);
            animation: slideUp 0.8s cubic-bezier(0.16, 1, 0.3, 1);
        }
        
        @keyframes slideUp {
            from {
                opacity: 0;
                transform: translateY(40px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
        
        /* Left Panel - Image/Brand */
        .brand-panel {
            flex: 1;
            background: linear-gradient(135deg, #3c1808 0%, #5c2a15 30%, #8b4513 60%, #6b3820 100%);
            position: relative;
            overflow: hidden;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            padding: 60px 40px;
            text-align: center;
        }
        
        .brand-panel::before {
            content: '';
            position: absolute;
            inset: 0;
            background: 
                radial-gradient(circle at 30% 40%, rgba(255,255,255,0.05) 0%, transparent 50%),
                radial-gradient(circle at 70% 60%, rgba(255,255,255,0.03) 0%, transparent 50%);
        }
        
        .brand-panel::after {
            content: '';
            position: absolute;
            top: -50%;
            left: -50%;
            width: 200%;
            height: 200%;
            background: radial-gradient(circle, rgba(255,255,255,0.03) 1px, transparent 1px);
            background-size: 30px 30px;
            animation: float 20s linear infinite;
        }
        
        @keyframes float {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }
        
        .brand-content {
            position: relative;
            z-index: 2;
        }
        
        .logo-circle {
            width: 100px;
            height: 100px;
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(10px);
            border: 2px solid rgba(255, 255, 255, 0.2);
            border-radius: 28px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 24px;
            transition: all 0.5s ease;
            animation: pulse 3s ease-in-out infinite;
        }
        
        @keyframes pulse {
            0%, 100% { box-shadow: 0 0 0 0 rgba(255, 255, 255, 0.1); }
            50% { box-shadow: 0 0 0 20px rgba(255, 255, 255, 0); }
        }
        
        .logo-circle i {
            font-size: 48px;
            color: white;
            filter: drop-shadow(0 4px 8px rgba(0,0,0,0.3));
        }
        
        .brand-title {
            font-family: 'Playfair Display', serif;
            font-size: 42px;
            font-weight: 900;
            color: white;
            letter-spacing: 2px;
            margin-bottom: 8px;
            text-shadow: 0 2px 20px rgba(0,0,0,0.3);
        }
        
        .brand-subtitle {
            font-size: 14px;
            color: rgba(255, 255, 255, 0.7);
            letter-spacing: 4px;
            text-transform: uppercase;
            font-weight: 500;
        }
        
        .brand-tagline {
            font-family: 'Playfair Display', serif;
            font-style: italic;
            color: rgba(255, 255, 255, 0.5);
            margin-top: 32px;
            font-size: 16px;
            line-height: 1.6;
        }
        
        /* Right Panel - Form */
        .form-panel {
            flex: 1;
            background: #ffffff;
            padding: 60px 50px;
            display: flex;
            flex-direction: column;
            justify-content: center;
            position: relative;
        }
        
        .form-header {
            margin-bottom: 40px;
        }
        
        .form-header h2 {
            font-family: 'Playfair Display', serif;
            font-size: 32px;
            font-weight: 700;
            color: #1a0f0a;
            margin-bottom: 8px;
        }
        
        .form-header p {
            color: #8b7355;
            font-size: 14px;
            font-weight: 400;
        }
        
        .input-group {
            margin-bottom: 24px;
            position: relative;
        }
        
        .input-group label {
            display: block;
            font-size: 13px;
            font-weight: 600;
            color: #5c3a28;
            margin-bottom: 8px;
            letter-spacing: 0.5px;
            text-transform: uppercase;
        }
        
        .input-wrapper {
            position: relative;
        }
        
        .input-wrapper i {
            position: absolute;
            left: 16px;
            top: 50%;
            transform: translateY(-50%);
            color: #c5a582;
            font-size: 20px;
            transition: all 0.3s ease;
            z-index: 2;
        }
        
        .input-field {
            width: 100%;
            padding: 14px 16px 14px 48px;
            background: #fdf8f0;
            border: 2px solid #f2d7b6;
            border-radius: 16px;
            font-size: 15px;
            font-family: 'Inter', sans-serif;
            color: #3c2415;
            transition: all 0.3s ease;
            outline: none;
        }
        
        .input-field:focus {
            border-color: #c56a2b;
            background: #ffffff;
            box-shadow: 0 0 0 4px rgba(197, 106, 43, 0.08);
        }
        
        .input-field:focus ~ i,
        .input-wrapper:focus-within i {
            color: #c56a2b;
        }
        
        .input-field::placeholder {
            color: #c5a582;
            font-size: 14px;
        }
        
        .remember-row {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin: 28px 0;
        }
        
        .checkbox-wrapper {
            display: flex;
            align-items: center;
            gap: 10px;
            cursor: pointer;
        }
        
        .checkbox-wrapper input[type="checkbox"] {
            appearance: none;
            width: 20px;
            height: 20px;
            border: 2px solid #e9bb87;
            border-radius: 6px;
            cursor: pointer;
            position: relative;
            transition: all 0.2s ease;
            flex-shrink: 0;
        }
        
        .checkbox-wrapper input[type="checkbox"]:checked {
            background: #c56a2b;
            border-color: #c56a2b;
        }
        
        .checkbox-wrapper input[type="checkbox"]:checked::after {
            content: '';
            position: absolute;
            left: 6px;
            top: 2px;
            width: 5px;
            height: 10px;
            border: solid white;
            border-width: 0 2px 2px 0;
            transform: rotate(45deg);
        }
        
        .checkbox-wrapper span {
            font-size: 14px;
            color: #8b7355;
            font-weight: 500;
        }
        
        .forgot-link {
            font-size: 13px;
            color: #c56a2b;
            font-weight: 600;
            text-decoration: none;
            transition: all 0.2s ease;
        }
        
        .forgot-link:hover {
            color: #a45225;
            text-decoration: underline;
        }
        
        .login-btn {
            width: 100%;
            padding: 16px;
            background: linear-gradient(135deg, #5c3a28 0%, #8b4513 100%);
            color: white;
            border: none;
            border-radius: 16px;
            font-size: 16px;
            font-weight: 600;
            font-family: 'Inter', sans-serif;
            cursor: pointer;
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
            letter-spacing: 0.5px;
        }
        
        .login-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 30px rgba(107, 56, 32, 0.4);
        }
        
        .login-btn:active {
            transform: translateY(0);
            box-shadow: 0 4px 15px rgba(107, 56, 32, 0.3);
        }
        
        .login-btn::after {
            content: '';
            position: absolute;
            inset: 0;
            background: linear-gradient(135deg, transparent 0%, rgba(255,255,255,0.1) 50%, transparent 100%);
            transform: translateX(-100%);
            transition: transform 0.6s ease;
        }
        
        .login-btn:hover::after {
            transform: translateX(100%);
        }
        
        .error-message {
            background: #fef2f2;
            border: 1px solid #fecaca;
            color: #991b1b;
            padding: 14px 18px;
            border-radius: 14px;
            font-size: 13px;
            margin-bottom: 24px;
            display: flex;
            align-items: center;
            gap: 10px;
            animation: shake 0.5s ease;
        }
        
        @keyframes shake {
            0%, 100% { transform: translateX(0); }
            25% { transform: translateX(-8px); }
            75% { transform: translateX(8px); }
        }
        
        .footer-text {
            text-align: center;
            margin-top: 32px;
            font-size: 12px;
            color: #c5a582;
            letter-spacing: 0.5px;
        }
        
        .footer-text span {
            color: #c56a2b;
        }
        
        /* Responsive */
        @media (max-width: 768px) {
            .login-wrapper {
                flex-direction: column;
                min-height: auto;
                border-radius: 24px;
            }
            
            .brand-panel {
                padding: 40px 30px;
            }
            
            .brand-title {
                font-size: 32px;
            }
            
            .logo-circle {
                width: 80px;
                height: 80px;
            }
            
            .logo-circle i {
                font-size: 36px;
            }
            
            .form-panel {
                padding: 40px 30px;
            }
            
            .form-header h2 {
                font-size: 26px;
            }
            
            .brand-tagline {
                display: none;
            }
        }
    </style>
</head>
<body>
    <!-- Background Effects -->
    <div class="bg-pattern"></div>
    <div class="coffee-beans"></div>
    
    <!-- Login Container -->
    <div class="login-container">
        <div class="login-wrapper">
            
            <!-- Left Panel - Brand -->
            <div class="brand-panel">
                <div class="brand-content">
                    <div class="logo-circle">
                        <i class="ph ph-coffee"></i>
                    </div>
                    <h1 class="brand-title">CUMA</h1>
                    <p class="brand-subtitle">Cafe Management System</p>
                    <p class="brand-tagline">
                        "Where every cup<br>tells a story"
                    </p>
                </div>
            </div>
            
            <!-- Right Panel - Form -->
            <div class="form-panel">
                <div class="form-header">
                    <h2>Welcome Back</h2>
                    <p>Sign in to continue to your dashboard</p>
                </div>
                
                <!-- Error Messages -->
                @if($errors->any())
                    <div class="error-message">
                        <i class="ph ph-warning-circle text-red-500 text-xl"></i>
                        {{ $errors->first() }}
                    </div>
                @endif
                
                @if(session('error'))
                    <div class="error-message">
                        <i class="ph ph-warning-circle text-red-500 text-xl"></i>
                        {{ session('error') }}
                    </div>
                @endif
                
                <!-- Login Form -->
                <form method="POST" action="{{ route('login') }}">
                    @csrf
                    
                    <!-- Email -->
                    <div class="input-group">
                        <label>Email Address</label>
                        <div class="input-wrapper">
                            <i class="ph ph-envelope-simple"></i>
                            <input type="email" name="email" 
                                   value="{{ old('email') }}" 
                                   class="input-field" 
                                   placeholder="your@email.com" 
                                   required autofocus>
                        </div>
                    </div>
                    
                    <!-- Password -->
                    <div class="input-group">
                        <label>Password</label>
                        <div class="input-wrapper">
                            <i class="ph ph-lock-simple"></i>
                            <input type="password" name="password" 
                                   class="input-field" 
                                   placeholder="Enter your password" 
                                   required>
                        </div>
                    </div>
                    
                    <!-- Remember & Forgot -->
                    <div class="remember-row">
                        <label class="checkbox-wrapper">
                            <input type="checkbox" name="remember">
                            <span>Keep me signed in</span>
                        </label>
                        <a href="#" class="forgot-link">Forgot password?</a>
                    </div>
                    
                    <!-- Submit Button -->
                    <button type="submit" class="login-btn">
                        <i class="ph ph-sign-in mr-2"></i>
                        Sign In
                    </button>
                </form>
                
                <!-- Footer -->
                <p class="footer-text">
                    &copy; 2024 <span>CUMA Cafe</span>. All rights reserved.
                </p>
            </div>
            
        </div>
    </div>
    
    <script>
        // Focus animation for input fields
        document.querySelectorAll('.input-field').forEach(input => {
            input.addEventListener('focus', function() {
                this.parentElement.querySelector('i').style.transform = 'translateY(-50%) scale(1.1)';
            });
            
            input.addEventListener('blur', function() {
                this.parentElement.querySelector('i').style.transform = 'translateY(-50%) scale(1)';
            });
        });
        
        // Button click ripple effect
        document.querySelector('.login-btn').addEventListener('click', function(e) {
            const ripple = document.createElement('span');
            ripple.style.cssText = `
                position: absolute;
                background: rgba(255,255,255,0.3);
                border-radius: 50%;
                pointer-events: none;
                width: ${this.offsetWidth * 2}px;
                height: ${this.offsetWidth * 2}px;
                left: ${e.clientX - this.getBoundingClientRect().left - this.offsetWidth}px;
                top: ${e.clientY - this.getBoundingClientRect().top - this.offsetWidth}px;
                animation: ripple 0.6s ease-out forwards;
            `;
            this.appendChild(ripple);
            setTimeout(() => ripple.remove(), 600);
        });
        
        // Add ripple animation keyframes
        const style = document.createElement('style');
        style.textContent = `
            @keyframes ripple {
                to {
                    transform: scale(0);
                    opacity: 0;
                }
            }
        `;
        document.head.appendChild(style);
    </script>
</body>
</html>