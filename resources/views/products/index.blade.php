@extends('layouts.main')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10">
    <!-- Header Page -->
    <div class="mb-8">
        <h1 class="text-3xl font-extrabold text-white tracking-tight">Katalog Akun Game</h1>
        <p class="text-slate-400 text-sm mt-1">Pilih dan beli akun game siap pakai dengan keamanan terverifikasi 100%.</p>
    </div>

    <!-- Search & Filter Bar -->
    <div class="bg-slate-900 border border-slate-800 rounded-2xl p-5 mb-8 shadow-xl">
        <form action="{{ route('products.index') }}" method="GET" class="space-y-4">
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
                <!-- Search Input -->
                <div class="lg:col-span-2 relative">
                    <label class="block text-xs font-semibold text-slate-400 mb-1">Cari Akun</label>
                    <div class="relative">
                        <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari nama skin, hero, rank, atau game..." class="w-full bg-slate-950 border border-slate-800 rounded-xl px-4 py-2.5 pl-10 text-sm text-white placeholder-slate-500 focus:outline-none focus:border-indigo-500 transition">
                        <svg class="w-4 h-4 text-slate-500 absolute left-3.5 top-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                        </svg>
                    </div>
                </div>

                <!-- Category Filter -->
                <div>
                    <label class="block text-xs font-semibold text-slate-400 mb-1">Pilih Game</label>
                    <select name="category" class="w-full bg-slate-950 border border-slate-800 rounded-xl px-3 py-2.5 text-sm text-white focus:outline-none focus:border-indigo-500 transition">
                        <option value="">Semua Game</option>
                        @foreach($categories as $cat)
                            <option value="{{ $cat->slug }}" {{ request('category') === $cat->slug ? 'selected' : '' }}>
                                {{ $cat->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <!-- Status Filter -->
                <div>
                    <label class="block text-xs font-semibold text-slate-400 mb-1">Status Ketersediaan</label>
                    <select name="status" class="w-full bg-slate-950 border border-slate-800 rounded-xl px-3 py-2.5 text-sm text-white focus:outline-none focus:border-indigo-500 transition">
                        <option value="" {{ request('status') === '' ? 'selected' : '' }}>Semua Status</option>
                        <option value="available" {{ request('status') === 'available' ? 'selected' : '' }}>Tersedia (Ready)</option>
                        <option value="sold" {{ request('status') === 'sold' ? 'selected' : '' }}>Sudah Terjual</option>
                    </select>
                </div>
            </div>

            <!-- Price & Sort Filter -->
            <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 pt-2 border-t border-slate-800/80">
                <div>
                    <label class="block text-xs font-semibold text-slate-400 mb-1">Harga Minimum (Rp)</label>
                    <input type="number" name="min_price" value="{{ request('min_price') }}" placeholder="0" class="w-full bg-slate-950 border border-slate-800 rounded-xl px-3 py-2 text-sm text-white focus:outline-none focus:border-indigo-500 transition">
                </div>
                <div>
                    <label class="block text-xs font-semibold text-slate-400 mb-1">Harga Maksimum (Rp)</label>
                    <input type="number" name="max_price" value="{{ request('max_price') }}" placeholder="Tanpa batas" class="w-full bg-slate-950 border border-slate-800 rounded-xl px-3 py-2 text-sm text-white focus:outline-none focus:border-indigo-500 transition">
                </div>
                <div>
                    <label class="block text-xs font-semibold text-slate-400 mb-1">Urutan</label>
                    <select name="sort" class="w-full bg-slate-950 border border-slate-800 rounded-xl px-3 py-2 text-sm text-white focus:outline-none focus:border-indigo-500 transition">
                        <option value="latest" {{ request('sort') === 'latest' ? 'selected' : '' }}>Terbaru</option>
                        <option value="price_asc" {{ request('sort') === 'price_asc' ? 'selected' : '' }}>Harga Terendah</option>
                        <option value="price_desc" {{ request('sort') === 'price_desc' ? 'selected' : '' }}>Harga Tertinggi</option>
                    </select>
                </div>
            </div>

            <div class="flex items-center justify-end space-x-3 pt-2">
                @if(request()->anyFilled(['search', 'category', 'status', 'min_price', 'max_price', 'sort']))
                    <a href="{{ route('products.index') }}" class="px-4 py-2 rounded-xl text-xs font-semibold text-slate-400 hover:text-white transition">
                        Reset Filter
                    </a>
                @endif
                <button type="submit" class="px-6 py-2.5 rounded-xl text-xs font-bold bg-indigo-600 hover:bg-indigo-500 text-white transition shadow-md shadow-indigo-600/20">
                    Terapkan Filter
                </button>
            </div>
        </form>
    </div>

    <!-- Active Filters Summary -->
    <div class="flex items-center justify-between mb-6 text-sm text-slate-400">
        <div>
            Menampilkan <span class="font-bold text-white">{{ $products->total() }}</span> akun game
        </div>
    </div>

    <!-- Products Grid -->
    @if($products->isEmpty())
        <div class="text-center py-20 bg-slate-900 rounded-3xl border border-slate-800">
            <svg class="w-16 h-16 text-slate-600 mx-auto mb-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
            </svg>
            <h3 class="text-xl font-bold text-white">Tidak ada akun yang sesuai kriteria</h3>
            <p class="text-slate-400 text-sm mt-1">Coba kurangi kata kunci pencarian atau ubah filter harga.</p>
            <a href="{{ route('products.index') }}" class="inline-block mt-4 px-6 py-2.5 rounded-xl text-sm font-semibold bg-indigo-600 text-white hover:bg-indigo-500 transition">
                Tampilkan Semua Akun
            </a>
        </div>
    @else
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
            @foreach($products as $product)
                <div class="group bg-slate-900 rounded-2xl border border-slate-800 hover:border-indigo-500/40 transition-all duration-300 overflow-hidden flex flex-col {{ !$product->isAvailable() ? 'opacity-75' : '' }}">
                    <!-- Thumbnail -->
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

                        <!-- Category Badge -->
                        <div class="absolute top-3 left-3">
                            <span class="px-2.5 py-1 rounded-lg text-xs font-bold bg-slate-950/80 backdrop-blur-md text-indigo-300 border border-slate-700/80">
                                {{ $product->category->name }}
                            </span>
                        </div>

                        <!-- Status Badge -->
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
                                <span class="text-[11px] text-slate-400 block">Harga</span>
                                <span class="text-lg font-extrabold text-emerald-400">{{ $product->formatted_price }}</span>
                            </div>

                            @if($product->isAvailable())
                                <a href="{{ route('products.show', $product->slug) }}" class="px-4 py-2 rounded-xl text-xs font-bold bg-indigo-600 hover:bg-indigo-500 text-white transition shadow-md shadow-indigo-600/20">
                                    Detail & Beli
                                </a>
                            @else
                                <span class="px-3.5 py-2 rounded-xl text-xs font-semibold bg-slate-800 text-slate-400 border border-slate-700/60 cursor-not-allowed">
                                    Terjual
                                </span>
                            @endif
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        <!-- Pagination -->
        <div class="mt-10">
            {{ $products->links() }}
        </div>
    @endif
</div>
@endsection
