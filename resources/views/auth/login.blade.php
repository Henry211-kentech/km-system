<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Login - KM System</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        html, body {
            min-height: 100%;
            height: 100%;
            margin: 0;
            padding: 0;
        }

        body {
            display: flex;
            align-items: center;
            justify-content: center;
            background: #0f172a;
            overflow: auto;
        }

        .login-card {
            width: min(100%, 420px);
            margin: 1.5rem;
            background: rgba(255, 255, 255, 0.92);
            backdrop-filter: blur(14px);
            border: 1px solid rgba(255, 255, 255, 0.22);
            box-shadow: 0 35px 65px rgba(12, 22, 45, 0.42);
        }

        .login-wrapper {
            min-height: 100vh;
            padding: 2rem 1rem;
            z-index: 2;
            position: relative;
        }

        .bg-video {
            position: fixed;
            top: 0;
            left: 0;
            width: 100vw;
            height: 100vh;
            object-fit: cover;
            z-index: 0;
            opacity: 0.25;
        }

        @media (max-width: 640px) {
            .login-card {
                padding: 1.5rem !important;
            }

            .login-wrapper {
                padding: 1rem 0.5rem;
            }
        }
    </style>
</head>
<body>
    <video class="bg-video hidden sm:block" autoplay loop muted playsinline poster="/logo.png">
        <source src="/Lamborghini Videos, Download The BEST Free 4k Stock Video Footage & Lamborghini HD Video Clips.mp4" type="video/mp4">
    </video>
    <div class="login-wrapper">
        <div class="min-h-[calc(100vh-4rem)] flex items-center justify-center py-6 px-4 sm:px-6 lg:px-8">
            <div class="max-w-md w-full space-y-8">
                <div class="login-card rounded-2xl shadow-2xl p-8 border border-gray-200 bg-white/80 backdrop-blur-md">
                    <div class="text-center mb-8">
                        <img src="/logo.png" alt="KM Logo" class="mx-auto h-16 w-16 rounded-full shadow-lg bg-white object-contain p-2">
                        <h2 class="mt-6 text-3xl font-extrabold text-gray-900 drop-shadow-lg">
                            Welcome to KM System
                        </h2>
                        <p class="mt-2 text-sm text-gray-700">Km-Automobile Garage Management System</p>
                    </div>

                    <form class="space-y-6" action="{{ route('login') }}" method="POST">
                        @csrf

                        <!-- Email Field -->
                        <div>
                            <label for="email" class="block text-sm font-medium text-gray-700 mb-2">
                                <i class="fas fa-envelope text-blue-500 mr-2"></i>Email Address
                            </label>
                            <input
                                id="email"
                                name="email"
                                type="email"
                                autocomplete="email"
                                required
                                class="appearance-none 
                                relative block w-full px-4 py-3 border border-gray-300 placeholder-gray-500 text-gray-900 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 focus:z-10 sm:text-sm transition @error('email') border-red-500 focus:border-red-500 focus:ring-red-500 @enderror"
                                placeholder="Enter your email"
                                value="{{ old('email') }}"
                            >
                            @error('email')
                                <p class="mt-2 text-sm text-red-600 flex items-center gap-1">
                                    <i class="fas fa-exclamation-circle"></i> {{ $message }}
                                </p>
                            @enderror
                        </div>

                        <!-- Password Field -->
                        <div>
                            <label for="password" class="block text-sm font-medium text-gray-700 mb-2">
                                <i class="fas fa-lock text-blue-500 mr-2"></i>Password
                            </label>
                            <input
                                id="password"
                                name="password"
                                type="password"
                                autocomplete="current-password"
                                required
                                class="appearance-none relative block w-full px-4 py-3 border border-gray-300 placeholder-gray-500 text-gray-900 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 focus:z-10 sm:text-sm transition @error('password') border-red-500 focus:border-red-500 focus:ring-red-500 @enderror"
                                placeholder="Enter your password"
                            >
                            @error('password')
                                <p class="mt-2 text-sm text-red-600 flex items-center gap-1">
                                    <i class="fas fa-exclamation-circle"></i> {{ $message }}
                                </p>
                            @enderror
                        </div>

                        <!-- Remember Me -->
                        <div class="flex items-center justify-between">
                            <div class="flex items-center">
                                <input
                                    id="remember-me"
                                    name="remember"
                                    type="checkbox"
                                    class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded"
                                >
                                <label for="remember-me" class="ml-2 block text-sm text-gray-700">
                                    Remember me
                                </label>
                            </div>
                        </div>

                        <!-- Submit Button -->
                        <div>
                            <button
                                type="submit"
                                class="group relative w-full flex justify-center py-3 px-4 border border-transparent text-sm font-medium rounded-lg text-white bg-gradient-to-r from-blue-600 to-purple-600 hover:from-blue-700 hover:to-purple-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition transform hover:scale-105 shadow-lg"
                            >
                                <span class="absolute left-0 inset-y-0 flex items-center pl-3">
                                    <i class="fas fa-sign-in-alt text-blue-200 group-hover:text-blue-100"></i>
                                </span>
                                Sign In
                            </button>
                        </div>
                    </form>

                    <!-- Footer -->
                    <div class="mt-6 text-center">
                        <p class="text-sm text-gray-600">
                            <i class="fas fa-shield-alt text-green-500 mr-1"></i>
                            Secure login powered by Laravel
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Background Pattern -->
    <div class="fixed inset-0 z-[-1]">
        <div class="absolute inset-0 bg-gray-900 opacity-25"></div>
        <div class="absolute inset-0" style="background-image: radial-gradient(circle at 25% 25%, rgba(255,255,255,0.1) 0%, transparent 50%), radial-gradient(circle at 75% 75%, rgba(255,255,255,0.1) 0%, transparent 50%);"></div>
    </div>
</body>
</html>