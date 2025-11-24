<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }} - Email Verification</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        .gradient-bg {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        }
    </style>
</head>

<body class="antialiased">
    <div class="min-h-screen gradient-bg flex items-center justify-center px-4 sm:px-6 lg:px-8">
        <div class="max-w-md w-full">
            <!-- Logo/Brand -->
            <div class="text-center mb-8">
                <h1 class="text-4xl font-bold text-white mb-2">{{ config('app.name', 'Laravel') }}</h1>
                <p class="text-purple-200">Email Verification Required</p>
            </div>

            <!-- Card Container -->
            <div class="bg-white rounded-2xl shadow-2xl p-8">
                <!-- Decorative Element -->
                <div class="absolute top-0 left-0 w-full h-2 gradient-bg"></div>

                <div class="text-center mb-6">
                    <svg class="mx-auto h-16 w-16 text-purple-600" fill="none" stroke="currentColor"
                        viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z">
                        </path>
                    </svg>
                </div>

                <div class="text-center mb-6">
                    <h2 class="text-2xl font-bold text-gray-800 mb-4">Verify Your Email</h2>
                    <p class="text-gray-600 mb-4">
                        Thanks for signing up! Before getting started, could you verify your email address by clicking
                        on the link we just emailed to you?
                    </p>
                    <p class="text-gray-600">
                        If you didn't receive the email, we will gladly send you another.
                    </p>
                </div>


                <div class="flex items-center justify-between gap-4">
                    <form method="POST" action="{{ route('verification.send') }}" class="flex-1">
                        @csrf
                        <button type="submit"
                            class="w-full gradient-bg text-white py-3 rounded-lg font-semibold hover:shadow-lg transform hover:-translate-y-0.5 transition-all duration-300">
                            Resend Verification Email
                        </button>
                    </form>
                </div>

                <div class="mt-6 text-center">
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit"
                            class="text-sm text-purple-600 hover:text-purple-800 transition-colors duration-300">
                            Log Out
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.7.32/dist/sweetalert2.all.min.js"></script>
    <script>
        @if (session('status') == 'verification-link-sent')
            Swal.fire({
                icon: 'success',
                title: 'Email Sent!',
                text: 'A new verification link has been sent to your email address.',
                showConfirmButton: false,
                timer: 3000,
                timerProgressBar: true,
            });
        @endif
    </script>
</body>

</html>
