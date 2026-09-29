<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full bg-white text-slate-900">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ $title ?? 'JB GAME' }} - Jual Beli Akun Game Aman & Terpercaya</title>

    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">

    <!-- Styles & Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <!-- Midtrans Snap Script -->
    <script src="{{ config('midtrans.is_production') ? 'https://app.midtrans.com/snap/snap.js' : 'https://app.sandbox.midtrans.com/snap/snap.js' }}" data-client-key="{{ config('midtrans.client_key') }}"></script>

    <style>
        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
        }
        [x-cloak] { display: none !important; }
    </style>
    @stack('styles')
</head>
<body class="flex flex-col min-h-screen bg-white text-slate-800 antialiased selection:bg-indigo-600 selection:text-white">
    <!-- Navbar -->
    <header x-data="{ mobileMenu: false, userDropdown: false }" class="sticky top-0 z-50 backdrop-blur-md bg-white/95 border-b border-slate-200 shadow-xs">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between h-20">
                <!-- Brand / Logo -->
                <div class="flex items-center space-x-3">
                    <a href="{{ route('home') }}" class="flex items-center space-x-3 group">
                        <div class="w-11 h-11 rounded-xl bg-gradient-to-tr from-indigo-600 to-indigo-500 flex items-center justify-center shadow-md shadow-indigo-600/20 group-hover:scale-105 transition-transform duration-200">
                            <svg class="w-6 h-6 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 5v2m0 4v2m0 4v2M5 5a2 2 0 00-2 2v3a2 2 0 110 4v3a2 2 0 002 2h14a2 2 0 002-2v-3a2 2 0 110-4V7a2 2 0 00-2-2H5z" />
                            </svg>
                        </div>
                        <div>
                            <span class="text-xl font-extrabold tracking-tight text-slate-900">JB GAME</span>
                            <span class="block text-[10px] uppercase font-bold tracking-widest text-indigo-600">Store Akun Resmi</span>
                        </div>
                    </a>
                </div>

                <!-- Desktop Nav Links -->
                <nav class="hidden md:flex items-center space-x-1 lg:space-x-2">
                    <a href="{{ route('home') }}" class="px-4 py-2 rounded-lg text-sm font-semibold transition {{ request()->routeIs('home') ? 'bg-indigo-50 text-indigo-600 border border-indigo-200' : 'text-slate-600 hover:text-slate-900 hover:bg-slate-100' }}">
                        Home
                    </a>
                    <a href="{{ route('products.index') }}" class="px-4 py-2 rounded-lg text-sm font-semibold transition {{ request()->routeIs('products.*') ? 'bg-indigo-50 text-indigo-600 border border-indigo-200' : 'text-slate-600 hover:text-slate-900 hover:bg-slate-100' }}">
                        Daftar Produk
                    </a>
                    <a href="{{ route('about') }}" class="px-4 py-2 rounded-lg text-sm font-semibold transition {{ request()->routeIs('about') ? 'bg-indigo-50 text-indigo-600 border border-indigo-200' : 'text-slate-600 hover:text-slate-900 hover:bg-slate-100' }}">
                        Tentang Kami
                    </a>
                    <a href="{{ route('contact') }}" class="px-4 py-2 rounded-lg text-sm font-semibold transition {{ request()->routeIs('contact') ? 'bg-indigo-50 text-indigo-600 border border-indigo-200' : 'text-slate-600 hover:text-slate-900 hover:bg-slate-100' }}">
                        Kontak & Bantuan
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
                                <span>{{ Auth::user()->name }}</span>
                                <svg class="w-4 h-4 text-slate-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                                </svg>
                            </button>

                            <!-- Dropdown Menu -->
                            <div x-show="userDropdown" x-cloak x-transition:enter="transition ease-out duration-100" x-transition:enter-start="opacity-0 scale-95" x-transition:enter-end="opacity-100 scale-100" x-transition:leave="transition ease-in duration-75" x-transition:leave-start="opacity-100 scale-100" x-transition:leave-end="opacity-0 scale-95" class="absolute right-0 mt-2 w-56 rounded-xl bg-white border border-slate-200 shadow-xl py-2 z-50">
                                <div class="px-4 py-2 border-b border-slate-100 text-xs text-slate-500">
                                    Login sebagai <span class="text-slate-900 font-semibold block truncate">{{ Auth::user()->email }}</span>
                                </div>

                                <a href="{{ route('orders.index') }}" class="flex items-center px-4 py-2.5 text-sm text-slate-700 hover:text-indigo-600 hover:bg-slate-50 transition">
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
                                    <svg class="w-4 h-4 mr-2.5 text-slate-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                    </svg>
                                    Pengaturan Akun
                                </a>

                                <div class="border-t border-slate-100 my-1"></div>

                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button type="submit" class="w-full text-left flex items-center px-4 py-2.5 text-sm text-rose-600 hover:text-rose-700 hover:bg-rose-50 transition">
                                        <svg class="w-4 h-4 mr-2.5 text-rose-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
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
                        <a href="{{ route('register') }}" class="px-4 py-2 rounded-xl text-sm font-semibold bg-indigo-600 hover:bg-indigo-700 text-white shadow-md shadow-indigo-600/20 transition transform hover:-translate-y-0.5">
                            Daftar Sekarang
                        </a>
                    @endauth
                </div>

                <!-- Mobile Hamburger Button -->
                <div class="flex md:hidden">
                    <button @click="mobileMenu = !mobileMenu" class="p-2.5 rounded-xl bg-slate-100 text-slate-700 hover:text-slate-900 hover:bg-slate-200 transition">
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
        <div x-show="mobileMenu" x-cloak x-transition class="md:hidden border-b border-slate-200 bg-white/98 backdrop-blur-xl px-4 pt-3 pb-6 space-y-2">
            <a href="{{ route('home') }}" class="block px-3 py-2.5 rounded-lg text-base font-semibold {{ request()->routeIs('home') ? 'bg-indigo-50 text-indigo-600' : 'text-slate-700 hover:bg-slate-100' }}">
                Home
            </a>
            <a href="{{ route('products.index') }}" class="block px-3 py-2.5 rounded-lg text-base font-semibold {{ request()->routeIs('products.*') ? 'bg-indigo-50 text-indigo-600' : 'text-slate-700 hover:bg-slate-100' }}">
                Daftar Produk Akun
            </a>
            <a href="{{ route('about') }}" class="block px-3 py-2.5 rounded-lg text-base font-semibold {{ request()->routeIs('about') ? 'bg-indigo-50 text-indigo-600' : 'text-slate-700 hover:bg-slate-100' }}">
                Tentang Kami
            </a>
            <a href="{{ route('contact') }}" class="block px-3 py-2.5 rounded-lg text-base font-semibold {{ request()->routeIs('contact') ? 'bg-indigo-50 text-indigo-600' : 'text-slate-700 hover:bg-slate-100' }}">
                Kontak & Bantuan
            </a>

            <div class="border-t border-slate-200 pt-4 mt-3">
                @auth
                    <div class="px-3 py-2 text-xs text-slate-500">
                        Login sebagai <span class="font-semibold text-slate-900">{{ Auth::user()->name }}</span>
                    </div>
                    <a href="{{ route('orders.index') }}" class="block px-3 py-2.5 rounded-lg text-base font-semibold text-indigo-600 hover:bg-slate-100">
                        Pesanan Saya
                    </a>
                    @if(Auth::user()->role === 'admin')
                        <a href="/admin" class="block px-3 py-2.5 rounded-lg text-base font-semibold text-amber-600 hover:bg-slate-100">
                            Panel Admin
                        </a>
                    @endif
                    <a href="{{ route('profile.edit') }}" class="block px-3 py-2.5 rounded-lg text-base font-semibold text-slate-700 hover:bg-slate-100">
                        Pengaturan Profil
                    </a>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="w-full text-left px-3 py-2.5 rounded-lg text-base font-semibold text-rose-600 hover:bg-rose-50">
                            Keluar (Log Out)
                        </button>
                    </form>
                @else
                    <div class="grid grid-cols-2 gap-2 pt-2">
                        <a href="{{ route('login') }}" class="w-full text-center px-4 py-2.5 rounded-xl text-sm font-semibold bg-slate-100 text-slate-800 hover:bg-slate-200">
                            Masuk
                        </a>
                        <a href="{{ route('register') }}" class="w-full text-center px-4 py-2.5 rounded-xl text-sm font-semibold bg-indigo-600 text-white hover:bg-indigo-700">
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
            <div class="flex items-center p-4 rounded-xl bg-emerald-50 border border-emerald-200 text-emerald-800">
                <svg class="w-5 h-5 mr-3 shrink-0 text-emerald-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                </svg>
                <div class="text-sm font-medium">{{ session('success') }}</div>
            </div>
        </div>
    @endif

    @if(session('error'))
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mt-4">
            <div class="flex items-center p-4 rounded-xl bg-rose-50 border border-rose-200 text-rose-800">
                <svg class="w-5 h-5 mr-3 shrink-0 text-rose-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                <div class="text-sm font-medium">{{ session('error') }}</div>
            </div>
        </div>
    @endif

    @if(session('warning'))
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mt-4">
            <div class="flex items-center p-4 rounded-xl bg-amber-50 border border-amber-200 text-amber-800">
                <svg class="w-5 h-5 mr-3 shrink-0 text-amber-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                </svg>
                <div class="text-sm font-medium">{{ session('warning') }}</div>
            </div>
        </div>
    @endif

    <!-- Main Content Slot -->
    <main class="flex-grow bg-white">
        @yield('content')
    </main>

    <!-- Footer -->
    <footer class="bg-slate-50 border-t border-slate-200 mt-20 pt-16 pb-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-10 pb-12 border-b border-slate-200">
                <!-- Col 1: About -->
                <div class="space-y-4 md:col-span-2">
                    <div class="flex items-center space-x-3">
                        <div class="w-9 h-9 rounded-xl bg-indigo-600 flex items-center justify-center">
                            <svg class="w-5 h-5 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 5v2m0 4v2m0 4v2M5 5a2 2 0 00-2 2v3a2 2 0 110 4v3a2 2 0 002 2h14a2 2 0 002-2v-3a2 2 0 110-4V7a2 2 0 00-2-2H5z" />
                            </svg>
                        </div>
                        <span class="text-xl font-extrabold tracking-tight text-slate-900">JB GAME</span>
                    </div>
                    <p class="text-slate-600 text-sm leading-relaxed max-w-md">
                        Platform marketplace jual beli akun game nomor satu di Indonesia. Kami menjamin proses transaksi aman, pengiriman data akun instan otomatis via sistem, dan garansi anti-hackback seumur hidup.
                    </p>
                    <div class="flex items-center space-x-3 pt-2">
                        <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold bg-emerald-50 text-emerald-700 border border-emerald-200">
                            🛡️ Garansi Anti-Hackback
                        </span>
                        <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold bg-indigo-50 text-indigo-700 border border-indigo-200">
                            ⚡ Akun Instan Otomatis
                        </span>
                    </div>
                </div>

                <!-- Col 2: Nav Links -->
                <div>
                    <h3 class="text-slate-900 text-sm font-bold uppercase tracking-wider mb-4">Navigasi</h3>
                    <ul class="space-y-2.5 text-sm text-slate-600">
                        <li><a href="{{ route('home') }}" class="hover:text-indigo-600 transition">Beranda</a></li>
                        <li><a href="{{ route('products.index') }}" class="hover:text-indigo-600 transition">Semua Produk</a></li>
                        <li><a href="{{ route('about') }}" class="hover:text-indigo-600 transition">Tentang Kami</a></li>
                        <li><a href="{{ route('contact') }}" class="hover:text-indigo-600 transition">Bantuan & Kontak</a></li>
                    </ul>
                </div>

                <!-- Col 3: Pembayaran QRIS -->
                <div>
                    <h3 class="text-slate-900 text-sm font-bold uppercase tracking-wider mb-4">Pembayaran Resmi</h3>
                    <p class="text-xs text-slate-500 mb-3">Mendukung QRIS instan dan transfer bank nasional via Midtrans:</p>
                    <div class="grid grid-cols-3 gap-2">
                        <div class="bg-white border border-slate-200 rounded-lg p-2 flex items-center justify-center text-[11px] font-bold text-slate-700 shadow-2xs">
                            QRIS
                        </div>
                        <div class="bg-white border border-slate-200 rounded-lg p-2 flex items-center justify-center text-[11px] font-bold text-slate-700 shadow-2xs">
                            GOPAY
                        </div>
                        <div class="bg-white border border-slate-200 rounded-lg p-2 flex items-center justify-center text-[11px] font-bold text-slate-700 shadow-2xs">
                            SHOPEE
                        </div>
                        <div class="bg-white border border-slate-200 rounded-lg p-2 flex items-center justify-center text-[11px] font-bold text-slate-700 shadow-2xs">
                            BCA VA
                        </div>
                        <div class="bg-white border border-slate-200 rounded-lg p-2 flex items-center justify-center text-[11px] font-bold text-slate-700 shadow-2xs">
                            BRI VA
                        </div>
                        <div class="bg-white border border-slate-200 rounded-lg p-2 flex items-center justify-center text-[11px] font-bold text-slate-700 shadow-2xs">
                            MANDIRI
                        </div>
                    </div>
                </div>
            </div>

            <!-- Bottom Copyright -->
            <div class="pt-8 flex flex-col sm:flex-row items-center justify-between text-xs text-slate-500 space-y-4 sm:space-y-0">
                <p>&copy; {{ date('Y') }} JB GAME. Hak Cipta Dilindungi Undang-Undang.</p>
                <div class="flex space-x-6">
                    <span class="hover:text-slate-700">Aman & Terverifikasi</span>
                    <span class="hover:text-slate-700">Didukung oleh Midtrans Payment</span>
                </div>
            </div>
        </div>
    </footer>

    @stack('scripts')
</body>
</html>
