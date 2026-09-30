@extends('layouts.main')

@section('content')
<!-- ========================================================================= -->
<!-- 1. HERO SECTION (WHITE GAMING PREMIUM + 3D INTERACTIVE GAMING ELEMENTS)   -->
<!-- ========================================================================= -->
<section id="hero" class="relative overflow-hidden bg-gradient-to-b from-white via-[#fcfdff] to-[#f8fafc] pt-10 pb-20 sm:pt-16 sm:pb-28 lg:pt-24 lg:pb-36 border-b border-slate-200/80" 
         x-data="heroParallax()">

    <!-- Ambient Grid & Soft White Glow Background -->
    <div class="absolute inset-0 pointer-events-none opacity-60" 
         style="background-image: radial-gradient(rgba(148, 163, 184, 0.2) 1px, transparent 1px), radial-gradient(rgba(99, 102, 241, 0.08) 1px, transparent 1px); background-size: 32px 32px, 64px 64px; background-position: 0 0, 16px 16px;"></div>
    
    <div class="absolute w-[800px] h-[500px] rounded-full bg-gradient-to-tr from-indigo-100/40 via-cyan-50/50 to-transparent blur-3xl -top-24 left-1/2 -translate-x-1/2 pointer-events-none"></div>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">

        <!-- ================================================================= -->
        <!-- ELEMEN GAME 3D INTERAKTIF (PARALLAX + FLOATING + DEPTH LAYERS)   -->
        <!-- ================================================================= -->

        <!-- 3D ITEM 1: SENJATA GAME (TOP-LEFT / LAYER 2) -->
        <div class="hidden lg:flex absolute top-4 left-2 xl:left-8 z-20 pointer-events-auto transition-transform duration-200 ease-out"
             :style="`transform: translate3d(${offsetX * 0.04}px, ${offsetY * 0.04}px, 0) rotate(${offsetY * 0.02}deg)`">
            <div class="group relative p-4 rounded-3xl bg-white/90 backdrop-blur-md border border-slate-200/90 shadow-[0_20px_40px_rgba(15,23,42,0.06)] hover:shadow-[0_25px_50px_rgba(99,102,241,0.15)] hover:border-indigo-300 transition-all duration-300 hover:scale-105 cursor-pointer animate-[float_4s_ease-in-out_infinite]">
                
                <!-- Badge Level Senjata -->
                <div class="flex items-center justify-between gap-3 mb-2">
                    <span class="px-2.5 py-0.5 rounded-full text-[10px] font-black uppercase tracking-wider bg-rose-50 text-rose-600 border border-rose-200">
                        Mythic Lv.7
                    </span>
                    <span class="text-[11px] font-mono font-bold text-slate-400">AWM Sniper</span>
                </div>

                <!-- Gambar/Ilustrasi Senjata Game Cyber -->
                <div class="w-48 h-24 flex items-center justify-center relative overflow-hidden rounded-2xl bg-gradient-to-br from-slate-50 to-indigo-50/40 p-2">
                    <svg class="w-40 h-20 text-slate-800 drop-shadow-md group-hover:scale-105 transition-transform duration-300" viewBox="0 0 160 80" fill="none">
                        <!-- Futuristic Sniper Rifle Silhouette -->
                        <path d="M10 45 L50 45 L65 40 L130 40 L150 42 L130 46 L70 46 L55 58 L45 58 L40 50 L20 50 L10 45 Z" fill="#0f172a" />
                        <!-- Scope Optic -->
                        <rect x="60" y="28" width="50" height="9" rx="3" fill="#1e293b" />
                        <circle cx="85" cy="32.5" r="3" fill="#06b6d4" />
                        <rect x="75" y="37" width="4" height="4" fill="#334155" />
                        <rect x="95" y="37" width="4" height="4" fill="#334155" />
                        <!-- Mag & Trigger -->
                        <path d="M72 46 L68 62 L78 62 L80 46 Z" fill="#334155" />
                        <!-- Cyan Energy Line -->
                        <line x1="65" y1="43" x2="135" y2="43" stroke="#06b6d4" stroke-width="2" stroke-linecap="round" />
                        <!-- Stock Padding -->
                        <rect x="10" y="42" width="6" height="15" rx="2" fill="#ef4444" />
                    </svg>
                    <!-- Energy Sparkle -->
                    <span class="absolute top-2 right-2 w-2 h-2 rounded-full bg-cyan-400 animate-ping"></span>
                </div>

                <div class="mt-2.5 flex items-center justify-between text-[11px] font-semibold text-slate-600">
                    <span class="text-indigo-600 font-bold">100% Safe Clean Bind</span>
                    <span class="text-slate-400">Instant Delivery</span>
                </div>
            </div>
        </div>

        <!-- 3D ITEM 2: ITEM GAME & DIAMOND (TOP-RIGHT / LAYER 2) -->
        <div class="hidden lg:flex absolute top-6 right-2 xl:right-8 z-20 pointer-events-auto transition-transform duration-200 ease-out"
             :style="`transform: translate3d(${offsetX * -0.045}px, ${offsetY * 0.04}px, 0) rotate(${offsetX * 0.015}deg)`">
            <div class="group relative p-4 rounded-3xl bg-white/90 backdrop-blur-md border border-slate-200/90 shadow-[0_20px_40px_rgba(15,23,42,0.06)] hover:shadow-[0_25px_50px_rgba(6,182,212,0.15)] hover:border-cyan-300 transition-all duration-300 hover:scale-105 cursor-pointer animate-[float_4.5s_ease-in-out_infinite_0.7s]">
                
                <div class="flex items-center justify-between gap-3 mb-2">
                    <span class="px-2.5 py-0.5 rounded-full text-[10px] font-black uppercase tracking-wider bg-cyan-50 text-cyan-600 border border-cyan-200">
                        10.000 Diamond
                    </span>
                    <span class="text-[11px] font-mono font-bold text-slate-400">Vault Item</span>
                </div>

                <!-- 3D Diamond & Esports Headset Visual -->
                <div class="w-44 h-24 flex items-center justify-around rounded-2xl bg-gradient-to-br from-slate-50 via-cyan-50/30 to-indigo-50/40 p-2">
                    <!-- Diamond Facet SVG -->
                    <svg class="w-12 h-12 text-cyan-500 drop-shadow-md group-hover:rotate-12 transition-transform duration-300" viewBox="0 0 24 24" fill="currentColor">
                        <path d="M6 3h12l4 6-10 12L2 9l4-6zm1.5 2L4.5 8.5h4.1L10 5H7.5zm3.7 0l-1.3 3.5h4.2L12.8 5h-1.6zm2.8 0l1.4 3.5h4.1L16.5 5H14zm-4.3 4.5H5.4l6.6 8 1.4-8h-3.7zm4.9 0l-2.4 8 6.6-8h-4.2z" />
                    </svg>

                    <!-- Gaming Headset SVG -->
                    <svg class="w-12 h-12 text-slate-800 drop-shadow-md group-hover:scale-110 transition-transform duration-300" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M3 18v-6a9 9 0 0 1 18 0v6" />
                        <path stroke-linecap="round" stroke-linejoin="round" d="M21 19a2 2 0 0 1-2 2h-1a2 2 0 0 1-2-2v-3a2 2 0 0 1 2-2h3zM3 19a2 2 0 0 0 2 2h1a2 2 0 0 0 2-2v-3a2 2 0 0 0-2-2H3z" />
                        <path stroke-linecap="round" stroke-linejoin="round" d="M19 19a3 3 0 0 1-3 3h-1" />
                    </svg>
                </div>

                <div class="mt-2.5 flex items-center justify-between text-[11px] font-semibold text-slate-600">
                    <span class="text-cyan-600 font-bold">Unbind Full Garansi</span>
                    <span class="text-emerald-600">Ready Stock</span>
                </div>
            </div>
        </div>

        <!-- 3D ITEM 3: NEXT-GEN CONTROLLER (BOTTOM-LEFT / LAYER 3) -->
        <div class="hidden md:flex absolute -bottom-6 left-6 xl:left-14 z-20 pointer-events-auto transition-transform duration-200 ease-out"
             :style="`transform: translate3d(${offsetX * 0.06}px, ${offsetY * -0.05}px, 0) rotate(${offsetX * -0.02}deg)`">
            <div class="group relative p-4 rounded-3xl bg-white/95 backdrop-blur-md border border-slate-200/90 shadow-[0_20px_45px_rgba(15,23,42,0.08)] hover:shadow-[0_25px_50px_rgba(99,102,241,0.2)] hover:border-indigo-400 transition-all duration-300 hover:scale-105 cursor-pointer animate-[float_5s_ease-in-out_infinite_1.4s]">
                
                <div class="flex items-center space-x-3">
                    <!-- 3D Controller SVG -->
                    <div class="w-14 h-14 rounded-2xl bg-slate-900 flex items-center justify-center text-white shadow-md shadow-slate-900/20 group-hover:bg-indigo-600 transition-colors duration-300">
                        <svg class="w-8 h-8" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <rect x="2" y="6" width="20" height="12" rx="6" />
                            <path d="M6 12h4m-2-2v4m10-2h.01m-2-2h.01m0 4h.01m2-2h.01" stroke-linecap="round" />
                        </svg>
                    </div>
                    <div>
                        <span class="text-[10px] font-bold uppercase tracking-wider text-slate-400 block">Console & Mobile</span>
                        <h4 class="text-sm font-extrabold text-slate-900">Multiplatform Ready</h4>
                        <span class="text-xs font-semibold text-emerald-600 flex items-center gap-1 mt-0.5">
                            <span class="w-1.5 h-1.5 rounded-full bg-emerald-500 animate-ping"></span>
                            Terverifikasi Admin
                        </span>
                    </div>
                </div>
            </div>
        </div>

        <!-- 3D ITEM 4: LOOT BOX / SUPPLY CRATE (BOTTOM-RIGHT / LAYER 3) -->
        <div class="hidden md:flex absolute -bottom-6 right-6 xl:right-14 z-20 pointer-events-auto transition-transform duration-200 ease-out"
             :style="`transform: translate3d(${offsetX * -0.06}px, ${offsetY * -0.05}px, 0) rotate(${offsetY * 0.02}deg)`">
            <div class="group relative p-4 rounded-3xl bg-white/95 backdrop-blur-md border border-slate-200/90 shadow-[0_20px_45px_rgba(15,23,42,0.08)] hover:shadow-[0_25px_50px_rgba(245,158,11,0.2)] hover:border-amber-400 transition-all duration-300 hover:scale-105 cursor-pointer animate-[float_4.8s_ease-in-out_infinite_2.1s]">
                
                <div class="flex items-center space-x-3">
                    <!-- 3D Golden Loot Box SVG -->
                    <div class="w-14 h-14 rounded-2xl bg-gradient-to-tr from-amber-500 via-amber-400 to-yellow-300 flex items-center justify-center text-slate-950 shadow-md shadow-amber-500/20 group-hover:scale-105 transition-transform duration-300">
                        <svg class="w-8 h-8" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M21 8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16Z" />
                            <path d="m3.3 7 8.7 5 8.7-5M12 22V12" />
                        </svg>
                    </div>
                    <div>
                        <span class="text-[10px] font-bold uppercase tracking-wider text-amber-600 block">Legendary Vault</span>
                        <h4 class="text-sm font-extrabold text-slate-900">Garansi Anti-Hackback</h4>
                        <span class="text-xs font-semibold text-slate-500 block mt-0.5">Penggantian 100% Saldo</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- 3D ITEM 5 & 6: FLOATING COINS & ENERGY PARTICLES (LAYER 1 - BACKGROUND DEPTH) -->
        <div class="hidden xl:block absolute top-1/2 -left-6 z-10 pointer-events-none transition-transform duration-300 ease-out opacity-80"
             :style="`transform: translate3d(${offsetX * 0.02}px, ${offsetY * 0.02}px, 0)`">
            <div class="w-12 h-12 rounded-full bg-gradient-to-tr from-amber-400 to-yellow-300 border-2 border-yellow-200 shadow-lg flex items-center justify-center text-amber-950 font-black text-sm animate-[spin_8s_linear_infinite]">
                ★
            </div>
        </div>

        <div class="hidden xl:block absolute top-1/3 -right-6 z-10 pointer-events-none transition-transform duration-300 ease-out opacity-80"
             :style="`transform: translate3d(${offsetX * -0.025}px, ${offsetY * 0.025}px, 0)`">
            <div class="w-10 h-10 rounded-full bg-gradient-to-tr from-indigo-500 to-cyan-400 border-2 border-white shadow-lg flex items-center justify-center text-white font-bold text-xs animate-[bounce_4s_ease-in-out_infinite]">
                XP
            </div>
        </div>

        <!-- ================================================================= -->
        <!-- HEADLINE UTAMA & CALL TO ACTION (FOKUS UTAMA TIDAK TERTUTUPI)     -->
        <!-- ================================================================= -->
        <div class="text-center max-w-3xl mx-auto space-y-6 pt-4 sm:pt-6">
            
            <!-- Sleek Badge -->
            <div class="inline-flex items-center space-x-2 px-4 py-1.5 rounded-full bg-white border border-slate-200/90 text-slate-800 text-xs font-bold shadow-xs hover:border-slate-300 transition">
                <span class="w-2 h-2 rounded-full bg-indigo-600 animate-pulse"></span>
                <span class="tracking-wide">Marketplace Akun Game #1 Indonesia</span>
                <span class="text-slate-300">•</span>
                <span class="text-indigo-600 font-extrabold">Instant QRIS</span>
            </div>

            <!-- Headline Utama (Jelas & Kontras Tinggi) -->
            <h1 class="text-4xl sm:text-6xl lg:text-7xl font-black tracking-tight text-slate-950 leading-[1.1] uppercase">
                Jual Beli <br class="hidden sm:inline">
                <span class="bg-gradient-to-r from-slate-950 via-indigo-900 to-indigo-600 bg-clip-text text-transparent">
                    Akun Game
                </span>
            </h1>

            <!-- Subheadline -->
            <p class="text-base sm:text-xl text-slate-600 font-medium leading-relaxed max-w-2xl mx-auto">
                Temukan akun game yang sesuai dengan kebutuhanmu. Transaksi aman, instan tanpa ribet dengan QRIS otomatis dan garansi anti-hackback seumur hidup.
            </p>

            <!-- Call To Action Buttons (Lihat Produk & Cara Kerja) -->
            <div class="pt-2 flex flex-col sm:flex-row items-center justify-center gap-4 max-w-md mx-auto">
                <!-- CTA 1: Lihat Produk -->
                <a href="{{ route('products.index') }}" 
                   class="w-full sm:w-auto px-9 py-4 rounded-2xl font-black text-sm tracking-wide bg-slate-950 hover:bg-slate-900 text-white shadow-xl shadow-slate-950/20 hover:shadow-2xl hover:shadow-slate-950/30 transition-all duration-200 transform hover:-translate-y-0.5 text-center flex items-center justify-center space-x-2">
                    <span>Lihat Produk</span>
                    <svg class="w-4 h-4 text-indigo-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M14 5l7 7m0 0l-7 7m7-7H3" />
                    </svg>
                </a>

                <!-- CTA 2: Cara Kerja -->
                <a href="#cara-kerja" 
                   class="w-full sm:w-auto px-8 py-4 rounded-2xl font-bold text-sm tracking-wide bg-white hover:bg-slate-50 text-slate-800 border border-slate-200 shadow-xs hover:border-slate-300 transition-all duration-200 text-center flex items-center justify-center space-x-2">
                    <svg class="w-4 h-4 text-indigo-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    <span>Cara Kerja</span>
                </a>
            </div>

            <!-- 3D ITEM CENTER: PREVIEW KARTU AKUN HERO (TERLETAK DI BAWAH CTA) -->
            <div class="pt-8 max-w-md mx-auto transition-transform duration-300 ease-out"
                 :style="`transform: translate3d(0, ${offsetY * 0.02}px, 0)`">
                <div class="p-4 rounded-3xl bg-white border border-slate-200/90 shadow-[0_20px_45px_rgba(15,23,42,0.06)] flex items-center justify-between text-left gap-4 hover:border-indigo-300 hover:shadow-lg transition">
                    <div class="flex items-center space-x-3.5">
                        <div class="w-12 h-12 rounded-2xl bg-slate-900 border border-slate-800 flex items-center justify-center p-2 text-white shrink-0 shadow-sm">
                            <x-andra-jb-logo />
                        </div>
                        <div>
                            <span class="text-[10px] font-bold uppercase tracking-wider text-emerald-600 block">Sistem Otomatis Aktif</span>
                            <h5 class="text-sm font-extrabold text-slate-900 leading-tight">Penyerahan Akun Instan</h5>
                            <span class="text-xs text-slate-500">Kredensial otomatis terbuka setelah bayar</span>
                        </div>
                    </div>
                    <span class="px-3 py-1.5 rounded-xl bg-slate-100 text-slate-800 font-bold text-xs shrink-0">
                        ⚡ Realtime
                    </span>
                </div>
            </div>

            <!-- Stats Bar Minimalis & Mewah -->
            <div class="pt-10 grid grid-cols-2 md:grid-cols-4 gap-4 max-w-4xl mx-auto">
                <div class="p-4 rounded-2xl bg-white border border-slate-200/80 shadow-xs text-center">
                    <div class="text-2xl sm:text-3xl font-black text-slate-900">{{ $allAvailableCount }}</div>
                    <div class="text-xs font-semibold text-slate-500 mt-1">Akun Ready Stock</div>
                </div>
                <div class="p-4 rounded-2xl bg-white border border-slate-200/80 shadow-xs text-center">
                    <div class="text-2xl sm:text-3xl font-black text-slate-900">{{ $soldCount }}+</div>
                    <div class="text-xs font-semibold text-slate-500 mt-1">Transaksi Berhasil</div>
                </div>
                <div class="p-4 rounded-2xl bg-white border border-slate-200/80 shadow-xs text-center">
                    <div class="text-2xl sm:text-3xl font-black text-indigo-600">0 Detik</div>
                    <div class="text-xs font-semibold text-slate-500 mt-1">Verifikasi QRIS</div>
                </div>
                <div class="p-4 rounded-2xl bg-white border border-slate-200/80 shadow-xs text-center">
                    <div class="text-2xl sm:text-3xl font-black text-emerald-600">100%</div>
                    <div class="text-xs font-semibold text-slate-500 mt-1">Garansi Keamanan</div>
                </div>
            </div>

        </div>
    </div>
</section>

<!-- ========================================================================= -->
<!-- 2. KATEGORI GAME (DATA ASLI DATABASE)                                     -->
<!-- ========================================================================= -->
<section id="kategori" class="py-20 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
    <div class="flex flex-col md:flex-row md:items-end justify-between mb-10 gap-4">
        <div>
            <div class="inline-flex items-center space-x-2 px-3 py-1 rounded-full bg-indigo-50 border border-indigo-200 text-indigo-700 text-[11px] font-bold tracking-wider uppercase mb-2">
                <span>Eksplorasi Game</span>
            </div>
            <h2 class="text-3xl sm:text-4xl font-black tracking-tight text-slate-900">Kategori Game Populer</h2>
        </div>
        <p class="text-slate-500 text-sm max-w-md">
            Pilih game favoritmu dan temukan akun dengan rank tinggi, koleksi skin eksklusif, serta data aman siap dimainkan.
        </p>
    </div>

    <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-6 gap-4 sm:gap-5">
        @forelse($categories as $category)
            <a href="{{ route('products.index', ['category' => $category->slug]) }}" 
               class="group p-5 rounded-3xl bg-white border border-slate-200 hover:border-slate-400 hover:shadow-xl hover:shadow-slate-900/5 transition-all duration-300 flex flex-col items-center text-center transform hover:-translate-y-1">
                <div class="w-16 h-16 rounded-2xl bg-slate-50 border border-slate-100 group-hover:scale-110 group-hover:bg-indigo-50 group-hover:border-indigo-200 transition-all duration-300 flex items-center justify-center mb-3.5 shadow-xs">
                    @if($category->icon)
                        <img src="{{ asset('storage/' . $category->icon) }}" alt="{{ $category->name }}" class="w-9 h-9 object-contain">
                    @else
                        <svg class="w-8 h-8 text-slate-700 group-hover:text-indigo-600 transition-colors" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.752 11.168l-3.197-2.132A1 1 0 0010 9.87v4.263a1 1 0 001.555.832l3.197-2.132a1 1 0 000-1.664z" />
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    @endif
                </div>
                <h3 class="font-extrabold text-slate-900 text-sm group-hover:text-indigo-600 transition-colors">{{ $category->name }}</h3>
                <span class="text-xs font-semibold text-slate-400 mt-1">{{ $category->products_count }} Akun Tersedia</span>
            </a>
        @empty
            <div class="col-span-full py-8 text-center text-slate-400 text-sm">
                Belum ada kategori yang aktif.
            </div>
        @endforelse
    </div>
</section>

<!-- ========================================================================= -->
<!-- 3. AKUN GAME TERBARU (DATA ASLI DARI DATABASE + FOTO NYATA ADMIN)          -->
<!-- ========================================================================= -->
<section id="produk-unggulan" class="py-20 bg-white border-y border-slate-200">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <div class="flex flex-col sm:flex-row sm:items-center justify-between mb-10 gap-4">
            <div>
                <div class="inline-flex items-center space-x-2 px-3 py-1 rounded-full bg-slate-100 border border-slate-200 text-slate-800 text-[11px] font-bold tracking-wider uppercase mb-2">
                    <span>Etalase Pilihan</span>
                </div>
                <h2 class="text-3xl sm:text-4xl font-black tracking-tight text-slate-900">Akun Game Terbaru</h2>
            </div>
            
            <a href="{{ route('products.index') }}" 
               class="inline-flex items-center space-x-2 text-sm font-extrabold text-slate-900 hover:text-indigo-600 transition group">
                <span>Lihat Semua Katalog ({{ $allAvailableCount }})</span>
                <svg class="w-4 h-4 transform group-hover:translate-x-1 transition-transform" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 5l7 7-7 7" />
                </svg>
            </a>
        </div>

        @if($latestProducts->isEmpty())
            <div class="text-center py-20 bg-slate-50 rounded-3xl border border-slate-200">
                <div class="w-16 h-16 rounded-2xl bg-white border border-slate-200 flex items-center justify-center mx-auto mb-4 text-slate-400 shadow-xs">
                    <svg class="w-8 h-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4" />
                    </svg>
                </div>
                <h3 class="text-lg font-extrabold text-slate-900">Belum Ada Akun Tersedia</h3>
                <p class="text-slate-500 text-sm mt-1 max-w-sm mx-auto">Akun baru sedang dalam proses kurasi dan verifikasi kredensial oleh admin.</p>
            </div>
        @else
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
                @foreach($latestProducts as $product)
                    <div class="group bg-white rounded-3xl border border-slate-200 hover:border-slate-400 hover:shadow-xl hover:shadow-slate-900/5 transition-all duration-300 overflow-hidden flex flex-col transform hover:-translate-y-1">
                        
                        <!-- Thumbnail Foto Nyata Akun Game -->
                        <div class="relative h-52 bg-slate-100 overflow-hidden">
                            @if($product->thumbnail)
                                <img src="{{ asset('storage/' . $product->thumbnail) }}" alt="{{ $product->title }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                            @else
                                <div class="w-full h-full flex flex-col items-center justify-center bg-gradient-to-br from-slate-100 to-indigo-50/50 p-4 text-center">
                                    <div class="w-12 h-12 rounded-2xl bg-white border border-slate-200 flex items-center justify-center mb-2 shadow-xs">
                                        <svg class="w-6 h-6 text-slate-700" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 5v2m0 4v2m0 4v2M5 5a2 2 0 00-2 2v3a2 2 0 110 4v3a2 2 0 002 2h14a2 2 0 002-2v-3a2 2 0 110-4V7a2 2 0 00-2-2H5z" />
                                        </svg>
                                    </div>
                                    <span class="text-xs font-bold text-slate-700">{{ $product->category->name }}</span>
                                </div>
                            @endif

                            <!-- Kategori Badge -->
                            <div class="absolute top-3.5 left-3.5">
                                <span class="px-3 py-1 rounded-xl text-xs font-extrabold bg-white/95 backdrop-blur-md text-slate-900 border border-slate-200/80 shadow-xs">
                                    {{ $product->category->name }}
                                </span>
                            </div>

                            <!-- Status Badge -->
                            <div class="absolute top-3.5 right-3.5">
                                @if($product->isAvailable())
                                    <span class="px-2.5 py-1 rounded-xl text-xs font-black bg-emerald-500 text-white shadow-xs">
                                        TERSEDIA
                                    </span>
                                @else
                                    <span class="px-2.5 py-1 rounded-xl text-xs font-black bg-slate-600 text-white shadow-xs">
                                        TERJUAL
                                    </span>
                                @endif
                            </div>
                        </div>

                        <!-- Info & Harga Akun -->
                        <div class="p-6 flex-1 flex flex-col justify-between space-y-4">
                            <div>
                                <h3 class="font-extrabold text-slate-900 text-base line-clamp-2 group-hover:text-indigo-600 transition-colors">
                                    {{ $product->title }}
                                </h3>
                                
                                @if($product->short_description)
                                    <p class="text-xs text-slate-500 line-clamp-2 mt-1.5 leading-relaxed">
                                        {{ $product->short_description }}
                                    </p>
                                @endif
                            </div>

                            <div class="pt-3 border-t border-slate-100 flex items-center justify-between">
                                <div>
                                    <span class="text-[10px] font-bold uppercase tracking-wider text-slate-400 block">Harga Pas</span>
                                    <span class="text-lg font-black text-slate-950">{{ $product->formatted_price }}</span>
                                </div>

                                <a href="{{ route('products.show', $product->slug) }}" 
                                   class="px-4 py-2 rounded-xl text-xs font-black bg-slate-950 hover:bg-indigo-600 text-white transition-colors duration-200 shadow-xs">
                                    Lihat Detail
                                </a>
                            </div>
                        </div>

                    </div>
                @endforeach
            </div>
        @endif

    </div>
</section>

<!-- ========================================================================= -->
<!-- 4. KENAPA MEMILIH KAMI (WHY CHOOSE US)                                    -->
<!-- ========================================================================= -->
<section class="py-24 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
    <div class="text-center max-w-2xl mx-auto mb-16 space-y-3">
        <div class="inline-flex items-center space-x-2 px-3 py-1 rounded-full bg-slate-100 border border-slate-200 text-slate-800 text-[11px] font-bold tracking-wider uppercase">
            <span>Standar Keamanan Tertinggi</span>
        </div>
        <h2 class="text-3xl sm:text-4xl font-black tracking-tight text-slate-900">Kenapa Memilih ANDRA JB?</h2>
        <p class="text-slate-500 text-sm">
            Dibangun khusus untuk gamer yang menginginkan transaksi cepat tanpa rasa khawatir akun bermasalah di kemudian hari.
        </p>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
        <!-- Benefit 1 -->
        <div class="p-8 rounded-3xl bg-white border border-slate-200/90 shadow-xs hover:border-slate-400 hover:shadow-lg transition-all duration-300 space-y-4">
            <div class="w-12 h-12 rounded-2xl bg-indigo-50 border border-indigo-100 flex items-center justify-center text-indigo-600">
                <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z" />
                </svg>
            </div>
            <h3 class="text-base font-extrabold text-slate-900">Proses Cepat & Otomatis</h3>
            <p class="text-xs text-slate-600 leading-relaxed">
                Tidak perlu menunggu admin berjam-jam. Kredensial akun (email, password, kode pemulihan) langsung terbuka detik itu juga setelah bayar.
            </p>
        </div>

        <!-- Benefit 2 -->
        <div class="p-8 rounded-3xl bg-white border border-slate-200/90 shadow-xs hover:border-slate-400 hover:shadow-lg transition-all duration-300 space-y-4">
            <div class="w-12 h-12 rounded-2xl bg-emerald-50 border border-emerald-100 flex items-center justify-center text-emerald-600">
                <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v1m6 11h2m-6 0h-2v4m0-11v3m0 0h.01M12 12h4.01M16 20h4M4 12h4m12 0h.01M5 8h2a1 1 0 001-1V5a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1zm12 0h2a1 1 0 001-1V5a1 1 0 00-1-1h-2a1 1 0 00-1 1v2a1 1 0 001 1zM5 20h2a1 1 0 001-1v-2a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1z" />
                </svg>
            </div>
            <h3 class="text-base font-extrabold text-slate-900">QRIS Dinamis Semua Bank</h3>
            <p class="text-xs text-slate-600 leading-relaxed">
                Mendukung BCA, Mandiri, BRI, BNI, GoPay, DANA, OVO, dan ShopeePay. Tanpa biaya admin tersembunyi dengan kode unik otomatis.
            </p>
        </div>

        <!-- Benefit 3 -->
        <div class="p-8 rounded-3xl bg-white border border-slate-200/90 shadow-xs hover:border-slate-400 hover:shadow-lg transition-all duration-300 space-y-4">
            <div class="w-12 h-12 rounded-2xl bg-cyan-50 border border-cyan-100 flex items-center justify-center text-cyan-600">
                <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                </svg>
            </div>
            <h3 class="text-base font-extrabold text-slate-900">Data Akun Jelas & Valid</h3>
            <p class="text-xs text-slate-600 leading-relaxed">
                Setiap akun dicek kelengkapan bind, email pertama, serta riwayat pembelian hero/skin untuk menjamin 100% kepemilikan bersih.
            </p>
        </div>

        <!-- Benefit 4 -->
        <div class="p-8 rounded-3xl bg-white border border-slate-200/90 shadow-xs hover:border-slate-400 hover:shadow-lg transition-all duration-300 space-y-4">
            <div class="w-12 h-12 rounded-2xl bg-amber-50 border border-amber-100 flex items-center justify-center text-amber-600">
                <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                </svg>
            </div>
            <h3 class="text-base font-extrabold text-slate-900">Garansi Anti-Hackback</h3>
            <p class="text-xs text-slate-600 leading-relaxed">
                Garansi uang kembali 100% atau pergantian unit akun setara jika terjadi kendala login atau percobaan penarikan akun sepihak.
            </p>
        </div>
    </div>
</section>

<!-- ========================================================================= -->
<!-- 5. CARA KERJA TRANSAKSI (HOW IT WORKS - 5 LANGKAH MUDAH)                  -->
<!-- ========================================================================= -->
<section id="cara-kerja" class="py-24 bg-gradient-to-b from-white via-slate-50/50 to-white border-t border-slate-200">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <div class="text-center max-w-2xl mx-auto mb-16 space-y-3">
            <div class="inline-flex items-center space-x-2 px-3 py-1 rounded-full bg-indigo-50 border border-indigo-200 text-indigo-700 text-[11px] font-bold tracking-wider uppercase">
                <span>Panduan Belanja</span>
            </div>
            <h2 class="text-3xl sm:text-4xl font-black tracking-tight text-slate-900">Cara Kerja Transaksi</h2>
            <p class="text-slate-500 text-sm">
                Proses super simpel hanya dalam 5 langkah praktis tanpa perlu chat manual yang memakan waktu.
            </p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-5 gap-4 relative">
            <!-- Step 1 -->
            <div class="p-6 rounded-3xl bg-white border border-slate-200/90 shadow-xs flex flex-col items-center text-center space-y-3 relative group hover:border-slate-400 transition">
                <div class="w-12 h-12 rounded-2xl bg-slate-900 text-white flex items-center justify-center font-black text-sm shadow-md">
                    01
                </div>
                <h4 class="font-extrabold text-slate-900 text-sm">Pilih Akun</h4>
                <p class="text-xs text-slate-500 leading-relaxed">Cari akun impianmu di katalog berdasarkan game, hero, dan rank.</p>
            </div>

            <!-- Step 2 -->
            <div class="p-6 rounded-3xl bg-white border border-slate-200/90 shadow-xs flex flex-col items-center text-center space-y-3 relative group hover:border-slate-400 transition">
                <div class="w-12 h-12 rounded-2xl bg-slate-900 text-white flex items-center justify-center font-black text-sm shadow-md">
                    02
                </div>
                <h4 class="font-extrabold text-slate-900 text-sm">Checkout</h4>
                <p class="text-xs text-slate-500 leading-relaxed">Isi nama, email, dan nomor WhatsApp aktif untuk invoice resmi.</p>
            </div>

            <!-- Step 3 -->
            <div class="p-6 rounded-3xl bg-white border border-slate-200/90 shadow-xs flex flex-col items-center text-center space-y-3 relative group hover:border-slate-400 transition">
                <div class="w-12 h-12 rounded-2xl bg-indigo-600 text-white flex items-center justify-center font-black text-sm shadow-md shadow-indigo-600/20">
                    03
                </div>
                <h4 class="font-extrabold text-slate-900 text-sm">Bayar QRIS</h4>
                <p class="text-xs text-slate-500 leading-relaxed">Scan kode QRIS dinamis lewat aplikasi m-banking atau e-wallet apa saja.</p>
            </div>

            <!-- Step 4 -->
            <div class="p-6 rounded-3xl bg-white border border-slate-200/90 shadow-xs flex flex-col items-center text-center space-y-3 relative group hover:border-slate-400 transition">
                <div class="w-12 h-12 rounded-2xl bg-slate-900 text-white flex items-center justify-center font-black text-sm shadow-md">
                    04
                </div>
                <h4 class="font-extrabold text-slate-900 text-sm">Auto Verifikasi</h4>
                <p class="text-xs text-slate-500 leading-relaxed">Sistem mengecek dana masuk detik itu juga tanpa perlu upload bukti struk.</p>
            </div>

            <!-- Step 5 -->
            <div class="p-6 rounded-3xl bg-white border border-slate-200/90 shadow-xs flex flex-col items-center text-center space-y-3 relative group hover:border-slate-400 transition">
                <div class="w-12 h-12 rounded-2xl bg-emerald-600 text-white flex items-center justify-center font-black text-sm shadow-md shadow-emerald-600/20">
                    05
                </div>
                <h4 class="font-extrabold text-slate-900 text-sm">Akun Diterima</h4>
                <p class="text-xs text-slate-500 leading-relaxed">Kredensial akun langsung terbuka di layar dan siap dipakai mabar!</p>
            </div>
        </div>

    </div>
</section>

<!-- ========================================================================= -->
<!-- 6. CALL TO ACTION (CTA MEWAH JELANG FOOTER)                              -->
<!-- ========================================================================= -->
<section class="py-20 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
    <div class="relative overflow-hidden rounded-[40px] bg-gradient-to-br from-slate-950 via-slate-900 to-indigo-950 p-10 sm:p-16 text-white text-center shadow-2xl">
        
        <!-- Ambient Glow -->
        <div class="absolute -right-20 -bottom-20 w-96 h-96 rounded-full bg-indigo-500/20 blur-3xl pointer-events-none"></div>
        <div class="absolute -left-20 -top-20 w-96 h-96 rounded-full bg-cyan-500/15 blur-3xl pointer-events-none"></div>

        <div class="relative z-10 max-w-2xl mx-auto space-y-6">
            <span class="inline-flex items-center space-x-2 px-3.5 py-1 rounded-full bg-white/10 backdrop-blur-md border border-white/20 text-xs font-black uppercase tracking-widest text-indigo-300">
                <span>Siap Naik Rank?</span>
            </span>

            <h2 class="text-3xl sm:text-5xl font-black tracking-tight leading-tight">
                Cari Akun Game Impianmu Sekarang
            </h2>

            <p class="text-slate-300 text-sm sm:text-base leading-relaxed">
                Stok akun eksklusif dengan winrate tinggi dan koleksi langka diperbarui setiap hari. Amankan akun pilihanmu sebelum dibeli orang lain!
            </p>

            <div class="pt-4 flex flex-col sm:flex-row items-center justify-center gap-4">
                <a href="{{ route('products.index') }}" 
                   class="w-full sm:w-auto px-10 py-4 rounded-2xl font-black text-sm tracking-wide bg-white hover:bg-slate-100 text-slate-950 shadow-xl shadow-white/10 hover:shadow-2xl transition transform hover:-translate-y-0.5 text-center">
                    Lihat Semua Produk
                </a>
                <a href="{{ route('contact') }}" 
                   class="w-full sm:w-auto px-8 py-4 rounded-2xl font-bold text-sm tracking-wide bg-white/10 hover:bg-white/20 text-white border border-white/20 backdrop-blur-sm transition text-center">
                    Hubungi Admin
                </a>
            </div>
        </div>

    </div>
</section>

<!-- ========================================================================= -->
<!-- JAVASCRIPT: HERO PARALLAX & 3D PHYSICS INTERACTIVITY                      -->
<!-- ========================================================================= -->
<script>
function heroParallax() {
    return {
        offsetX: 0,
        offsetY: 0,
        init() {
            window.addEventListener('mousemove', (e) => {
                // Calculate distance from screen center (-1 to 1)
                const centerX = window.innerWidth / 2;
                const centerY = window.innerHeight / 2;
                this.offsetX = (e.clientX - centerX);
                this.offsetY = (e.clientY - centerY);
            });
        }
    }
}
</script>

<style>
@keyframes float {
    0%, 100% {
        transform: translateY(0px) rotate(0deg);
    }
    50% {
        transform: translateY(-10px) rotate(1.5deg);
    }
}
</style>
@endsection
