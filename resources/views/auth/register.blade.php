<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ __('messages.register') }} - {{ config('app.name', 'Cabinet Médical') }}</title>
    
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
                    <h2 class="text-2xl font-bold text-gray-900">{{ __('messages.create_account') }}</h2>
                    <p class="text-gray-500 mt-2">{{ __('messages.register_subtitle') }}</p>
                </div>
                
                <!-- Form -->
                <form method="POST" action="{{ route('register') }}" class="space-y-5">
                    @csrf
                    
                    <!-- Name -->
                    <div>
                        <label for="name" class="block text-sm font-medium text-gray-700 mb-1.5">{{ __('messages.full_name') }}</label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                <i class="fa-solid fa-user text-gray-400"></i>
                            </div>
                            <input type="text" name="name" id="name" value="{{ old('name') }}" required
                                class="w-full pl-11 pr-4 py-3 bg-white border border-gray-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent {{ $errors->has('name') ? 'border-red-500' : '' }}"
                                placeholder="{{ __('messages.name_placeholder') }}">
                        </div>
                        @error('name')
                            <p class="mt-1.5 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                    
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
                    
                    <!-- Confirm Password -->
                    <div>
                        <label for="password_confirmation" class="block text-sm font-medium text-gray-700 mb-1.5">{{ __('messages.confirm_password') }}</label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                <i class="fa-solid fa-lock text-gray-400"></i>
                            </div>
                            <input type="password" name="password_confirmation" id="password_confirmation" required
                                class="w-full pl-11 pr-4 py-3 bg-white border border-gray-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent {{ $errors->has('password_confirmation') ? 'border-red-500' : '' }}"
                                placeholder="{{ __('messages.confirm_password_placeholder') }}">
                        </div>
                        @error('password_confirmation')
                            <p class="mt-1.5 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                    
                    <!-- Terms -->
                    <div>
                        <label class="flex items-start gap-3 cursor-pointer">
                            <input type="checkbox" name="terms" required class="mt-1 w-4 h-4 text-blue-600 border-gray-300 rounded focus:ring-blue-500">
                            <span class="text-sm text-gray-600">
                                {{ __('messages.agree_terms') }}
                                <a href="#" class="text-blue-600 hover:text-blue-700 font-medium">{{ __('messages.terms_of_service') }}</a>
                                {{ __('messages.and') }}
                                <a href="#" class="text-blue-600 hover:text-blue-700 font-medium">{{ __('messages.privacy_policy') }}</a>
                            </span>
                        </label>
                        @error('terms')
                            <p class="mt-1.5 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                    
                    <!-- Submit -->
                    <button type="submit" class="w-full py-3 bg-blue-600 text-white rounded-xl font-medium hover:bg-blue-700 transition-colors focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">
                        {{ __('messages.create_account') }}
                    </button>
                </form>
                
                <!-- Login Link -->
                <div class="mt-8 text-center">
                    <p class="text-sm text-gray-500">
                        {{ __('messages.already_account') }}
                        <a href="{{ route('login') }}" class="text-blue-600 hover:text-blue-700 font-medium">
                            {{ __('messages.sign_in') }}
                        </a>
                    </p>
                </div>
            </div>
        </div>
        
        <!-- Right Side - Image/Pattern -->
        <div class="hidden lg:flex lg:w-1/2 bg-gradient-to-br from-blue-600 to-blue-800 items-center justify-center p-12">
            <div class="text-center text-white">
                <div class="w-24 h-24 bg-white/10 rounded-2xl flex items-center justify-center mx-auto mb-6">
                    <i class="fa-solid fa-user-plus text-4xl"></i>
                </div>
                <h3 class="text-2xl font-bold mb-3">{{ __('messages.join_our_platform') }}</h3>
                <p class="text-blue-100 max-w-md mx-auto">{{ __('messages.register_description') }}</p>
            </div>
        </div>
    </div>
</body>
</html>