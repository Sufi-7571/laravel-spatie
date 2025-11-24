<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }} - Login</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <!-- Google reCAPTCHA -->
    @if(config('services.recaptcha.site_key') && config('services.recaptcha.site_key') !== 'skip')
        <script src="https://www.google.com/recaptcha/api.js" async defer></script>
    @endif

    <!-- SweetAlert2 CDN -->
    <link href="https://cdn.jsdelivr.net/npm/sweetalert2@11.7.32/dist/sweetalert2.min.css" rel="stylesheet">

    <style>
        .forms-wrapper {
            position: relative;
            overflow: hidden;
        }

        .form-container {
            transition: transform 0.5s cubic-bezier(0.68, -0.55, 0.265, 1.55), opacity 0.5s ease;
            width: 100%;
        }

        .slide-left {
            transform: translateX(-100%);
            opacity: 0;
            position: absolute;
            top: 0;
            left: 0;
        }

        .slide-right {
            transform: translateX(100%);
            opacity: 0;
            position: absolute;
            top: 0;
            left: 0;
        }

        .slide-center {
            transform: translateX(0);
            opacity: 1;
            position: relative;
        }

        .gradient-bg {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        }

        .input-focus {
            transition: all 0.3s ease;
        }

        .input-focus:focus {
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(102, 126, 234, 0.4);
        }

        /* Google Button Styles */
        .google-btn {
            display: flex;
            align-items: center;
            justify-content: center;
            width: 100%;
            padding: 12px 16px;
            border: 2px solid #e5e7eb;
            border-radius: 10px;
            background-color: #ffffff;
            color: #374151;
            font-weight: 600;
            font-size: 0.95rem;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .google-btn:hover {
            background-color: #f9fafb;
            border-color: #d1d5db;
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        }

        .google-btn:active {
            transform: translateY(0);
        }

        .google-btn svg {
            margin-right: 12px;
        }

        /* Divider Styles */
        .divider {
            display: flex;
            align-items: center;
            margin: 24px 0;
        }

        .divider::before,
        .divider::after {
            content: '';
            flex: 1;
            height: 1px;
            background: linear-gradient(to right, transparent, #e5e7eb, transparent);
        }

        .divider span {
            padding: 0 16px;
            color: #9ca3af;
            font-size: 0.85rem;
            font-weight: 500;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        /* Custom SweetAlert styling */
        .swal2-popup {
            border-radius: 15px !important;
        }

        .swal2-title {
            font-size: 1.5rem !important;
            font-weight: 700 !important;
        }

        .swal2-html-container {
            font-size: 0.95rem !important;
        }
    </style>
</head>

<body class="antialiased">
    <div class="min-h-screen gradient-bg flex items-center justify-center px-4 sm:px-6 lg:px-8">
        <div class="max-w-md w-full">
            <!-- Logo/Brand -->
            <div class="text-center mb-8">
                <h1 class="text-4xl font-bold text-white mb-2">{{ config('app.name', 'Laravel') }}</h1>
                <p class="text-purple-200">Welcome back! Please login to your account.</p>
            </div>

            <!-- Card Container -->
            <div class="bg-white rounded-2xl shadow-2xl p-8 relative overflow-hidden">
                <!-- Decorative Element -->
                <div class="absolute top-0 left-0 w-full h-2 gradient-bg"></div>

                <!-- Toggle Buttons -->
                <div class="flex mb-8 bg-gray-100 rounded-lg p-1">
                    <button id="loginTabBtn" onclick="showLogin()"
                        class="flex-1 py-2 px-4 rounded-md text-sm font-medium transition-all duration-300 text-white gradient-bg">
                        Login
                    </button>
                    <button id="registerTabBtn" onclick="showRegister()"
                        class="flex-1 py-2 px-4 rounded-md text-sm font-medium transition-all duration-300 text-gray-600 hover:text-gray-800">
                        Register
                    </button>
                </div>

                <!-- Forms Wrapper -->
                <div class="forms-wrapper" style="min-height: 580px;">
                    <!-- Login Form -->
                    <div id="loginForm" class="form-container slide-center">
                        <!-- Google Sign In Button -->
                        <a href="{{ route('google.redirect') }}" class="google-btn">
                            <svg width="20" height="20" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path d="M22.56 12.25c0-.78-.07-1.53-.2-2.25H12v4.26h5.92c-.26 1.37-1.04 2.53-2.21 3.31v2.77h3.57c2.08-1.92 3.28-4.74 3.28-8.09z" fill="#4285F4"/>
                                <path d="M12 23c2.97 0 5.46-.98 7.28-2.66l-3.57-2.77c-.98.66-2.23 1.06-3.71 1.06-2.86 0-5.29-1.93-6.16-4.53H2.18v2.84C3.99 20.53 7.7 23 12 23z" fill="#34A853"/>
                                <path d="M5.84 14.09c-.22-.66-.35-1.36-.35-2.09s.13-1.43.35-2.09V7.07H2.18C1.43 8.55 1 10.22 1 12s.43 3.45 1.18 4.93l2.85-2.22.81-.62z" fill="#FBBC05"/>
                                <path d="M12 5.38c1.62 0 3.06.56 4.21 1.64l3.15-3.15C17.45 2.09 14.97 1 12 1 7.7 1 3.99 3.47 2.18 7.07l3.66 2.84c.87-2.6 3.3-4.53 6.16-4.53z" fill="#EA4335"/>
                            </svg>
                            Sign in with Google
                        </a>

                        <!-- Divider -->
                        <div class="divider">
                            <span>or sign in with email</span>
                        </div>

                        <form method="POST" action="{{ route('login') }}">
                            @csrf

                            <!-- Email Address -->
                            <div class="mb-5">
                                <label for="login_email" class="block text-sm font-medium text-gray-700 mb-2">
                                    Email Address
                                </label>
                                <input id="login_email" type="email" name="email" value="{{ old('email') }}"
                                    required autofocus autocomplete="username"
                                    class="input-focus w-full px-4 py-3 rounded-lg border border-gray-300 focus:ring-2 focus:ring-purple-500 focus:border-transparent transition-all duration-300"
                                    placeholder="you@example.com">
                            </div>

                            <!-- Password -->
                            <div class="mb-5">
                                <label for="login_password" class="block text-sm font-medium text-gray-700 mb-2">
                                    Password
                                </label>
                                <input id="login_password" type="password" name="password" required
                                    autocomplete="current-password"
                                    class="input-focus w-full px-4 py-3 rounded-lg border border-gray-300 focus:ring-2 focus:ring-purple-500 focus:border-transparent transition-all duration-300"
                                    placeholder="••••••••">
                            </div>

                            <!-- reCAPTCHA -->
                            @if(config('services.recaptcha.site_key') && config('services.recaptcha.site_key') !== 'skip')
                                <div class="mb-5 flex justify-center">
                                    <div class="g-recaptcha" data-sitekey="{{ config('services.recaptcha.site_key') }}"></div>
                                </div>
                            @endif

                            <!-- Remember Me -->
                            <div class="flex items-center justify-between mb-5">
                                <label class="flex items-center">
                                    <input type="checkbox" name="remember"
                                        class="w-4 h-4 text-purple-600 border-gray-300 rounded focus:ring-purple-500">
                                    <span class="ml-2 text-sm text-gray-600">Remember me</span>
                                </label>

                                @if (Route::has('password.request'))
                                    <a href="{{ route('password.request') }}"
                                        class="text-sm text-purple-600 hover:text-purple-800 transition-colors duration-300">
                                        Forgot password?
                                    </a>
                                @endif
                            </div>

                            <!-- Submit Button -->
                            <button type="submit"
                                class="w-full gradient-bg text-white py-3 rounded-lg font-semibold hover:shadow-lg transform hover:-translate-y-0.5 transition-all duration-300">
                                Sign In
                            </button>
                        </form>
                    </div>

                    <!-- Register Form -->
                    <div id="registerForm" class="form-container slide-right">
                        <!-- Google Sign Up Button -->
                        <a href="{{ route('google.redirect') }}" class="google-btn">
                            <svg width="20" height="20" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path d="M22.56 12.25c0-.78-.07-1.53-.2-2.25H12v4.26h5.92c-.26 1.37-1.04 2.53-2.21 3.31v2.77h3.57c2.08-1.92 3.28-4.74 3.28-8.09z" fill="#4285F4"/>
                                <path d="M12 23c2.97 0 5.46-.98 7.28-2.66l-3.57-2.77c-.98.66-2.23 1.06-3.71 1.06-2.86 0-5.29-1.93-6.16-4.53H2.18v2.84C3.99 20.53 7.7 23 12 23z" fill="#34A853"/>
                                <path d="M5.84 14.09c-.22-.66-.35-1.36-.35-2.09s.13-1.43.35-2.09V7.07H2.18C1.43 8.55 1 10.22 1 12s.43 3.45 1.18 4.93l2.85-2.22.81-.62z" fill="#FBBC05"/>
                                <path d="M12 5.38c1.62 0 3.06.56 4.21 1.64l3.15-3.15C17.45 2.09 14.97 1 12 1 7.7 1 3.99 3.47 2.18 7.07l3.66 2.84c.87-2.6 3.3-4.53 6.16-4.53z" fill="#EA4335"/>
                            </svg>
                            Sign up with Google
                        </a>

                        <!-- Divider -->
                        <div class="divider">
                            <span>or register with email</span>
                        </div>

                        <form method="POST" action="{{ route('register') }}">
                            @csrf

                            <!-- Name -->
                            <div class="mb-5">
                                <label for="register_name" class="block text-sm font-medium text-gray-700 mb-2">
                                    Full Name
                                </label>
                                <input id="register_name" type="text" name="name" value="{{ old('name') }}"
                                    required autocomplete="name"
                                    class="input-focus w-full px-4 py-3 rounded-lg border border-gray-300 focus:ring-2 focus:ring-purple-500 focus:border-transparent transition-all duration-300"
                                    placeholder="John Doe">
                            </div>

                            <!-- Email Address -->
                            <div class="mb-5">
                                <label for="register_email" class="block text-sm font-medium text-gray-700 mb-2">
                                    Email Address
                                </label>
                                <input id="register_email" type="email" name="email" value="{{ old('email') }}"
                                    required autocomplete="username"
                                    class="input-focus w-full px-4 py-3 rounded-lg border border-gray-300 focus:ring-2 focus:ring-purple-500 focus:border-transparent transition-all duration-300"
                                    placeholder="you@example.com">
                            </div>

                            <!-- Password -->
                            <div class="mb-5">
                                <label for="register_password" class="block text-sm font-medium text-gray-700 mb-2">
                                    Password
                                </label>
                                <input id="register_password" type="password" name="password" required
                                    autocomplete="new-password"
                                    class="input-focus w-full px-4 py-3 rounded-lg border border-gray-300 focus:ring-2 focus:ring-purple-500 focus:border-transparent transition-all duration-300"
                                    placeholder="••••••••">
                            </div>

                            <!-- Confirm Password -->
                            <div class="mb-5">
                                <label for="password_confirmation" class="block text-sm font-medium text-gray-700 mb-2">
                                    Confirm Password
                                </label>
                                <input id="password_confirmation" type="password" name="password_confirmation"
                                    required autocomplete="new-password"
                                    class="input-focus w-full px-4 py-3 rounded-lg border border-gray-300 focus:ring-2 focus:ring-purple-500 focus:border-transparent transition-all duration-300"
                                    placeholder="••••••••">
                            </div>

                            <!-- Submit Button -->
                            <button type="submit"
                                class="w-full gradient-bg text-white py-3 rounded-lg font-semibold hover:shadow-lg transform hover:-translate-y-0.5 transition-all duration-300">
                                Create Account
                            </button>
                        </form>
                    </div>
                </div>

                <!-- Footer Text -->
                <div class="mt-6 text-center text-sm text-gray-500">
                    <p>By continuing, you agree to our 
                        <a href="#" class="text-purple-600 hover:underline">Terms of Service</a> and 
                        <a href="#" class="text-purple-600 hover:underline">Privacy Policy</a>.
                    </p>
                </div>
            </div>
        </div>
    </div>

    <!-- Form Toggle Script -->
    <script>
        function showLogin() {
            const loginForm = document.getElementById('loginForm');
            const registerForm = document.getElementById('registerForm');
            const loginBtn = document.getElementById('loginTabBtn');
            const registerBtn = document.getElementById('registerTabBtn');

            registerForm.classList.remove('slide-center');
            registerForm.classList.add('slide-right');

            loginForm.classList.remove('slide-left');
            loginForm.classList.add('slide-center');

            loginBtn.classList.add('text-white', 'gradient-bg');
            loginBtn.classList.remove('text-gray-600');

            registerBtn.classList.remove('text-white', 'gradient-bg');
            registerBtn.classList.add('text-gray-600');
        }

        function showRegister() {
            const loginForm = document.getElementById('loginForm');
            const registerForm = document.getElementById('registerForm');
            const loginBtn = document.getElementById('loginTabBtn');
            const registerBtn = document.getElementById('registerTabBtn');

            loginForm.classList.remove('slide-center');
            loginForm.classList.add('slide-left');

            registerForm.classList.remove('slide-right');
            registerForm.classList.add('slide-center');

            registerBtn.classList.add('text-white', 'gradient-bg');
            registerBtn.classList.remove('text-gray-600');

            loginBtn.classList.remove('text-white', 'gradient-bg');
            loginBtn.classList.add('text-gray-600');
        }

        @if ($errors->has('name') || $errors->has('password_confirmation') || (old('name') && $errors->any()))
            document.addEventListener('DOMContentLoaded', function() {
                showRegister();
            });
        @endif
    </script>

    <!-- SweetAlert2 JS -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.7.32/dist/sweetalert2.all.min.js"></script>

    <!-- SweetAlert Messages -->
    <script>
        // Registration success message
        @if (session('registered'))
            Swal.fire({
                icon: 'success',
                title: '🎉 Registration Successful!',
                html: `
                    <div style="text-align: center; line-height: 1.8;">
                        <p style="font-size: 1rem; margin-bottom: 15px;">
                            Your account has been created successfully!
                        </p>
                        <div style="background: #f0f9ff; padding: 15px; border-radius: 10px; margin: 15px 0; border-left: 4px solid #667eea;">
                            <p style="margin: 0; color: #1e40af; font-weight: 600;">
                                📧 Verification Email Sent
                            </p>
                            <p style="margin: 10px 0 0 0; font-size: 0.9rem; color: #374151;">
                                Please check your inbox at:<br>
                                <strong style="color: #667eea;">{{ session('registered_email') }}</strong>
                            </p>
                        </div>
                        <p style="font-size: 0.9rem; color: #6b7280; margin-top: 15px;">
                            You must verify your email before you can log in.
                        </p>
                    </div>
                `,
                showConfirmButton: true,
                confirmButtonText: 'Got it!',
                confirmButtonColor: '#667eea',
                allowOutsideClick: false,
                width: '500px'
            });
        @endif

        // Success status messages (Google login, email verified, etc.)
        @if (session('status'))
            Swal.fire({
                icon: 'success',
                title: '✅ Success!',
                text: '{{ session('status') }}',
                showConfirmButton: true,
                confirmButtonText: 'OK',
                confirmButtonColor: '#667eea'
            });
        @endif

        // Error messages (Google login failed, etc.)
        @if (session('error'))
            Swal.fire({
                icon: 'error',
                title: '❌ Error!',
                text: '{{ session('error') }}',
                showConfirmButton: true,
                confirmButtonText: 'OK',
                confirmButtonColor: '#667eea'
            });
        @endif

        // Login errors
        @if ($errors->any() && !$errors->has('name') && !$errors->has('password_confirmation') && !old('name'))
            Swal.fire({
                icon: 'error',
                title: '❌ Login Failed',
                html: `
                    <ul style="text-align: left; list-style: none; padding: 0; margin: 20px 0;">
                        @foreach ($errors->all() as $error)
                            <li style="margin-bottom: 10px; padding: 10px; background: #fef2f2; border-left: 3px solid #ef4444; border-radius: 5px; color: #991b1b;">
                                • {{ $error }}
                            </li>
                        @endforeach
                    </ul>
                `,
                showConfirmButton: true,
                confirmButtonText: 'Try Again',
                confirmButtonColor: '#667eea',
                width: '500px'
            });
        @endif

        // Registration errors
        @if (($errors->has('name') || $errors->has('password_confirmation') || old('name')) && $errors->any())
            Swal.fire({
                icon: 'error',
                title: '❌ Registration Failed',
                html: `
                    <ul style="text-align: left; list-style: none; padding: 0; margin: 20px 0;">
                        @foreach ($errors->all() as $error)
                            <li style="margin-bottom: 10px; padding: 10px; background: #fef2f2; border-left: 3px solid #ef4444; border-radius: 5px; color: #991b1b;">
                                • {{ $error }}
                            </li>
                        @endforeach
                    </ul>
                `,
                showConfirmButton: true,
                confirmButtonText: 'Try Again',
                confirmButtonColor: '#667eea',
                width: '500px'
            });
        @endif
    </script>
</body>

</html>