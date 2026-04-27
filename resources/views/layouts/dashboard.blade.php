<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'Cabinet Médical') }}</title>
    
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
        <!-- Sidebar -->
        <aside class="fixed inset-y-0 left-0 z-50 w-64 bg-white border-r border-gray-200 transform transition-transform duration-300 lg:translate-x-0" id="sidebar">
            <!-- Logo -->
            <div class="h-16 flex items-center px-6 border-b border-gray-100">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 bg-blue-600 rounded-lg flex items-center justify-center">
                        <i class="fa-solid fa-staff-snake text-white text-lg"></i>
                    </div>
                    <div>
                        <h1 class="text-lg font-semibold text-gray-900">{{ __('messages.cabinet_medical') }}</h1>
                        <p class="text-xs text-gray-500">{{ __('messages.dashboard') }}</p>
                    </div>
                </div>
            </div>
            
            <!-- Navigation -->
            <nav class="p-4 space-y-1">
                <a href="{{ route('dashboard') }}" class="flex items-center gap-3 px-4 py-3 rounded-lg text-gray-700 hover:bg-blue-50 hover:text-blue-600 transition-colors {{ request()->routeIs('dashboard') ? 'bg-blue-50 text-blue-600 font-medium' : '' }}">
                    <i class="fa-solid fa-chart-line w-5 text-center"></i>
                    <span>{{ __('messages.dashboard') }}</span>
                </a>
                
                <a href="{{ route('appointments.index') }}" class="flex items-center gap-3 px-4 py-3 rounded-lg text-gray-700 hover:bg-blue-50 hover:text-blue-600 transition-colors {{ request()->routeIs('appointments.*') ? 'bg-blue-50 text-blue-600 font-medium' : '' }}">
                    <i class="fa-solid fa-calendar-check w-5 text-center"></i>
                    <span>{{ __('messages.appointments') }}</span>
                </a>
                
                <a href="{{ route('services.index') }}" class="flex items-center gap-3 px-4 py-3 rounded-lg text-gray-700 hover:bg-blue-50 hover:text-blue-600 transition-colors {{ request()->routeIs('services.*') ? 'bg-blue-50 text-blue-600 font-medium' : '' }}">
                    <i class="fa-solid fa-hand-holding-medical w-5 text-center"></i>
                    <span>{{ __('messages.services') }}</span>
                </a>
            </nav>
            
            <!-- Logout -->
            <div class="absolute bottom-0 left-0 right-0 p-4 border-t border-gray-100">
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="flex items-center gap-3 px-4 py-3 w-full rounded-lg text-gray-700 hover:bg-red-50 hover:text-red-600 transition-colors">
                        <i class="fa-solid fa-right-from-bracket w-5 text-center"></i>
                        <span>{{ __('messages.logout') }}</span>
                    </button>
                </form>
            </div>
        </aside>
        
        <!-- Mobile overlay -->
        <div class="fixed inset-0 bg-gray-900/50 z-40 lg:hidden hidden" id="sidebar-overlay"></div>
        
        <!-- Main content -->
        <div class="flex-1 lg:ml-64">
            <!-- Top Navbar -->
            <header class="h-16 bg-white border-b border-gray-200 flex items-center justify-between px-4 lg:px-8 sticky top-0 z-30">
                <!-- Mobile menu button -->
                <button class="lg:hidden p-2 rounded-lg hover:bg-gray-100" id="mobile-menu-btn">
                    <i class="fa-solid fa-bars text-gray-600"></i>
                </button>
                
                <!-- Search (optional) -->
                <div class="hidden md:block flex-1 max-w-md">
                    <div class="relative">
                        <i class="fa-solid fa-magnifying-glass absolute left-3 top-1/2 -translate-y-1/2 text-gray-400"></i>
                        <input type="text" placeholder="{{ __('messages.search_placeholder') }}" class="w-full pl-10 pr-4 py-2 bg-gray-50 border border-gray-200 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                    </div>
                </div>
                
                <!-- Right side -->
                <div class="flex items-center gap-4">
                    <!-- Language selector -->
                    <div class="relative">
                        <button class="flex items-center gap-2 px-3 py-2 text-sm text-gray-600 hover:text-gray-900">
                            <i class="fa-solid fa-globe"></i>
                            <span class="hidden sm:inline">{{ strtoupper(app()->getLocale()) }}</span>
                            <i class="fa-solid fa-chevron-down text-xs"></i>
                        </button>
                    </div>
                    
                    <!-- User menu -->
                    <div class="flex items-center gap-3">
                        <div class="w-8 h-8 bg-blue-100 rounded-full flex items-center justify-center">
                            <i class="fa-solid fa-user text-blue-600 text-sm"></i>
                        </div>
                        <span class="hidden sm:block text-sm font-medium text-gray-700">{{ Auth::user()->name ?? __('messages.guest') }}</span>
                    </div>
                </div>
            </header>
            
            <!-- Page content -->
            <main class="p-4 lg:p-8">
                @yield('content')
            </main>
        </div>
    </div>
    
    <script>
        // Mobile menu toggle
        const mobileMenuBtn = document.getElementById('mobile-menu-btn');
        const sidebar = document.getElementById('sidebar');
        const sidebarOverlay = document.getElementById('sidebar-overlay');
        
        mobileMenuBtn.addEventListener('click', () => {
            sidebar.classList.toggle('-translate-x-full');
            sidebarOverlay.classList.toggle('hidden');
        });
        
        sidebarOverlay.addEventListener('click', () => {
            sidebar.classList.add('-translate-x-full');
            sidebarOverlay.classList.add('hidden');
        });
    </script>
</body>
</html>