<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full bg-slate-50 text-slate-800">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ $title ?? 'ANDRA JB' }} - Jual Beli Akun Game Aman & Terpercaya</title>

    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">

    <!-- Styles & Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
        }
        [x-cloak] { display: none !important; }
    </style>
    @stack('styles')
</head>
<body class="flex flex-col min-h-screen bg-[#f8fafc] text-slate-800 antialiased selection:bg-indigo-600 selection:text-white">
    <!-- Cinematic White Splash Screen with Logo JB Morph Transition -->
    <x-jb-splash />

    <!-- Navbar -->
    <header x-data="{ mobileMenu: false, userDropdown: false }" class="sticky top-0 z-50 backdrop-blur-md bg-white/95 border-b border-slate-200 shadow-sm">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between h-20">
                <!-- Brand / Logo -->
                <div class="flex items-center space-x-3">
                    <a href="{{ route('home') }}" class="flex items-center space-x-3 group">
                        <div id="navbar-logo-badge" class="w-11 h-11 rounded-2xl bg-white border border-slate-200 shadow-xs flex items-center justify-center p-2 group-hover:scale-105 group-hover:border-slate-300 transition-all duration-200">
                            <div class="w-full h-full text-slate-950 flex items-center justify-center">
                                <x-jb-logo />
                            </div>
                        </div>
                        <div id="navbar-brand-text">
                            <span class="text-xl font-extrabold tracking-tight text-slate-900 flex items-center gap-1.5">
                                ANDRA JB
                                <span class="w-2 h-2 rounded-full bg-indigo-600 inline-block"></span>
                            </span>
                            <span class="block text-[10px] uppercase font-bold tracking-widest text-slate-500">Official Marketplace</span>
                        </div>
                    </a>
                </div>

                <!-- Desktop Nav Links -->
                <nav class="hidden md:flex items-center space-x-1 lg:space-x-2">
                    <a href="{{ route('home') }}" class="px-4 py-2 rounded-xl text-sm font-semibold transition {{ request()->routeIs('home') ? 'bg-indigo-50 text-indigo-700 border border-indigo-200/80 shadow-xs' : 'text-slate-600 hover:text-slate-900 hover:bg-slate-100' }}">
                        Beranda
                    </a>
                    <a href="{{ route('products.index') }}" class="px-4 py-2 rounded-xl text-sm font-semibold transition {{ request()->routeIs('products.*') ? 'bg-indigo-50 text-indigo-700 border border-indigo-200/80 shadow-xs' : 'text-slate-600 hover:text-slate-900 hover:bg-slate-100' }}">
                        Katalog Akun
                    </a>
                    <a href="{{ route('about') }}" class="px-4 py-2 rounded-xl text-sm font-semibold transition {{ request()->routeIs('about') ? 'bg-indigo-50 text-indigo-700 border border-indigo-200/80 shadow-xs' : 'text-slate-600 hover:text-slate-900 hover:bg-slate-100' }}">
                        Tentang Kami
                    </a>
                    <a href="{{ route('contact') }}" class="px-4 py-2 rounded-xl text-sm font-semibold transition {{ request()->routeIs('contact') ? 'bg-indigo-50 text-indigo-700 border border-indigo-200/80 shadow-xs' : 'text-slate-600 hover:text-slate-900 hover:bg-slate-100' }}">
                        Bantuan & Kontak
                    </a>
                </nav>

                <!-- Auth Action Buttons (Desktop) -->
                <div class="hidden md:flex items-center space-x-3">
                    @auth
                        <!-- User Menu Dropdown -->
                        <div class="relative" @click.outside="userDropdown = false">
                            <button @click="userDropdown = !userDropdown" class="flex items-center space-x-2.5 px-3.5 py-2 rounded-xl bg-slate-50 hover:bg-slate-100 border border-slate-200 transition text-sm font-semibold text-slate-800">
                                <div class="w-7 h-7 rounded-lg bg-indigo-100 border border-indigo-200 flex items-center justify-center text-indigo-700 font-bold text-xs uppercase">
                                    {{ substr(Auth::user()->name, 0, 1) }}
                                </div>
                                <span class="max-w-[120px] truncate">{{ Auth::user()->name }}</span>
                                <svg class="w-4 h-4 text-slate-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                                </svg>
                            </button>

                            <!-- Dropdown Menu -->
                            <div x-show="userDropdown" x-cloak x-transition:enter="transition ease-out duration-100" x-transition:enter-start="opacity-0 scale-95" x-transition:enter-end="opacity-100 scale-100" x-transition:leave="transition ease-in duration-75" x-transition:leave-start="opacity-100 scale-100" x-transition:leave-end="opacity-0 scale-95" class="absolute right-0 mt-2 w-56 rounded-2xl bg-white border border-slate-200 shadow-xl py-2 z-50">
                                <div class="px-4 py-2 border-b border-slate-100 text-xs text-slate-500">
                                    Masuk sebagai <span class="text-slate-900 font-semibold block truncate">{{ Auth::user()->email }}</span>
                                </div>

                                <a href="{{ route('orders.index') }}" class="flex items-center px-4 py-2.5 text-sm text-slate-700 hover:text-indigo-600 hover:bg-indigo-50/60 transition font-medium">
                                    <svg class="w-4 h-4 mr-2.5 text-indigo-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" />
                                    </svg>
                                    Pesanan Saya
                                </a>

                                @if(Auth::user()->role === 'admin')
                                    <a href="/admin" class="flex items-center px-4 py-2.5 text-sm text-amber-700 hover:text-amber-800 hover:bg-amber-50 transition font-medium">
                                        <svg class="w-4 h-4 mr-2.5 text-amber-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z" />
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                        </svg>
                                        Panel Admin
                                    </a>
                                @endif

                                <a href="{{ route('profile.edit') }}" class="flex items-center px-4 py-2.5 text-sm text-slate-700 hover:text-slate-900 hover:bg-slate-50 transition">
                                    <svg class="w-4 h-4 mr-2.5 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                    </svg>
                                    Pengaturan Profil
                                </a>

                                <div class="border-t border-slate-100 my-1"></div>

                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button type="submit" class="w-full text-left flex items-center px-4 py-2.5 text-sm text-rose-600 hover:text-rose-700 hover:bg-rose-50 transition font-medium">
                                        <svg class="w-4 h-4 mr-2.5 text-rose-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                                        </svg>
                                        Keluar (Log Out)
                                    </button>
                                </form>
                            </div>
                        </div>
                    @else
                        <a href="{{ route('login') }}" class="px-4 py-2 rounded-xl text-sm font-semibold text-slate-700 hover:text-slate-900 hover:bg-slate-100 transition">
                            Masuk
                        </a>
                        <a href="{{ route('register') }}" class="px-5 py-2.5 rounded-xl text-sm font-bold bg-indigo-600 hover:bg-indigo-700 text-white shadow-sm hover:shadow-md hover:shadow-indigo-500/20 transition transform hover:-translate-y-0.5">
                            Daftar Sekarang
                        </a>
                    @endauth
                </div>

                <!-- Mobile Hamburger Button -->
                <div class="flex md:hidden">
                    <button @click="mobileMenu = !mobileMenu" class="p-2.5 rounded-xl bg-slate-100 text-slate-700 hover:text-slate-900 hover:bg-slate-200 transition" aria-label="Buka menu navigasi">
                        <svg x-show="!mobileMenu" class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        </svg>
                        <svg x-show="mobileMenu" x-cloak class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>
            </div>
        </div>

        <!-- Mobile Drawer Menu -->
        <div x-show="mobileMenu" x-cloak x-transition class="md:hidden border-b border-slate-200 bg-white px-4 pt-3 pb-6 space-y-2">
            <a href="{{ route('home') }}" class="block px-3.5 py-2.5 rounded-xl text-base font-semibold {{ request()->routeIs('home') ? 'bg-indigo-600 text-white' : 'text-slate-700 hover:bg-slate-100' }}">
                Beranda
            </a>
            <a href="{{ route('products.index') }}" class="block px-3.5 py-2.5 rounded-xl text-base font-semibold {{ request()->routeIs('products.*') ? 'bg-indigo-600 text-white' : 'text-slate-700 hover:bg-slate-100' }}">
                Katalog Akun
            </a>
            <a href="{{ route('about') }}" class="block px-3.5 py-2.5 rounded-xl text-base font-semibold {{ request()->routeIs('about') ? 'bg-indigo-600 text-white' : 'text-slate-700 hover:bg-slate-100' }}">
                Tentang Kami
            </a>
            <a href="{{ route('contact') }}" class="block px-3.5 py-2.5 rounded-xl text-base font-semibold {{ request()->routeIs('contact') ? 'bg-indigo-600 text-white' : 'text-slate-700 hover:bg-slate-100' }}">
                Bantuan & Kontak
            </a>

            <div class="border-t border-slate-200 pt-4 mt-3">
                @auth
                    <div class="px-3.5 py-2 text-xs text-slate-500">
                        Masuk sebagai <span class="font-semibold text-slate-900">{{ Auth::user()->name }}</span>
                    </div>
                    <a href="{{ route('orders.index') }}" class="block px-3.5 py-2.5 rounded-xl text-base font-semibold text-indigo-700 hover:bg-indigo-50">
                        Pesanan Saya
                    </a>
                    @if(Auth::user()->role === 'admin')
                        <a href="/admin" class="block px-3.5 py-2.5 rounded-xl text-base font-semibold text-amber-700 hover:bg-amber-50">
                            Panel Admin
                        </a>
                    @endif
                    <a href="{{ route('profile.edit') }}" class="block px-3.5 py-2.5 rounded-xl text-base font-semibold text-slate-700 hover:bg-slate-100">
                        Pengaturan Profil
                    </a>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="w-full text-left px-3.5 py-2.5 rounded-xl text-base font-semibold text-rose-600 hover:bg-rose-50">
                            Keluar (Log Out)
                        </button>
                    </form>
                @else
                    <div class="grid grid-cols-2 gap-2 pt-2">
                        <a href="{{ route('login') }}" class="w-full text-center px-4 py-2.5 rounded-xl text-sm font-semibold bg-slate-100 text-slate-800 hover:bg-slate-200">
                            Masuk
                        </a>
                        <a href="{{ route('register') }}" class="w-full text-center px-4 py-2.5 rounded-xl text-sm font-bold bg-indigo-600 text-white hover:bg-indigo-700">
                            Daftar
                        </a>
                    </div>
                @endauth
            </div>
        </div>
    </header>

    <!-- Flash Alerts -->
    @if(session('success'))
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mt-4">
            <div class="flex items-center p-4 rounded-xl bg-emerald-50 border border-emerald-200 text-emerald-800 shadow-xs">
                <svg class="w-5 h-5 mr-3 shrink-0 text-emerald-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                </svg>
                <div class="text-sm font-medium">{{ session('success') }}</div>
            </div>
        </div>
    @endif

    @if(session('error'))
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mt-4">
            <div class="flex items-center p-4 rounded-xl bg-rose-50 border border-rose-200 text-rose-800 shadow-xs">
                <svg class="w-5 h-5 mr-3 shrink-0 text-rose-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                <div class="text-sm font-medium">{{ session('error') }}</div>
            </div>
        </div>
    @endif

    @if(session('warning'))
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mt-4">
            <div class="flex items-center p-4 rounded-xl bg-amber-50 border border-amber-200 text-amber-800 shadow-xs">
                <svg class="w-5 h-5 mr-3 shrink-0 text-amber-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                </svg>
                <div class="text-sm font-medium">{{ session('warning') }}</div>
            </div>
        </div>
    @endif

    <!-- Main Content Slot -->
    <main class="flex-grow">
        @yield('content')
    </main>

    <!-- Footer -->
    <footer class="bg-white border-t border-slate-200 mt-20 pt-16 pb-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-10 pb-12 border-b border-slate-200">
                <!-- Col 1: About -->
                <div class="space-y-4 md:col-span-2">
                    <div class="flex items-center space-x-3">
                        <div class="w-9 h-9 rounded-xl bg-white border border-slate-200 flex items-center justify-center p-1.5 shadow-xs">
                            <div class="w-full h-full text-slate-950 flex items-center justify-center">
                                <x-jb-logo />
                            </div>
                        </div>
                        <span class="text-xl font-extrabold tracking-tight text-slate-900">ANDRA JB</span>
                    </div>
                    <p class="text-slate-600 text-sm leading-relaxed max-w-md">
                        Platform marketplace jual beli akun game terpercaya di Indonesia. Kami menjamin proses transaksi aman, penyerahan kredensial akun instan otomatis via sistem, dan garansi anti-hackback seumur hidup.
                    </p>
                    <div class="flex flex-wrap items-center gap-2 pt-2">
                        <span class="inline-flex items-center px-3 py-1 rounded-lg text-xs font-semibold bg-emerald-50 text-emerald-700 border border-emerald-200">
                            🛡️ Garansi Anti-Hackback
                        </span>
                        <span class="inline-flex items-center px-3 py-1 rounded-lg text-xs font-semibold bg-indigo-50 text-indigo-700 border border-indigo-200">
                            ⚡ Akun Instan Otomatis
                        </span>
                        <span class="inline-flex items-center px-3 py-1 rounded-lg text-xs font-semibold bg-cyan-50 text-cyan-700 border border-cyan-200">
                            🎮 100% Data Valid
                        </span>
                    </div>
                </div>

                <!-- Col 2: Nav Links -->
                <div>
                    <h3 class="text-slate-900 text-xs font-bold uppercase tracking-wider mb-4">Navigasi</h3>
                    <ul class="space-y-2.5 text-sm text-slate-600">
                        <li><a href="{{ route('home') }}" class="hover:text-indigo-600 transition">Beranda</a></li>
                        <li><a href="{{ route('products.index') }}" class="hover:text-indigo-600 transition">Katalog Semua Akun</a></li>
                        <li><a href="{{ route('about') }}" class="hover:text-indigo-600 transition">Tentang Kami</a></li>
                        <li><a href="{{ route('contact') }}" class="hover:text-indigo-600 transition">Bantuan & Kontak</a></li>
                    </ul>
                </div>

                <!-- Col 3: Pembayaran QRIS -->
                <div>
                    <h3 class="text-slate-900 text-xs font-bold uppercase tracking-wider mb-4">Metode Pembayaran Resmi</h3>
                    <p class="text-xs text-slate-500 mb-3">Dukungan QRIS instan, e-wallet, dan transfer bank nasional:</p>
                    <div class="grid grid-cols-3 gap-2">
                        <div class="bg-slate-50 border border-slate-200 rounded-lg p-2 flex items-center justify-center text-[11px] font-bold text-slate-700">
                            QRIS
                        </div>
                        <div class="bg-slate-50 border border-slate-200 rounded-lg p-2 flex items-center justify-center text-[11px] font-bold text-slate-700">
                            GOPAY
                        </div>
                        <div class="bg-slate-50 border border-slate-200 rounded-lg p-2 flex items-center justify-center text-[11px] font-bold text-slate-700">
                            SHOPEE
                        </div>
                        <div class="bg-slate-50 border border-slate-200 rounded-lg p-2 flex items-center justify-center text-[11px] font-bold text-slate-700">
                            BCA VA
                        </div>
                        <div class="bg-slate-50 border border-slate-200 rounded-lg p-2 flex items-center justify-center text-[11px] font-bold text-slate-700">
                            BRI VA
                        </div>
                        <div class="bg-slate-50 border border-slate-200 rounded-lg p-2 flex items-center justify-center text-[11px] font-bold text-slate-700">
                            MANDIRI
                        </div>
                    </div>
                </div>
            </div>

            <!-- Bottom Copyright -->
            <div class="pt-8 flex flex-col sm:flex-row items-center justify-between text-xs text-slate-500 space-y-4 sm:space-y-0">
                <p>&copy; {{ date('Y') }} ANDRA JB. Hak Cipta Dilindungi.</p>
                <div class="flex space-x-6">
                    <span class="text-slate-600 font-medium">Aman & Terverifikasi</span>
                    <span class="text-slate-600 font-medium">Sistem Pembayaran QRIS Otomatis Terverifikasi</span>
                </div>
            </div>
        </div>
    </footer>

    @stack('scripts')
</body>
</html>
