@extends('layouts.main')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10 bg-white">
    <!-- Breadcrumb -->
    <nav class="flex items-center space-x-2 text-xs text-slate-500 mb-6">
        <a href="{{ route('home') }}" class="hover:text-indigo-600">Home</a>
        <span>/</span>
        <a href="{{ route('products.index') }}" class="hover:text-indigo-600">Produk</a>
        <span>/</span>
        <a href="{{ route('products.index', ['category' => $product->category->slug]) }}" class="hover:text-indigo-600">{{ $product->category->name }}</a>
        <span>/</span>
        <span class="text-slate-800 font-medium truncate max-w-xs">{{ $product->title }}</span>
    </nav>

    <div class="grid grid-cols-1 lg:grid-cols-12 gap-10">
        <!-- Left: Images / Gallery -->
        <div class="lg:col-span-7 space-y-4" x-data="{ currentImg: '{{ $product->thumbnail ? asset('storage/' . $product->thumbnail) : '' }}' }">
            <!-- Main Photo -->
            <div class="relative w-full h-80 sm:h-96 md:h-[420px] rounded-3xl bg-slate-50 border border-slate-200 overflow-hidden shadow-xs flex items-center justify-center">
                <template x-if="currentImg">
                    <img :src="currentImg" alt="{{ $product->title }}" class="w-full h-full object-cover">
                </template>
                <template x-if="!currentImg">
                    <div class="flex flex-col items-center justify-center text-slate-400">
                        <svg class="w-16 h-16 mb-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                        </svg>
                        <span class="text-sm font-medium">Foto Akun Preview</span>
                    </div>
                </template>

                <!-- Status Badge Overlay -->
                <div class="absolute top-4 right-4">
                    @if($product->isAvailable())
                        <span class="px-3.5 py-1.5 rounded-xl text-xs font-extrabold bg-emerald-600 text-white shadow-md shadow-emerald-600/20">
                            STOK TERSEDIA
                        </span>
                    @else
                        <span class="px-3.5 py-1.5 rounded-xl text-xs font-extrabold bg-rose-600 text-white shadow-md shadow-rose-600/20">
                            SUDAH TERJUAL
                        </span>
                    @endif
                </div>
            </div>

            <!-- Gallery Thumbnails (if available) -->
            @if($product->images && is_array($product->images) && count($product->images) > 0)
                <div class="flex items-center space-x-3 overflow-x-auto pb-2">
                    @if($product->thumbnail)
                        <button type="button" @click="currentImg = '{{ asset('storage/' . $product->thumbnail) }}'" class="w-20 h-16 rounded-xl bg-slate-100 border border-slate-200 overflow-hidden shrink-0 focus:outline-none focus:ring-2 focus:ring-indigo-600">
                            <img src="{{ asset('storage/' . $product->thumbnail) }}" class="w-full h-full object-cover">
                        </button>
                    @endif
                    @foreach($product->images as $img)
                        <button type="button" @click="currentImg = '{{ asset('storage/' . $img) }}'" class="w-20 h-16 rounded-xl bg-slate-100 border border-slate-200 overflow-hidden shrink-0 focus:outline-none focus:ring-2 focus:ring-indigo-600">
                            <img src="{{ asset('storage/' . $img) }}" class="w-full h-full object-cover">
                        </button>
                    @endforeach
                </div>
            @endif

            <!-- Security Assurance Notice -->
            <div class="p-5 rounded-2xl bg-indigo-50/70 border border-indigo-200 flex items-start space-x-3.5 text-xs text-indigo-900">
                <svg class="w-5 h-5 text-indigo-600 shrink-0 mt-0.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                </svg>
                <div class="leading-relaxed">
                    <strong class="text-indigo-950 block font-semibold mb-0.5">Keamanan Akun & Kredensial Terjamin</strong>
                    Informasi login seperti Username dan Password akun game ini dirahasiakan dan dienkripsi oleh sistem. Data hanya akan diberikan secara otomatis kepada Anda di halaman pesanan segera setelah pembayaran Midtrans terverifikasi.
                </div>
            </div>
        </div>

        <!-- Right: Info & Purchase Card -->
        <div class="lg:col-span-5 space-y-6">
            <div class="p-6 sm:p-8 rounded-3xl bg-white border border-slate-200 shadow-md space-y-6">
                <!-- Category & Game -->
                <div class="flex items-center space-x-2">
                    <span class="px-3 py-1 rounded-lg text-xs font-bold bg-indigo-50 text-indigo-700 border border-indigo-200">
                        {{ $product->category->name }}
                    </span>
                    <span class="text-xs text-slate-500">ID Produk: #{{ $product->id }}</span>
                </div>

                <!-- Product Title -->
                <h1 class="text-2xl sm:text-3xl font-extrabold text-slate-900 leading-tight">
                    {{ $product->title }}
                </h1>

                <!-- Short Summary -->
                @if($product->short_description)
                    <p class="text-sm text-slate-700 bg-slate-50 p-3.5 rounded-xl border border-slate-200 leading-relaxed">
                        {{ $product->short_description }}
                    </p>
                @endif

                <!-- Price Box -->
                <div class="p-4 rounded-2xl bg-slate-50 border border-slate-200">
                    <span class="text-xs text-slate-500 uppercase tracking-wider block font-semibold">Harga Akun</span>
                    <div class="text-3xl font-extrabold text-emerald-600 mt-1">
                        {{ $product->formatted_price }}
                    </div>
                </div>

                <!-- Action Button: Beli Sekarang -->
                <div>
                    @if($product->isAvailable())
                        @auth
                            <a href="{{ route('checkout.show', $product->slug) }}" class="w-full flex items-center justify-center space-x-2 py-4 px-6 rounded-2xl text-base font-extrabold bg-indigo-600 hover:bg-indigo-700 text-white shadow-lg shadow-indigo-600/25 transition transform hover:-translate-y-0.5">
                                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" />
                                </svg>
                                <span>Beli Sekarang</span>
                            </a>
                        @else
                            <a href="{{ route('login', ['redirect' => route('checkout.show', $product->slug)]) }}" class="w-full flex items-center justify-center space-x-2 py-4 px-6 rounded-2xl text-base font-extrabold bg-indigo-600 hover:bg-indigo-700 text-white shadow-lg shadow-indigo-600/25 transition transform hover:-translate-y-0.5">
                                <span>Login Untuk Beli Akun</span>
                            </a>
                            <p class="text-center text-xs text-slate-500 mt-2">
                                Belum punya akun? <a href="{{ route('register') }}" class="text-indigo-600 font-semibold hover:underline">Daftar gratis di sini</a>
                            </p>
                        @endauth
                    @else
                        <button disabled class="w-full py-4 px-6 rounded-2xl text-base font-bold bg-slate-100 text-slate-500 border border-slate-200 cursor-not-allowed text-center">
                            Akun Ini Telah Terjual
                        </button>
                        <p class="text-center text-xs text-slate-500 mt-2">
                            Produk ini sudah dibeli oleh gamer lain. Silakan cek produk sejenis di bawah.
                        </p>
                    @endif
                </div>

                <!-- Feature checklist -->
                <div class="pt-4 border-t border-slate-100 space-y-2.5 text-xs text-slate-700">
                    <div class="flex items-center space-x-2.5">
                        <svg class="w-4 h-4 text-emerald-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                        </svg>
                        <span>Data akun otomatis tampil setelah bayar</span>
                    </div>
                    <div class="flex items-center space-x-2.5">
                        <svg class="w-4 h-4 text-emerald-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                        </svg>
                        <span>Garansi anti-hackback seumur hidup</span>
                    </div>
                    <div class="flex items-center space-x-2.5">
                        <svg class="w-4 h-4 text-emerald-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                        </svg>
                        <span>Didukung QRIS semua bank & e-wallet</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Description & Specs Section -->
    <div class="mt-14 p-8 rounded-3xl bg-white border border-slate-200 shadow-sm">
        <h2 class="text-xl font-bold text-slate-900 mb-4 pb-3 border-b border-slate-200">
            Deskripsi & Spesifikasi Lengkap Akun
        </h2>
        <div class="prose max-w-none text-slate-700 text-sm leading-relaxed">
            @if($product->description)
                {!! $product->description !!}
            @else
                <p class="text-slate-500">Tidak ada deskripsi tambahan untuk produk ini.</p>
            @endif
        </div>
    </div>

    <!-- Related Products -->
    @if($relatedProducts->isNotEmpty())
        <div class="mt-16">
            <h2 class="text-2xl font-extrabold text-slate-900 mb-6">Akun {{ $product->category->name }} Lainnya</h2>
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
                @foreach($relatedProducts as $related)
                    <div class="group bg-white rounded-2xl border border-slate-200 hover:border-indigo-300 shadow-xs hover:shadow-md transition-all duration-300 overflow-hidden flex flex-col">
                        <div class="relative h-44 bg-slate-100 overflow-hidden">
                            @if($related->thumbnail)
                                <img src="{{ asset('storage/' . $related->thumbnail) }}" alt="{{ $related->title }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300">
                            @else
                                <div class="w-full h-full flex items-center justify-center bg-slate-100 text-slate-400 text-xs">
                                    No Image
                                </div>
                            @endif
                        </div>
                        <div class="p-4 flex-1 flex flex-col justify-between space-y-3">
                            <h3 class="font-bold text-slate-900 text-sm line-clamp-2" title="{{ $related->title }}">
                                {{ $related->title }}
                            </h3>
                            <div class="flex items-center justify-between pt-2 border-t border-slate-100">
                                <span class="font-extrabold text-emerald-600 text-sm">{{ $related->formatted_price }}</span>
                                <a href="{{ route('products.show', $related->slug) }}" class="px-3 py-1.5 rounded-lg text-xs font-bold bg-indigo-600 text-white hover:bg-indigo-700">
                                    Beli
                                </a>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    @endif
</div>
@endsection
