@extends('layouts.main')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6 sm:py-10">
    <!-- Header Page -->
    <div class="mb-4 sm:mb-8">
        <h1 class="text-2xl sm:text-3xl font-extrabold text-slate-900 tracking-tight">Katalog Akun Game</h1>
        <p class="text-slate-500 text-xs sm:text-sm mt-1">Pilih dan beli akun game siap pakai dengan jaminan keamanan terverifikasi 100%.</p>
    </div>

    <!-- Quick Category Horizontal Filter Bar for Instant Tap -->
    <div class="flex items-center space-x-2 overflow-x-auto pb-3 mb-4 -mx-4 px-4 sm:mx-0 sm:px-0 scrollbar-none">
        <a href="{{ route('products.index', array_merge(request()->except(['category', 'page']))) }}" 
           class="shrink-0 px-3.5 py-1.5 rounded-full text-xs font-bold transition {{ !request('category') ? 'bg-indigo-600 text-white shadow-xs' : 'bg-white border border-slate-200 text-slate-700 hover:border-slate-300' }}">
            Semua Game
        </a>
        @foreach($categories as $cat)
            <a href="{{ route('products.index', array_merge(request()->except(['category', 'page']), ['category' => $cat->slug])) }}" 
               class="shrink-0 px-3.5 py-1.5 rounded-full text-xs font-bold transition flex items-center space-x-1.5 {{ request('category') === $cat->slug ? 'bg-indigo-600 text-white shadow-xs' : 'bg-white border border-slate-200 text-slate-700 hover:border-slate-300' }}">
                @if($cat->icon)
                    <img src="{{ asset('storage/' . $cat->icon) }}" alt="{{ $cat->name }}" class="w-3.5 h-3.5 object-contain" loading="lazy" decoding="async">
                @endif
                <span>{{ $cat->name }}</span>
            </a>
        @endforeach
    </div>

    <!-- Search & Filter Bar -->
    <div class="bg-white border border-slate-200 rounded-2xl p-4 sm:p-5 mb-6 sm:mb-8 shadow-xs" x-data="{ showFilter: {{ request()->anyFilled(['status', 'min_price', 'max_price', 'sort']) ? 'true' : 'false' }} }">
        <form action="{{ route('products.index') }}" method="GET" class="space-y-4">
            <!-- Top Search Row on Mobile / Grid on Desktop -->
            <div class="flex flex-col lg:grid lg:grid-cols-4 gap-3 sm:gap-4">
                <!-- Search Input -->
                <div class="lg:col-span-2 relative flex-1">
                    <label class="hidden lg:block text-xs font-bold text-slate-700 mb-1">Cari Akun</label>
                    <div class="flex items-center gap-2">
                        <div class="relative flex-1">
                            <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari nama skin, hero, rank, atau judul..." class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-2.5 pl-10 text-xs sm:text-sm text-slate-800 placeholder-slate-400 focus:bg-white focus:outline-none focus:border-indigo-500 transition">
                            <svg class="w-4 h-4 text-slate-400 absolute left-3.5 top-3 sm:top-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                            </svg>
                        </div>
                        <!-- Mobile Filter Button Toggle -->
                        <button type="button" @click="showFilter = !showFilter" class="lg:hidden px-3 py-2.5 rounded-xl border border-slate-200 bg-slate-50 text-slate-700 text-xs font-bold flex items-center space-x-1.5 shrink-0 transition" :class="showFilter ? 'bg-indigo-50 border-indigo-200 text-indigo-600' : ''">
                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z" />
                            </svg>
                            <span>Filter</span>
                            @if(request()->anyFilled(['category', 'status', 'min_price', 'max_price', 'sort']))
                                <span class="w-2 h-2 rounded-full bg-indigo-600"></span>
                            @endif
                        </button>
                    </div>
                </div>

                <!-- Category Filter (Desktop Always, Mobile inside Collapsible) -->
                <div :class="showFilter ? 'block' : 'hidden lg:block'">
                    <label class="block text-xs font-bold text-slate-700 mb-1">Pilih Game</label>
                    <select name="category" class="w-full bg-slate-50 border border-slate-200 rounded-xl px-3 py-2.5 text-xs sm:text-sm text-slate-800 focus:bg-white focus:outline-none focus:border-indigo-500 transition">
                        <option value="">Semua Game</option>
                        @foreach($categories as $cat)
                            <option value="{{ $cat->slug }}" {{ request('category') === $cat->slug ? 'selected' : '' }}>
                                {{ $cat->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <!-- Status Filter (Desktop Always, Mobile inside Collapsible) -->
                <div :class="showFilter ? 'block' : 'hidden lg:block'">
                    <label class="block text-xs font-bold text-slate-700 mb-1">Status Ketersediaan</label>
                    <select name="status" class="w-full bg-slate-50 border border-slate-200 rounded-xl px-3 py-2.5 text-xs sm:text-sm text-slate-800 focus:bg-white focus:outline-none focus:border-indigo-500 transition">
                        <option value="" {{ request('status') === '' ? 'selected' : '' }}>Semua Status</option>
                        <option value="available" {{ request('status') === 'available' ? 'selected' : '' }}>Tersedia (Ready)</option>
                        <option value="sold" {{ request('status') === 'sold' ? 'selected' : '' }}>Sudah Terjual</option>
                    </select>
                </div>
            </div>

            <!-- Price & Sort Filter (Desktop Always, Mobile inside Collapsible) -->
            <div :class="showFilter ? 'grid' : 'hidden lg:grid'" class="grid-cols-1 sm:grid-cols-3 gap-3 sm:gap-4 pt-3 border-t border-slate-100">
                <div>
                    <label class="block text-xs font-bold text-slate-700 mb-1">Harga Minimum (Rp)</label>
                    <input type="number" name="min_price" value="{{ request('min_price') }}" placeholder="0" class="w-full bg-slate-50 border border-slate-200 rounded-xl px-3 py-2 text-xs sm:text-sm text-slate-800 placeholder-slate-400 focus:bg-white focus:outline-none focus:border-indigo-500 transition">
                </div>
                <div>
                    <label class="block text-xs font-bold text-slate-700 mb-1">Harga Maksimum (Rp)</label>
                    <input type="number" name="max_price" value="{{ request('max_price') }}" placeholder="Tanpa batas" class="w-full bg-slate-50 border border-slate-200 rounded-xl px-3 py-2 text-xs sm:text-sm text-slate-800 placeholder-slate-400 focus:bg-white focus:outline-none focus:border-indigo-500 transition">
                </div>
                <div>
                    <label class="block text-xs font-bold text-slate-700 mb-1">Urutan</label>
                    <select name="sort" class="w-full bg-slate-50 border border-slate-200 rounded-xl px-3 py-2 text-xs sm:text-sm text-slate-800 focus:bg-white focus:outline-none focus:border-indigo-500 transition">
                        <option value="latest" {{ request('sort') === 'latest' ? 'selected' : '' }}>Terbaru</option>
                        <option value="price_asc" {{ request('sort') === 'price_asc' ? 'selected' : '' }}>Harga Terendah</option>
                        <option value="price_desc" {{ request('sort') === 'price_desc' ? 'selected' : '' }}>Harga Tertinggi</option>
                    </select>
                </div>
            </div>

            <!-- Action buttons -->
            <div class="flex items-center justify-end space-x-3 pt-2" :class="showFilter ? 'flex' : 'hidden lg:flex'">
                @if(request()->anyFilled(['search', 'category', 'status', 'min_price', 'max_price', 'sort']))
                    <a href="{{ route('products.index') }}" class="px-4 py-2 rounded-xl text-xs font-semibold text-slate-500 hover:text-slate-800 transition">
                        Reset Filter
                    </a>
                @endif
                <button type="submit" class="w-full sm:w-auto px-6 py-2.5 rounded-xl text-xs font-bold bg-indigo-600 hover:bg-indigo-700 text-white transition shadow-xs text-center">
                    Terapkan Filter
                </button>
            </div>
        </form>
    </div>

    <!-- Active Filters Summary -->
    <div class="flex items-center justify-between mb-4 sm:mb-6 text-xs sm:text-sm text-slate-500">
        <div>
            Menampilkan <span class="font-bold text-slate-900">{{ $products->total() }}</span> akun game
        </div>
    </div>

    <!-- Products Grid (2 Kolom di Mobile, 2 di Tablet, 4 di Desktop) -->
    @if($products->isEmpty())
        <div class="text-center py-16 sm:py-20 bg-white rounded-2xl border border-slate-200 shadow-xs">
            <svg class="w-12 h-12 sm:w-16 sm:h-16 text-slate-400 mx-auto mb-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
            </svg>
            <h3 class="text-lg sm:text-xl font-bold text-slate-900">Tidak ada akun yang sesuai kriteria</h3>
            <p class="text-slate-500 text-xs sm:text-sm mt-1">Coba kurangi kata kunci pencarian atau ubah batas filter harga.</p>
            <a href="{{ route('products.index') }}" class="inline-block mt-4 px-6 py-2.5 rounded-xl text-xs sm:text-sm font-bold bg-indigo-600 text-white hover:bg-indigo-700 transition">
                Tampilkan Semua Akun
            </a>
        </div>
    @else
        <div class="grid grid-cols-2 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-3 sm:gap-6">
            @foreach($products as $product)
                <div class="group bg-white rounded-2xl border border-slate-200 hover:border-indigo-400 hover:shadow-lg hover:shadow-indigo-500/5 transition-all duration-200 overflow-hidden flex flex-col {{ !$product->isAvailable() ? 'opacity-80' : '' }}">
                    <!-- Thumbnail -->
                    <div class="relative h-36 sm:h-48 bg-slate-100 overflow-hidden">
                        @if($product->thumbnail)
                            <img src="{{ asset('storage/' . $product->thumbnail) }}" alt="{{ $product->title }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300" loading="lazy" decoding="async">
                        @else
                            <div class="w-full h-full flex flex-col items-center justify-center bg-gradient-to-br from-slate-100 to-indigo-50 p-2 sm:p-4 text-center">
                                <svg class="w-8 h-8 sm:w-10 sm:h-10 text-indigo-400 mb-1 sm:mb-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 5v2m0 4v2m0 4v2M5 5a2 2 0 00-2 2v3a2 2 0 110 4v3a2 2 0 002 2h14a2 2 0 002-2v-3a2 2 0 110-4V7a2 2 0 00-2-2H5z" />
                                </svg>
                                <span class="text-[10px] sm:text-xs font-bold text-slate-600 line-clamp-1">{{ $product->category->name }}</span>
                            </div>
                        @endif

                        <!-- Category Badge -->
                        <div class="absolute top-2 left-2 sm:top-3 sm:left-3">
                            <span class="px-2 py-0.5 sm:px-2.5 sm:py-1 rounded-md sm:rounded-lg text-[9px] sm:text-xs font-bold bg-white/95 backdrop-blur-sm text-indigo-700 border border-slate-200 shadow-2xs">
                                {{ $product->category->name }}
                            </span>
                        </div>

                        <!-- Status Badge -->
                        <div class="absolute top-2 right-2 sm:top-3 sm:right-3">
                            @if($product->isAvailable())
                                <span class="px-1.5 py-0.5 sm:px-2.5 sm:py-1 rounded-md sm:rounded-lg text-[9px] sm:text-xs font-bold bg-emerald-600 text-white shadow-2xs">
                                    Ready
                                </span>
                            @else
                                <span class="px-1.5 py-0.5 sm:px-2.5 sm:py-1 rounded-md sm:rounded-lg text-[9px] sm:text-xs font-bold bg-slate-600 text-white shadow-2xs">
                                    Terjual
                                </span>
                            @endif
                        </div>
                    </div>

                    <!-- Card Body -->
                    <div class="p-3 sm:p-5 flex-1 flex flex-col justify-between space-y-2.5 sm:space-y-4">
                        <div>
                            <h3 class="font-bold text-slate-900 text-xs sm:text-base line-clamp-2 group-hover:text-indigo-600 transition" title="{{ $product->title }}">
                                {{ $product->title }}
                            </h3>
                            @if($product->short_description)
                                <p class="hidden sm:block text-xs text-slate-500 mt-2 line-clamp-2">
                                    {{ $product->short_description }}
                                </p>
                            @endif
                        </div>

                        <div class="pt-2 sm:pt-3 border-t border-slate-100 flex flex-col sm:flex-row sm:items-center justify-between gap-2 sm:gap-0">
                            <div>
                                <span class="text-[9px] sm:text-[11px] text-slate-400 font-medium block">Harga</span>
                                <span class="text-xs sm:text-lg font-extrabold text-indigo-600">{{ $product->formatted_price }}</span>
                            </div>

                            @if($product->isAvailable())
                                <a href="{{ route('products.show', $product->slug) }}" class="w-full sm:w-auto px-2.5 py-1.5 sm:px-4 sm:py-2 rounded-lg sm:rounded-xl text-[10px] sm:text-xs font-bold bg-indigo-600 hover:bg-indigo-700 text-white transition shadow-2xs text-center">
                                    Beli
                                </a>
                            @else
                                <span class="w-full sm:w-auto px-2.5 py-1.5 sm:px-3.5 sm:py-2 rounded-lg sm:rounded-xl text-[10px] sm:text-xs font-semibold bg-slate-100 text-slate-400 border border-slate-200 cursor-not-allowed text-center">
                                    Terjual
                                </span>
                            @endif
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        <!-- Pagination -->
        <div class="mt-8 sm:mt-10">
            {{ $products->links() }}
        </div>
    @endif
</div>
@endsection
