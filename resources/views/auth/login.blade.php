<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ __('messages.login') }} - {{ config('app.name', 'Cabinet Médical') }}</title>
    
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700&display=swap" rel="stylesheet" />
    
    <!-- Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />
    
    <!-- Styles / Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-50 font-sans antialiased">
    <div class="min-h-screen flex">
        <!-- Left Side - Form -->
        <div class="flex-1 flex items-center justify-center p-8">
            <div class="w-full max-w-md">
                <!-- Logo -->
                <div class="flex items-center gap-3 mb-8">
                    <div class="w-12 h-12 bg-blue-600 rounded-xl flex items-center justify-center">
                        <i class="fa-solid fa-staff-snake text-white text-xl"></i>
                    </div>
                    <div>
                        <h1 class="text-xl font-semibold text-gray-900">{{ __('messages.cabinet_medical') }}</h1>
                        <p class="text-sm text-gray-500">{{ __('messages.admin_portal') }}</p>
                    </div>
                </div>
                
                <!-- Header -->
                <div class="mb-8">
                    <h2 class="text-2xl font-bold text-gray-900">{{ __('messages.welcome_back') }}</h2>
                    <p class="text-gray-500 mt-2">{{ __('messages.login_subtitle') }}</p>
                </div>
                
                <!-- Form -->
                <form method="POST" action="{{ route('login') }}" class="space-y-5">
                    @csrf
                    
                    <!-- Email -->
                    <div>
                        <label for="email" class="block text-sm font-medium text-gray-700 mb-1.5">{{ __('messages.email') }}</label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                <i class="fa-regular fa-envelope text-gray-400"></i>
                            </div>
                            <input type="email" name="email" id="email" value="{{ old('email') }}" required
                                class="w-full pl-11 pr-4 py-3 bg-white border border-gray-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent {{ $errors->has('email') ? 'border-red-500' : '' }}"
                                placeholder="{{ __('messages.email_placeholder') }}">
                        </div>
                        @error('email')
                            <p class="mt-1.5 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                    
                    <!-- Password -->
                    <div>
                        <label for="password" class="block text-sm font-medium text-gray-700 mb-1.5">{{ __('messages.password') }}</label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                <i class="fa-solid fa-lock text-gray-400"></i>
                            </div>
                            <input type="password" name="password" id="password" required
                                class="w-full pl-11 pr-4 py-3 bg-white border border-gray-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent {{ $errors->has('password') ? 'border-red-500' : '' }}"
                                placeholder="{{ __('messages.password_placeholder') }}">
                        </div>
                        @error('password')
                            <p class="mt-1.5 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                    
                    <!-- Remember & Forgot -->
                    <div class="flex items-center justify-between">
                        <label class="flex items-center gap-2 cursor-pointer">
                            <input type="checkbox" name="remember" class="w-4 h-4 text-blue-600 border-gray-300 rounded focus:ring-blue-500">
                            <span class="text-sm text-gray-600">{{ __('messages.remember_me') }}</span>
                        </label>
                        @if (Route::has('password.request'))
                            <a href="{{ route('password.request') }}" class="text-sm text-blue-600 hover:text-blue-700 font-medium">
                                {{ __('messages.forgot_password') }}
                            </a>
                        @endif
                    </div>
                    
                    <!-- Submit -->
                    <button type="submit" class="w-full py-3 bg-blue-600 text-white rounded-xl font-medium hover:bg-blue-700 transition-colors focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">
                        {{ __('messages.sign_in') }}
                    </button>
                </form>
                
                <!-- Register Link -->
                @if (Route::has('register'))
                <div class="mt-8 text-center">
                    <p class="text-sm text-gray-500">
                        {{ __('messages.no_account') }}
                        <a href="{{ route('register') }}" class="text-blue-600 hover:text-blue-700 font-medium">
                            {{ __('messages.create_account') }}
                        </a>
                    </p>
                </div>
                @endif
            </div>
        </div>
        
        <!-- Right Side - Image/Pattern -->
        <div class="hidden lg:flex lg:w-1/2 bg-gradient-to-br from-blue-600 to-blue-800 items-center justify-center p-12">
            <div class="text-center text-white">
                <div class="w-24 h-24 bg-white/10 rounded-2xl flex items-center justify-center mx-auto mb-6">
                    <i class="fa-solid fa-staff-snake text-4xl"></i>
                </div>
                <h3 class="text-2xl font-bold mb-3">{{ __('messages.manage_your_clinic') }}</h3>
                <p class="text-blue-100 max-w-md mx-auto">{{ __('messages.login_description') }}</p>
            </div>
        </div>
    </div>
</body>
</html>