@extends('layouts.main')

@section('content')
<div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-10">
    <div class="mb-8 text-center sm:text-left">
        <h1 class="text-3xl font-extrabold text-slate-900 tracking-tight">Checkout Pesanan</h1>
        <p class="text-slate-500 text-sm mt-1">Lengkapi data pembeli untuk verifikasi kepemilikan akun game Anda.</p>
    </div>

    <form action="{{ route('checkout.process', $product->slug) }}" method="POST">
        @csrf
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-8">
            <!-- Left Column: Form Pembeli -->
            <div class="lg:col-span-7 space-y-6">
                <div class="p-6 sm:p-8 rounded-3xl bg-white border border-slate-200 shadow-xs space-y-5">
                    <h2 class="text-lg font-bold text-slate-900 flex items-center space-x-2">
                        <span class="w-6 h-6 rounded-full bg-indigo-600 flex items-center justify-center text-xs font-bold text-white">1</span>
                        <span>Informasi Kontak Pembeli</span>
                    </h2>

                    <!-- Nama Pembeli -->
                    <div>
                        <label for="buyer_name" class="block text-xs font-bold text-slate-700 mb-1.5">
                            Nama Lengkap <span class="text-rose-500">*</span>
                        </label>
                        <input type="text" id="buyer_name" name="buyer_name" value="{{ old('buyer_name', $user->name) }}" required class="w-full bg-slate-50 border @error('buyer_name') border-rose-500 @else border-slate-200 @enderror rounded-xl px-4 py-3 text-sm text-slate-800 placeholder-slate-400 focus:bg-white focus:outline-none focus:border-indigo-500 transition">
                        @error('buyer_name')
                            <p class="text-xs text-rose-500 mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Email Pembeli -->
                    <div>
                        <label for="buyer_email" class="block text-xs font-bold text-slate-700 mb-1.5">
                            Alamat Email Aktif <span class="text-rose-500">*</span>
                        </label>
                        <input type="email" id="buyer_email" name="buyer_email" value="{{ old('buyer_email', $user->email) }}" required class="w-full bg-slate-50 border @error('buyer_email') border-rose-500 @else border-slate-200 @enderror rounded-xl px-4 py-3 text-sm text-slate-800 placeholder-slate-400 focus:bg-white focus:outline-none focus:border-indigo-500 transition">
                        <span class="text-[11px] text-slate-500 mt-1 block">Bukti transaksi dan invoice otomatis dikirimkan ke email ini.</span>
                        @error('buyer_email')
                            <p class="text-xs text-rose-500 mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- No WhatsApp -->
                    <div>
                        <label for="buyer_phone" class="block text-xs font-bold text-slate-700 mb-1.5">
                            Nomor WhatsApp <span class="text-rose-500">*</span>
                        </label>
                        <input type="tel" id="buyer_phone" name="buyer_phone" value="{{ old('buyer_phone', $user->phone) }}" placeholder="Contoh: 08123456789" required class="w-full bg-slate-50 border @error('buyer_phone') border-rose-500 @else border-slate-200 @enderror rounded-xl px-4 py-3 text-sm text-slate-800 placeholder-slate-400 focus:bg-white focus:outline-none focus:border-indigo-500 transition">
                        <span class="text-[11px] text-slate-500 mt-1 block">Wajib aktif untuk koordinasi pengamanan email atau OTP bind akun.</span>
                        @error('buyer_phone')
                            <p class="text-xs text-rose-500 mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Catatan Tambahan -->
                    <div>
                        <label for="notes" class="block text-xs font-bold text-slate-700 mb-1.5">
                            Catatan Tambahan (Opsional)
                        </label>
                        <textarea id="notes" name="notes" rows="2" placeholder="Catatan khusus untuk penjual..." class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-2.5 text-sm text-slate-800 placeholder-slate-400 focus:bg-white focus:outline-none focus:border-indigo-500 transition">{{ old('notes') }}</textarea>
                    </div>
                </div>
            </div>

            <!-- Right Column: Ringkasan Produk & Bayar -->
            <div class="lg:col-span-5 space-y-6">
                <div class="p-6 sm:p-8 rounded-3xl bg-white border border-slate-200 shadow-xs space-y-6">
                    <h2 class="text-lg font-bold text-slate-900 flex items-center space-x-2">
                        <span class="w-6 h-6 rounded-full bg-indigo-600 flex items-center justify-center text-xs font-bold text-white">2</span>
                        <span>Ringkasan Pembelian</span>
                    </h2>

                    <!-- Item Box -->
                    <div class="flex items-center space-x-4 p-3.5 rounded-2xl bg-slate-50 border border-slate-200">
                        <div class="w-16 h-16 rounded-xl bg-slate-200 overflow-hidden shrink-0">
                            @if($product->thumbnail)
                                <img src="{{ asset('storage/' . $product->thumbnail) }}" alt="{{ $product->title }}" class="w-full h-full object-cover">
                            @else
                                <div class="w-full h-full flex items-center justify-center text-slate-400 text-xs font-bold">Foto</div>
                            @endif
                        </div>
                        <div class="flex-1 min-w-0">
                            <span class="text-[10px] font-bold text-indigo-600 uppercase tracking-wider block">{{ $product->category->name }}</span>
                            <h3 class="font-bold text-slate-900 text-sm truncate" title="{{ $product->title }}">{{ $product->title }}</h3>
                            <span class="text-xs font-extrabold text-indigo-600 mt-0.5 block">{{ $product->formatted_price }}</span>
                        </div>
                    </div>

                    <!-- Breakdown Price -->
                    <div class="space-y-2.5 pt-3 border-t border-slate-100 text-xs">
                        <div class="flex items-center justify-between text-slate-600">
                            <span>Harga Akun</span>
                            <span class="font-bold text-slate-900">{{ $product->formatted_price }}</span>
                        </div>
                        <div class="flex items-center justify-between text-slate-600">
                            <span>Biaya Layanan & Rekber</span>
                            <span class="font-bold text-emerald-600">GRATIS (Rp 0)</span>
                        </div>
                        <div class="flex items-center justify-between text-slate-600">
                            <span>Metode Pembayaran</span>
                            <span class="font-bold text-indigo-600">QRIS / Midtrans</span>
                        </div>
                        <div class="pt-3 border-t border-slate-100 flex items-center justify-between text-sm">
                            <span class="font-bold text-slate-900">Total Pembayaran</span>
                            <span class="text-xl font-extrabold text-indigo-600">{{ $product->formatted_price }}</span>
                        </div>
                    </div>

                    <!-- Tombol Bayar Sekarang -->
                    <button type="submit" class="w-full flex items-center justify-center space-x-2 py-4 px-6 rounded-2xl text-base font-extrabold bg-indigo-600 hover:bg-indigo-700 text-white shadow-md shadow-indigo-600/20 hover:shadow-lg hover:shadow-indigo-600/30 transition transform hover:-translate-y-0.5">
                        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z" />
                        </svg>
                        <span>Bayar Sekarang (QRIS)</span>
                    </button>

                    <p class="text-[11px] text-center text-slate-500">
                        Dengan melanjutkan pembayaran, Anda menyetujui syarat & ketentuan garansi akun JB GAME.
                    </p>
                </div>
            </div>
        </div>
    </form>
</div>
@endsection
