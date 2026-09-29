@extends('layouts.main')

@section('content')
<!-- Hero Section -->
<div class="relative overflow-hidden bg-gradient-to-b from-indigo-950/40 via-slate-950 to-slate-950 pt-12 pb-20 lg:pt-20 lg:pb-28 border-b border-slate-800/80">
    <div class="absolute inset-0 bg-[radial-gradient(ellipse_80%_80%_at_50%_-20%,rgba(99,102,241,0.25),rgba(255,255,255,0))]"></div>
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative">
        <div class="text-center max-w-3xl mx-auto space-y-6">
            <div class="inline-flex items-center space-x-2 px-3.5 py-1.5 rounded-full bg-indigo-500/10 border border-indigo-500/30 text-indigo-300 text-xs font-semibold">
                <span class="w-2 h-2 rounded-full bg-emerald-400 animate-ping"></span>
                <span>Marketplace Akun Game Terpercaya #1</span>
            </div>

            <h1 class="text-4xl sm:text-5xl lg:text-6xl font-extrabold tracking-tight text-white leading-tight">
                Jual Beli Akun Game <br>
                <span class="bg-gradient-to-r from-indigo-400 via-cyan-400 to-emerald-400 bg-clip-text text-transparent">Cepat, Aman & Bergaransi</span>
            </h1>

            <p class="text-base sm:text-lg text-slate-300 leading-relaxed">
                Temukan akun impianmu dari Mobile Legends, Free Fire, Roblox, FC Mobile hingga GTA V. Transaksi langsung via QRIS dengan penyerahan data akun instan tanpa tipu-tipu.
            </p>

            <!-- CTA Buttons -->
            <div class="pt-4 flex flex-col sm:flex-row items-center justify-center gap-4">
                <a href="{{ route('products.index') }}" class="w-full sm:w-auto px-8 py-3.5 rounded-xl font-bold bg-indigo-600 hover:bg-indigo-500 text-white shadow-xl shadow-indigo-600/30 hover:shadow-indigo-600/50 transition transform hover:-translate-y-0.5 text-center">
                    Jelajahi Semua Akun
                </a>
                <a href="#kategori" class="w-full sm:w-auto px-8 py-3.5 rounded-xl font-bold bg-slate-800/80 hover:bg-slate-800 text-slate-200 border border-slate-700/80 transition text-center">
                    Pilih Kategori Game
                </a>
            </div>

            <!-- Stats Bar -->
            <div class="pt-10 grid grid-cols-2 md:grid-cols-4 gap-4 max-w-4xl mx-auto">
                <div class="p-4 rounded-2xl bg-slate-900/60 border border-slate-800 text-center">
                    <div class="text-2xl sm:text-3xl font-extrabold text-indigo-400">{{ $allAvailableCount }}</div>
                    <div class="text-xs text-slate-400 mt-1">Akun Ready Stok</div>
                </div>
                <div class="p-4 rounded-2xl bg-slate-900/60 border border-slate-800 text-center">
                    <div class="text-2xl sm:text-3xl font-extrabold text-emerald-400">{{ $soldCount }}+</div>
                    <div class="text-xs text-slate-400 mt-1">Akun Berhasil Terjual</div>
                </div>
                <div class="p-4 rounded-2xl bg-slate-900/60 border border-slate-800 text-center">
                    <div class="text-2xl sm:text-3xl font-extrabold text-cyan-400">100%</div>
                    <div class="text-xs text-slate-400 mt-1">QRIS Resmi Midtrans</div>
                </div>
                <div class="p-4 rounded-2xl bg-slate-900/60 border border-slate-800 text-center">
                    <div class="text-2xl sm:text-3xl font-extrabold text-amber-400">Lifetime</div>
                    <div class="text-xs text-slate-400 mt-1">Garansi Anti-Hackback</div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Kategori Game Section -->
<section id="kategori" class="py-16 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
    <div class="flex flex-col md:flex-row md:items-end justify-between mb-10">
        <div>
            <span class="text-indigo-400 text-xs font-bold uppercase tracking-widest">Kategori Populer</span>
            <h2 class="text-2xl sm:text-3xl font-extrabold text-white mt-1">Pilih Game Favoritmu</h2>
        </div>
        <p class="text-slate-400 text-sm mt-2 md:mt-0">Tersedia beragam akun spesifikasi rank tinggi dan skin sultan</p>
    </div>

    <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-6 gap-4">
        @foreach($categories as $category)
            <a href="{{ route('products.index', ['category' => $category->slug]) }}" class="group p-5 rounded-2xl bg-slate-900 border border-slate-800 hover:border-indigo-500/50 hover:bg-slate-800/80 transition-all duration-200 flex flex-col items-center text-center">
                <div class="w-14 h-14 rounded-2xl bg-indigo-600/10 border border-indigo-500/20 group-hover:scale-110 group-hover:bg-indigo-600/20 transition-all flex items-center justify-center mb-3">
                    @if($category->icon)
                        <img src="{{ asset('storage/' . $category->icon) }}" alt="{{ $category->name }}" class="w-8 h-8 object-contain">
                    @else
                        <svg class="w-7 h-7 text-indigo-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.752 11.168l-3.197-2.132A1 1 0 0010 9.87v4.263a1 1 0 001.555.832l3.197-2.132a1 1 0 000-1.664z" />
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    @endif
                </div>
                <h3 class="font-bold text-white text-sm group-hover:text-indigo-400 transition">{{ $category->name }}</h3>
                <span class="text-xs text-slate-400 mt-1">{{ $category->products_count }} Akun Ready</span>
            </a>
        @endforeach
    </div>
</section>

<!-- Produk Terbaru & Tersedia -->
<section class="py-12 bg-slate-900/40 border-y border-slate-800/80">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex flex-col sm:flex-row sm:items-center justify-between mb-8">
            <div>
                <span class="text-indigo-400 text-xs font-bold uppercase tracking-widest">Akun Pilihan</span>
                <h2 class="text-2xl sm:text-3xl font-extrabold text-white mt-1">Akun Game Siap Dibeli</h2>
            </div>
            <a href="{{ route('products.index') }}" class="mt-3 sm:mt-0 inline-flex items-center text-sm font-semibold text-indigo-400 hover:text-indigo-300">
                Lihat Semua ({{ $allAvailableCount }})
                <svg class="w-4 h-4 ml-1.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                </svg>
            </a>
        </div>

        @if($latestProducts->isEmpty())
            <div class="text-center py-16 bg-slate-900 rounded-3xl border border-slate-800">
                <svg class="w-12 h-12 text-slate-600 mx-auto mb-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4" />
                </svg>
                <h3 class="text-lg font-bold text-white">Belum Ada Akun Tersedia</h3>
                <p class="text-slate-400 text-sm mt-1">Stok akun baru sedang dalam proses pengecekan oleh admin.</p>
            </div>
        @else
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
                @foreach($latestProducts as $product)
                    <div class="group bg-slate-900 rounded-2xl border border-slate-800 hover:border-indigo-500/40 transition-all duration-300 overflow-hidden flex flex-col">
                        <!-- Product Thumbnail -->
                        <div class="relative h-48 bg-slate-800 overflow-hidden">
                            @if($product->thumbnail)
                                <img src="{{ asset('storage/' . $product->thumbnail) }}" alt="{{ $product->title }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300">
                            @else
                                <div class="w-full h-full flex flex-col items-center justify-center bg-gradient-to-br from-slate-800 to-indigo-950/60 p-4 text-center">
                                    <svg class="w-10 h-10 text-indigo-400/50 mb-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 5v2m0 4v2m0 4v2M5 5a2 2 0 00-2 2v3a2 2 0 110 4v3a2 2 0 002 2h14a2 2 0 002-2v-3a2 2 0 110-4V7a2 2 0 00-2-2H5z" />
                                    </svg>
                                    <span class="text-xs font-semibold text-slate-300">{{ $product->category->name }}</span>
                                </div>
                            @endif

                            <!-- Game Badge -->
                            <div class="absolute top-3 left-3">
                                <span class="px-2.5 py-1 rounded-lg text-xs font-bold bg-slate-950/80 backdrop-blur-md text-indigo-300 border border-slate-700/80">
                                    {{ $product->category->name }}
                                </span>
                            </div>

                            <!-- Availability Badge -->
                            <div class="absolute top-3 right-3">
                                @if($product->isAvailable())
                                    <span class="px-2.5 py-1 rounded-lg text-xs font-bold bg-emerald-500/90 text-white shadow-md">
                                        Tersedia
                                    </span>
                                @else
                                    <span class="px-2.5 py-1 rounded-lg text-xs font-bold bg-rose-600/90 text-white shadow-md">
                                        Terjual
                                    </span>
                                @endif
                            </div>
                        </div>

                        <!-- Card Body -->
                        <div class="p-5 flex-1 flex flex-col justify-between space-y-4">
                            <div>
                                <h3 class="font-bold text-white text-base line-clamp-2 group-hover:text-indigo-400 transition" title="{{ $product->title }}">
                                    {{ $product->title }}
                                </h3>
                                @if($product->short_description)
                                    <p class="text-xs text-slate-400 mt-2 line-clamp-2">
                                        {{ $product->short_description }}
                                    </p>
                                @endif
                            </div>

                            <div class="pt-3 border-t border-slate-800/80 flex items-center justify-between">
                                <div>
                                    <span class="text-[11px] text-slate-400 block">Harga Pas</span>
                                    <span class="text-lg font-extrabold text-emerald-400">{{ $product->formatted_price }}</span>
                                </div>
                                <a href="{{ route('products.show', $product->slug) }}" class="px-4 py-2 rounded-xl text-xs font-bold bg-indigo-600 hover:bg-indigo-500 text-white transition shadow-md shadow-indigo-600/20">
                                    Beli Sekarang
                                </a>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
    </div>
</section>

<!-- Mengapa Memilih Kami -->
<section class="py-20 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
    <div class="text-center max-w-2xl mx-auto mb-14">
        <span class="text-indigo-400 text-xs font-bold uppercase tracking-widest">Keamanan Terjamin</span>
        <h2 class="text-3xl font-extrabold text-white mt-1">Mengapa Transaksi di JB GAME?</h2>
        <p class="text-slate-400 text-sm mt-2">Standar keamanan tertinggi untuk kenyamanan jual beli akun game tanpa rasa was-was.</p>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
        <div class="p-8 rounded-3xl bg-slate-900 border border-slate-800 flex flex-col items-center text-center">
            <div class="w-16 h-16 rounded-2xl bg-indigo-500/10 border border-indigo-500/30 flex items-center justify-center text-indigo-400 mb-6">
                <svg class="w-8 h-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                </svg>
            </div>
            <h3 class="text-lg font-bold text-white mb-2">Garansi Anti-Hackback</h3>
            <p class="text-sm text-slate-400 leading-relaxed">
                Seluruh akun game telah melewati proses kurasi dan verifikasi kepemilikan yang ketat. Dilengkapi jaminan ganti rugi atau uang kembali jika terjadi masalah.
            </p>
        </div>

        <div class="p-8 rounded-3xl bg-slate-900 border border-slate-800 flex flex-col items-center text-center">
            <div class="w-16 h-16 rounded-2xl bg-cyan-500/10 border border-cyan-500/30 flex items-center justify-center text-cyan-400 mb-6">
                <svg class="w-8 h-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z" />
                </svg>
            </div>
            <h3 class="text-lg font-bold text-white mb-2">Penyerahan Akun Instan</h3>
            <p class="text-sm text-slate-400 leading-relaxed">
                Tanpa perlu menunggu lama, begitu pembayaran QRIS kamu terverifikasi oleh payment gateway, data login akun game langsung terbuka otomatis di layar pesananmu.
            </p>
        </div>

        <div class="p-8 rounded-3xl bg-slate-900 border border-slate-800 flex flex-col items-center text-center">
            <div class="w-16 h-16 rounded-2xl bg-emerald-500/10 border border-emerald-500/30 flex items-center justify-center text-emerald-400 mb-6">
                <svg class="w-8 h-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v1m6 11h2m-6 0h-2v4m0-11v3m0 0h.01M12 12h4.01M16 20h4M4 12h4m12 0h.01M5 8h2a1 1 0 001-1V5a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1zm12 0h2a1 1 0 001-1V5a1 1 0 00-1-1h-2a1 1 0 00-1 1v2a1 1 0 001 1zM5 20h2a1 1 0 001-1v-2a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1z" />
                </svg>
            </div>
            <h3 class="text-lg font-bold text-white mb-2">Pembayaran QRIS Midtrans</h3>
            <p class="text-sm text-slate-400 leading-relaxed">
                Scan kode QRIS dari aplikasi apa saja (BCA, GoPay, ShopeePay, Dana, OVO, dll). Otomatis terkonfirmasi dalam hitungan detik 24 jam nonstop.
            </p>
        </div>
    </div>
</section>
@endsection
