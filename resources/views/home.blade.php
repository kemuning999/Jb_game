@extends('layouts.main')

@section('content')
<!-- ========================================================================= -->
<!-- 1. HERO SECTION (WHITE GAMING PREMIUM + 3D INTERACTIVE GAMING ELEMENTS)   -->
<!-- ========================================================================= -->
<section id="hero" class="relative overflow-hidden bg-gradient-to-b from-white via-[#fcfdff] to-[#f8fafc] pt-6 pb-12 sm:pt-16 sm:pb-28 lg:pt-24 lg:pb-36 border-b border-slate-200/80" 
         x-data="heroParallax()">

    <!-- Ambient Grid & Soft White Glow Background -->
    <div class="absolute inset-0 pointer-events-none opacity-60" 
         style="background-image: radial-gradient(rgba(148, 163, 184, 0.2) 1px, transparent 1px), radial-gradient(rgba(99, 102, 241, 0.08) 1px, transparent 1px); background-size: 32px 32px, 64px 64px; background-position: 0 0, 16px 16px;"></div>
    
    <div class="absolute w-[800px] h-[500px] rounded-full bg-gradient-to-tr from-indigo-100/40 via-cyan-50/50 to-transparent blur-3xl -top-24 left-1/2 -translate-x-1/2 pointer-events-none"></div>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">

        <!-- HEADLINE UTAMA & CALL TO ACTION -->
        <div class="text-center max-w-3xl mx-auto space-y-4 sm:space-y-6 pt-2 sm:pt-6">
            
            <!-- Sleek Badge -->
            <div class="inline-flex items-center space-x-1.5 sm:space-x-2 px-3 sm:px-4 py-1 sm:py-1.5 rounded-full bg-white border border-slate-200/90 text-slate-800 text-[11px] sm:text-xs font-bold shadow-xs hover:border-slate-300 transition">
                <span class="w-1.5 h-1.5 sm:w-2 sm:h-2 rounded-full bg-indigo-600 animate-pulse"></span>
                <span class="tracking-wide">Marketplace Akun Game #1 Indonesia</span>
                <span class="text-slate-300">•</span>
                <span class="text-indigo-600 font-extrabold">Instant QRIS</span>
            </div>

            <!-- Headline Utama (Jelas & Kontras Tinggi) -->
            <h1 class="text-3xl sm:text-5xl lg:text-7xl font-black tracking-tight text-slate-950 leading-[1.15] sm:leading-[1.1] uppercase">
                Jual Beli <br class="hidden sm:inline">
                <span class="bg-gradient-to-r from-slate-950 via-indigo-900 to-indigo-600 bg-clip-text text-transparent">
                    Akun Game
                </span>
            </h1>

            <!-- Subheadline -->
            <p class="text-xs sm:text-lg lg:text-xl text-slate-600 font-medium leading-relaxed max-w-2xl mx-auto px-2 sm:px-0">
                Temukan akun game yang sesuai dengan kebutuhanmu. Transaksi aman, instan tanpa ribet dengan QRIS otomatis dan garansi anti-hackback seumur hidup.
            </p>

            <!-- Call To Action Buttons (Lihat Produk & Cara Kerja) -->
            <div class="pt-1 sm:pt-2 flex flex-col sm:flex-row items-center justify-center gap-2.5 sm:gap-4 max-w-md mx-auto">
                <!-- CTA 1: Lihat Produk -->
                <a href="#produk-unggulan" 
                   class="w-full sm:w-auto px-6 sm:px-9 py-3 sm:py-4 rounded-xl sm:rounded-2xl font-black text-xs sm:text-sm tracking-wide bg-slate-950 hover:bg-slate-900 text-white shadow-lg shadow-slate-950/20 hover:shadow-2xl hover:shadow-slate-950/30 transition-all duration-200 transform hover:-translate-y-0.5 text-center flex items-center justify-center space-x-2">
                    <span>Lihat Akun Siap Pakai</span>
                    <svg class="w-4 h-4 text-indigo-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M14 5l7 7m0 0l-7 7m7-7H3" />
                    </svg>
                </a>

                <!-- CTA 2: Cara Kerja -->
                <a href="#cara-kerja" 
                   class="w-full sm:w-auto px-6 sm:px-8 py-3 sm:py-4 rounded-xl sm:rounded-2xl font-bold text-xs sm:text-sm tracking-wide bg-white hover:bg-slate-50 text-slate-800 border border-slate-200 shadow-xs hover:border-slate-300 transition-all duration-200 text-center flex items-center justify-center space-x-2">
                    <svg class="w-4 h-4 text-indigo-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    <span>Cara Kerja</span>
                </a>
            </div>

            <!-- Stats Bar Minimalis & Mewah -->
            <div class="pt-6 sm:pt-10 grid grid-cols-2 md:grid-cols-4 gap-2.5 sm:gap-4 max-w-4xl mx-auto">
                <div class="p-3 sm:p-4 rounded-xl sm:rounded-2xl bg-white border border-slate-200/80 shadow-xs text-center">
                    <div class="text-xl sm:text-3xl font-black text-slate-900">{{ $allAvailableCount }}</div>
                    <div class="text-[11px] sm:text-xs font-semibold text-slate-500 mt-0.5 sm:mt-1">Akun Ready</div>
                </div>
                <div class="p-3 sm:p-4 rounded-xl sm:rounded-2xl bg-white border border-slate-200/80 shadow-xs text-center">
                    <div class="text-xl sm:text-3xl font-black text-slate-900">{{ $soldCount }}+</div>
                    <div class="text-[11px] sm:text-xs font-semibold text-slate-500 mt-0.5 sm:mt-1">Terjual Sukses</div>
                </div>
                <div class="p-3 sm:p-4 rounded-xl sm:rounded-2xl bg-white border border-slate-200/80 shadow-xs text-center">
                    <div class="text-xl sm:text-3xl font-black text-indigo-600">0 Detik</div>
                    <div class="text-[11px] sm:text-xs font-semibold text-slate-500 mt-0.5 sm:mt-1">Auto QRIS</div>
                </div>
                <div class="p-3 sm:p-4 rounded-xl sm:rounded-2xl bg-white border border-slate-200/80 shadow-xs text-center">
                    <div class="text-xl sm:text-3xl font-black text-emerald-600">100%</div>
                    <div class="text-[11px] sm:text-xs font-semibold text-slate-500 mt-0.5 sm:mt-1">Garansi Aman</div>
                </div>
            </div>

        </div>
    </div>
</section>

<!-- ========================================================================= -->
<!-- 2. ETALASE AKUN GAME SIAP PAKAI (SEMUA DENGAN FOTO NYATA ADMIN)            -->
<!-- ========================================================================= -->
<section id="produk-unggulan" class="py-10 sm:py-20 bg-white border-y border-slate-200 content-visibility-auto">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <div class="flex flex-col sm:flex-row sm:items-center justify-between mb-4 sm:mb-6 gap-2 sm:gap-4">
            <div>
                <div class="inline-flex items-center space-x-2 px-2.5 py-0.5 sm:px-3 sm:py-1 rounded-full bg-indigo-50 border border-indigo-200 text-indigo-700 text-[10px] sm:text-[11px] font-bold tracking-wider uppercase mb-1.5 sm:mb-2">
                    <span>Etalase Pilihan</span>
                </div>
                <h2 class="text-2xl sm:text-4xl font-black tracking-tight text-slate-900">Akun Game Siap Pakai</h2>
            </div>
            
            <a href="{{ route('products.index') }}" 
               class="inline-flex items-center space-x-1.5 sm:space-x-2 text-xs sm:text-sm font-extrabold text-slate-900 hover:text-indigo-600 transition group self-start sm:self-auto">
                <span>Lihat Semua Katalog ({{ $allAvailableCount }})</span>
                <svg class="w-4 h-4 transform group-hover:translate-x-1 transition-transform" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 5l7 7-7 7" />
                </svg>
            </a>
        </div>

        <!-- Filter Cepat Kategori Game (Tap Langsung Berubah) -->
        <div class="flex items-center space-x-2 overflow-x-auto pb-3 mb-6 sm:mb-8 -mx-4 px-4 sm:mx-0 sm:px-0 scrollbar-none">
            <a href="{{ route('home') }}#produk-unggulan" 
               class="shrink-0 px-4 py-2 rounded-full text-xs font-bold transition flex items-center space-x-1.5 {{ !request('category') ? 'bg-slate-950 text-white shadow-xs' : 'bg-slate-100 border border-slate-200 text-slate-700 hover:bg-slate-200' }}">
                <span>Semua Game</span>
                <span class="text-[10px] {{ !request('category') ? 'text-slate-300' : 'text-slate-500' }}">({{ $allAvailableCount }})</span>
            </a>
            @foreach($categories as $cat)
                <a href="{{ route('home', ['category' => $cat->slug]) }}#produk-unggulan" 
                   class="shrink-0 px-3.5 py-2 rounded-full text-xs font-bold transition flex items-center space-x-2 {{ request('category') === $cat->slug ? 'bg-indigo-600 text-white shadow-xs' : 'bg-white border border-slate-200 text-slate-700 hover:border-slate-300' }}">
                    @if($cat->icon)
                        <img src="{{ asset('storage/' . $cat->icon) }}" alt="{{ $cat->name }}" class="w-4 h-4 object-contain" loading="lazy" decoding="async">
                    @endif
                    <span>{{ $cat->name }}</span>
                    <span class="text-[10px] {{ request('category') === $cat->slug ? 'text-indigo-200' : 'text-slate-400' }}">({{ $cat->products_count }})</span>
                </a>
            @endforeach
        </div>

        @if($latestProducts->isEmpty())
            <div class="text-center py-12 sm:py-20 bg-slate-50 rounded-2xl sm:rounded-3xl border border-slate-200">
                <div class="w-12 h-12 sm:w-16 sm:h-16 rounded-xl sm:rounded-2xl bg-white border border-slate-200 flex items-center justify-center mx-auto mb-3 sm:mb-4 text-slate-400 shadow-xs">
                    <svg class="w-6 h-6 sm:w-8 sm:h-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4" />
                    </svg>
                </div>
                <h3 class="text-base sm:text-lg font-extrabold text-slate-900">Belum Ada Akun Tersedia</h3>
                <p class="text-slate-500 text-xs sm:text-sm mt-1 max-w-sm mx-auto">Akun baru sedang dalam proses kurasi dan verifikasi kredensial oleh admin.</p>
            </div>
        @else
            <!-- 2 Kolom di Mobile, 2 di Tablet, 4 di Desktop -->
            <div class="grid grid-cols-2 sm:grid-cols-2 lg:grid-cols-4 gap-3 sm:gap-6">
                @foreach($latestProducts as $product)
                    <div class="group bg-white rounded-2xl sm:rounded-3xl border border-slate-200 hover:border-slate-400 hover:shadow-xl hover:shadow-slate-900/5 transition-all duration-300 overflow-hidden flex flex-col transform hover:-translate-y-1">
                        
                        <!-- Thumbnail Foto Nyata Akun Game -->
                        <div class="relative h-36 sm:h-52 bg-slate-100 overflow-hidden">
                            @if($product->thumbnail)
                                <img src="{{ asset('storage/' . $product->thumbnail) }}" alt="{{ $product->title }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500" loading="lazy" decoding="async">
                            @else
                                <div class="w-full h-full flex flex-col items-center justify-center bg-gradient-to-br from-slate-100 to-indigo-50/50 p-2 sm:p-4 text-center">
                                    <div class="w-8 h-8 sm:w-12 sm:h-12 rounded-lg sm:rounded-2xl bg-white border border-slate-200 flex items-center justify-center mb-1.5 shadow-xs">
                                        <svg class="w-4 h-4 sm:w-6 sm:h-6 text-slate-700" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 5v2m0 4v2m0 4v2M5 5a2 2 0 00-2 2v3a2 2 0 110 4v3a2 2 0 002 2h14a2 2 0 002-2v-3a2 2 0 110-4V7a2 2 0 00-2-2H5z" />
                                        </svg>
                                    </div>
                                    <span class="text-[10px] sm:text-xs font-bold text-slate-700 line-clamp-1">{{ $product->category->name }}</span>
                                </div>
                            @endif

                            <!-- Kategori Badge -->
                            <div class="absolute top-2 left-2 sm:top-3.5 sm:left-3.5">
                                <span class="px-2 py-0.5 sm:px-3 sm:py-1 rounded-lg sm:rounded-xl text-[10px] sm:text-xs font-extrabold bg-white/95 backdrop-blur-md text-slate-900 border border-slate-200/80 shadow-2xs">
                                    {{ $product->category->name }}
                                </span>
                            </div>

                            <!-- Status Badge -->
                            <div class="absolute top-2 right-2 sm:top-3.5 sm:right-3.5">
                                @if($product->isAvailable())
                                    <span class="px-1.5 py-0.5 sm:px-2.5 sm:py-1 rounded-lg sm:rounded-xl text-[9px] sm:text-xs font-black bg-emerald-500 text-white shadow-2xs">
                                        READY
                                    </span>
                                @else
                                    <span class="px-1.5 py-0.5 sm:px-2.5 sm:py-1 rounded-lg sm:rounded-xl text-[9px] sm:text-xs font-black bg-slate-600 text-white shadow-2xs">
                                        TERJUAL
                                    </span>
                                @endif
                            </div>
                        </div>

                        <!-- Info & Harga Akun -->
                        <div class="p-3 sm:p-6 flex-1 flex flex-col justify-between space-y-2 sm:space-y-4">
                            <div>
                                <h3 class="font-extrabold text-slate-900 text-xs sm:text-base line-clamp-2 group-hover:text-indigo-600 transition-colors">
                                    {{ $product->title }}
                                </h3>
                                
                                @if($product->short_description)
                                    <p class="hidden sm:block text-xs text-slate-500 line-clamp-2 mt-1.5 leading-relaxed">
                                        {{ $product->short_description }}
                                    </p>
                                @endif
                            </div>

                            <div class="pt-2 sm:pt-3 border-t border-slate-100 flex flex-col sm:flex-row sm:items-center justify-between gap-2 sm:gap-0">
                                <div>
                                    <span class="text-[9px] sm:text-[10px] font-bold uppercase tracking-wider text-slate-400 block">Harga</span>
                                    <span class="text-xs sm:text-lg font-black text-slate-950">{{ $product->formatted_price }}</span>
                                </div>

                                <a href="{{ route('products.show', $product->slug) }}" 
                                   class="w-full sm:w-auto px-2.5 py-1.5 sm:px-4 sm:py-2 rounded-lg sm:rounded-xl text-[10px] sm:text-xs font-black bg-slate-950 hover:bg-indigo-600 text-white transition-colors duration-200 shadow-2xs text-center">
                                    Detail
                                </a>
                            </div>
                        </div>

                    </div>
                @endforeach
            </div>

            <!-- Button Lihat Semua Katalog -->
            <div class="mt-8 sm:mt-12 text-center">
                <a href="{{ route('products.index') }}" 
                   class="inline-flex items-center space-x-2 px-6 sm:px-8 py-3.5 sm:py-4 rounded-xl sm:rounded-2xl font-extrabold text-xs sm:text-sm bg-slate-950 hover:bg-indigo-600 text-white shadow-md hover:shadow-xl transition-all duration-200 transform hover:-translate-y-0.5">
                    <span>Buka Semua Katalog Akun ({{ $allAvailableCount }})</span>
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M14 5l7 7m0 0l-7 7m7-7H3" />
                    </svg>
                </a>
            </div>
        @endif

    </div>
</section>

<!-- ========================================================================= -->
<!-- 4. KENAPA MEMILIH KAMI (WHY CHOOSE US)                                    -->
<!-- ========================================================================= -->
<section class="py-10 sm:py-24 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 content-visibility-auto">
    <div class="text-center max-w-2xl mx-auto mb-8 sm:mb-16 space-y-2 sm:space-y-3">
        <div class="inline-flex items-center space-x-2 px-2.5 py-0.5 sm:px-3 sm:py-1 rounded-full bg-slate-100 border border-slate-200 text-slate-800 text-[10px] sm:text-[11px] font-bold tracking-wider uppercase">
            <span>Standar Keamanan Tertinggi</span>
        </div>
        <h2 class="text-2xl sm:text-4xl font-black tracking-tight text-slate-900">Kenapa Memilih ANDRA JB?</h2>
        <p class="text-slate-500 text-xs sm:text-sm">
            Dibangun khusus untuk gamer yang menginginkan transaksi cepat tanpa rasa khawatir akun bermasalah di kemudian hari.
        </p>
    </div>

    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-3 sm:gap-6">
        <!-- Benefit 1 -->
        <div class="p-4 sm:p-8 rounded-2xl sm:rounded-3xl bg-white border border-slate-200/90 shadow-xs hover:border-slate-400 hover:shadow-lg transition-all duration-300 space-y-2.5 sm:space-y-4">
            <div class="w-10 h-10 sm:w-12 sm:h-12 rounded-xl sm:rounded-2xl bg-indigo-50 border border-indigo-100 flex items-center justify-center text-indigo-600">
                <svg class="w-5 h-5 sm:w-6 sm:h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z" />
                </svg>
            </div>
            <h3 class="text-sm sm:text-base font-extrabold text-slate-900">Proses Cepat & Otomatis</h3>
            <p class="text-xs text-slate-600 leading-relaxed">
                Tidak perlu menunggu admin berjam-jam. Kredensial akun (email, password, kode pemulihan) langsung terbuka detik itu juga setelah bayar.
            </p>
        </div>

        <!-- Benefit 2 -->
        <div class="p-4 sm:p-8 rounded-2xl sm:rounded-3xl bg-white border border-slate-200/90 shadow-xs hover:border-slate-400 hover:shadow-lg transition-all duration-300 space-y-2.5 sm:space-y-4">
            <div class="w-10 h-10 sm:w-12 sm:h-12 rounded-xl sm:rounded-2xl bg-emerald-50 border border-emerald-100 flex items-center justify-center text-emerald-600">
                <svg class="w-5 h-5 sm:w-6 sm:h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v1m6 11h2m-6 0h-2v4m0-11v3m0 0h.01M12 12h4.01M16 20h4M4 12h4m12 0h.01M5 8h2a1 1 0 001-1V5a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1zm12 0h2a1 1 0 001-1V5a1 1 0 00-1-1h-2a1 1 0 00-1 1v2a1 1 0 001 1zM5 20h2a1 1 0 001-1v-2a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1z" />
                </svg>
            </div>
            <h3 class="text-sm sm:text-base font-extrabold text-slate-900">QRIS Dinamis Semua Bank</h3>
            <p class="text-xs text-slate-600 leading-relaxed">
                Mendukung BCA, Mandiri, BRI, BNI, GoPay, DANA, OVO, dan ShopeePay. Tanpa biaya admin tersembunyi dengan kode unik otomatis.
            </p>
        </div>

        <!-- Benefit 3 -->
        <div class="p-4 sm:p-8 rounded-2xl sm:rounded-3xl bg-white border border-slate-200/90 shadow-xs hover:border-slate-400 hover:shadow-lg transition-all duration-300 space-y-2.5 sm:space-y-4">
            <div class="w-10 h-10 sm:w-12 sm:h-12 rounded-xl sm:rounded-2xl bg-cyan-50 border border-cyan-100 flex items-center justify-center text-cyan-600">
                <svg class="w-5 h-5 sm:w-6 sm:h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                </svg>
            </div>
            <h3 class="text-sm sm:text-base font-extrabold text-slate-900">Data Akun Jelas & Valid</h3>
            <p class="text-xs text-slate-600 leading-relaxed">
                Setiap akun dicek kelengkapan bind, email pertama, serta riwayat pembelian hero/skin untuk menjamin 100% kepemilikan bersih.
            </p>
        </div>

        <!-- Benefit 4 -->
        <div class="p-4 sm:p-8 rounded-2xl sm:rounded-3xl bg-white border border-slate-200/90 shadow-xs hover:border-slate-400 hover:shadow-lg transition-all duration-300 space-y-2.5 sm:space-y-4">
            <div class="w-10 h-10 sm:w-12 sm:h-12 rounded-xl sm:rounded-2xl bg-amber-50 border border-amber-100 flex items-center justify-center text-amber-600">
                <svg class="w-5 h-5 sm:w-6 sm:h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                </svg>
            </div>
            <h3 class="text-sm sm:text-base font-extrabold text-slate-900">Garansi Anti-Hackback</h3>
            <p class="text-xs text-slate-600 leading-relaxed">
                Garansi uang kembali 100% atau pergantian unit akun setara jika terjadi kendala login atau percobaan penarikan akun sepihak.
            </p>
        </div>
    </div>
</section>

<!-- ========================================================================= -->
<!-- 5. CARA KERJA TRANSAKSI (HOW IT WORKS - 5 LANGKAH MUDAH)                  -->
<!-- ========================================================================= -->
<section id="cara-kerja" class="py-10 sm:py-24 bg-gradient-to-b from-white via-slate-50/50 to-white border-t border-slate-200 content-visibility-auto">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <div class="text-center max-w-2xl mx-auto mb-8 sm:mb-16 space-y-2 sm:space-y-3">
            <div class="inline-flex items-center space-x-2 px-2.5 py-0.5 sm:px-3 sm:py-1 rounded-full bg-indigo-50 border border-indigo-200 text-indigo-700 text-[10px] sm:text-[11px] font-bold tracking-wider uppercase">
                <span>Panduan Belanja</span>
            </div>
            <h2 class="text-2xl sm:text-4xl font-black tracking-tight text-slate-900">Cara Kerja Transaksi</h2>
            <p class="text-slate-500 text-xs sm:text-sm">
                Proses super simpel hanya dalam 5 langkah praktis tanpa perlu chat manual yang memakan waktu.
            </p>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-5 gap-3 sm:gap-4 relative">
            <!-- Step 1 -->
            <div class="p-4 sm:p-6 rounded-2xl sm:rounded-3xl bg-white border border-slate-200/90 shadow-xs flex flex-col items-center text-center space-y-2 sm:space-y-3 relative group hover:border-slate-400 transition">
                <div class="w-10 h-10 sm:w-12 sm:h-12 rounded-xl sm:rounded-2xl bg-slate-900 text-white flex items-center justify-center font-black text-xs sm:text-sm shadow-md">
                    01
                </div>
                <h4 class="font-extrabold text-slate-900 text-xs sm:text-sm">Pilih Akun</h4>
                <p class="text-[11px] sm:text-xs text-slate-500 leading-relaxed">Cari akun impianmu di katalog berdasarkan game, hero, dan rank.</p>
            </div>

            <!-- Step 2 -->
            <div class="p-4 sm:p-6 rounded-2xl sm:rounded-3xl bg-white border border-slate-200/90 shadow-xs flex flex-col items-center text-center space-y-2 sm:space-y-3 relative group hover:border-slate-400 transition">
                <div class="w-10 h-10 sm:w-12 sm:h-12 rounded-xl sm:rounded-2xl bg-slate-900 text-white flex items-center justify-center font-black text-xs sm:text-sm shadow-md">
                    02
                </div>
                <h4 class="font-extrabold text-slate-900 text-xs sm:text-sm">Checkout</h4>
                <p class="text-[11px] sm:text-xs text-slate-500 leading-relaxed">Isi nama, email, dan nomor WhatsApp aktif untuk invoice resmi.</p>
            </div>

            <!-- Step 3 -->
            <div class="p-4 sm:p-6 rounded-2xl sm:rounded-3xl bg-white border border-slate-200/90 shadow-xs flex flex-col items-center text-center space-y-2 sm:space-y-3 relative group hover:border-slate-400 transition">
                <div class="w-10 h-10 sm:w-12 sm:h-12 rounded-xl sm:rounded-2xl bg-indigo-600 text-white flex items-center justify-center font-black text-xs sm:text-sm shadow-md shadow-indigo-600/20">
                    03
                </div>
                <h4 class="font-extrabold text-slate-900 text-xs sm:text-sm">Bayar QRIS</h4>
                <p class="text-[11px] sm:text-xs text-slate-500 leading-relaxed">Scan kode QRIS dinamis lewat aplikasi m-banking atau e-wallet apa saja.</p>
            </div>

            <!-- Step 4 -->
            <div class="p-4 sm:p-6 rounded-2xl sm:rounded-3xl bg-white border border-slate-200/90 shadow-xs flex flex-col items-center text-center space-y-2 sm:space-y-3 relative group hover:border-slate-400 transition">
                <div class="w-10 h-10 sm:w-12 sm:h-12 rounded-xl sm:rounded-2xl bg-slate-900 text-white flex items-center justify-center font-black text-xs sm:text-sm shadow-md">
                    04
                </div>
                <h4 class="font-extrabold text-slate-900 text-xs sm:text-sm">Auto Verifikasi</h4>
                <p class="text-[11px] sm:text-xs text-slate-500 leading-relaxed">Sistem mengecek dana masuk detik itu juga tanpa perlu upload bukti struk.</p>
            </div>

            <!-- Step 5 -->
            <div class="p-4 sm:p-6 rounded-2xl sm:rounded-3xl bg-white border border-slate-200/90 shadow-xs flex flex-col items-center text-center space-y-2 sm:space-y-3 relative group hover:border-slate-400 transition">
                <div class="w-10 h-10 sm:w-12 sm:h-12 rounded-xl sm:rounded-2xl bg-emerald-600 text-white flex items-center justify-center font-black text-xs sm:text-sm shadow-md shadow-emerald-600/20">
                    05
                </div>
                <h4 class="font-extrabold text-slate-900 text-xs sm:text-sm">Akun Diterima</h4>
                <p class="text-[11px] sm:text-xs text-slate-500 leading-relaxed">Kredensial akun langsung terbuka di layar dan siap dipakai mabar!</p>
            </div>
        </div>

    </div>
</section>

<!-- ========================================================================= -->
<!-- 6. CALL TO ACTION (CTA MEWAH JELANG FOOTER)                              -->
<!-- ========================================================================= -->
<section class="py-10 sm:py-20 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 content-visibility-auto">
    <div class="relative overflow-hidden rounded-3xl sm:rounded-[40px] bg-gradient-to-br from-slate-950 via-slate-900 to-indigo-950 p-6 sm:p-16 text-white text-center shadow-2xl">
        
        <!-- Ambient Glow -->
        <div class="absolute -right-20 -bottom-20 w-96 h-96 rounded-full bg-indigo-500/20 blur-3xl pointer-events-none"></div>
        <div class="absolute -left-20 -top-20 w-96 h-96 rounded-full bg-cyan-500/15 blur-3xl pointer-events-none"></div>

        <div class="relative z-10 max-w-2xl mx-auto space-y-4 sm:space-y-6">
            <span class="inline-flex items-center space-x-2 px-3 py-1 rounded-full bg-white/10 backdrop-blur-md border border-white/20 text-[10px] sm:text-xs font-black uppercase tracking-widest text-indigo-300">
                <span>Siap Naik Rank?</span>
            </span>

            <h2 class="text-2xl sm:text-5xl font-black tracking-tight leading-tight">
                Cari Akun Game Impianmu Sekarang
            </h2>

            <p class="text-slate-300 text-xs sm:text-base leading-relaxed">
                Stok akun eksklusif dengan winrate tinggi dan koleksi langka diperbarui setiap hari. Amankan akun pilihanmu sebelum dibeli orang lain!
            </p>

            <div class="pt-2 sm:pt-4 flex flex-col sm:flex-row items-center justify-center gap-3 sm:gap-4">
                <a href="{{ route('products.index') }}" 
                   class="w-full sm:w-auto px-8 sm:px-10 py-3.5 sm:py-4 rounded-xl sm:rounded-2xl font-black text-xs sm:text-sm tracking-wide bg-white hover:bg-slate-100 text-slate-950 shadow-xl shadow-white/10 hover:shadow-2xl transition transform hover:-translate-y-0.5 text-center">
                    Lihat Semua Produk
                </a>
                <a href="{{ route('contact') }}" 
                   class="w-full sm:w-auto px-6 sm:px-8 py-3.5 sm:py-4 rounded-xl sm:rounded-2xl font-bold text-xs sm:text-sm tracking-wide bg-white/10 hover:bg-white/20 text-white border border-white/20 backdrop-blur-sm transition text-center">
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
        ticking: false,
        init() {
            // Hanya aktif di perangkat dengan mouse / pointer fine (laptop/PC), lewati di layar sentuh HP
            if (!window.matchMedia('(hover: hover) and (pointer: fine)').matches) {
                return;
            }
            window.addEventListener('mousemove', (e) => {
                if (!this.ticking) {
                    window.requestAnimationFrame(() => {
                        const centerX = window.innerWidth / 2;
                        const centerY = window.innerHeight / 2;
                        this.offsetX = Math.round(e.clientX - centerX);
                        this.offsetY = Math.round(e.clientY - centerY);
                        this.ticking = false;
                    });
                    this.ticking = true;
                }
            }, { passive: true });
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
