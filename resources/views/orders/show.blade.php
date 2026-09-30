@extends('layouts.main')

@section('content')
<div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-10" x-data="orderTracker()">
    <!-- Top Header -->
    <div class="flex flex-col sm:flex-row sm:items-center justify-between pb-6 mb-8 border-b border-slate-200 gap-4">
        <div>
            <div class="flex items-center space-x-2">
                <span class="text-xs font-bold text-indigo-600 uppercase tracking-widest">Detail Pesanan</span>
                <span class="text-xs text-slate-400">•</span>
                <span class="text-xs text-slate-500 font-medium">{{ $order->created_at->format('d M Y, H:i') }} WIB</span>
            </div>
            <h1 class="text-2xl sm:text-3xl font-extrabold text-slate-900 mt-1 flex items-center space-x-3">
                <span>{{ $order->order_number }}</span>
                <button type="button" @click="navigator.clipboard.writeText('{{ $order->order_number }}'); copied = true; setTimeout(() => copied = false, 2000)" class="text-slate-600 hover:text-slate-900 text-xs px-2.5 py-1 rounded-lg bg-slate-100 border border-slate-200 font-medium transition">
                    <span x-show="!copied">Salin No. Order</span>
                    <span x-show="copied" x-cloak class="text-emerald-600 font-bold">Tersalin!</span>
                </button>
            </h1>
        </div>

        <!-- Status Badges -->
        <div class="flex items-center space-x-2">
            <!-- Payment Badge -->
            <span class="px-3.5 py-1.5 rounded-xl text-xs font-bold uppercase tracking-wider
                @if($order->payment_status === 'paid') bg-emerald-50 text-emerald-700 border border-emerald-200
                @elseif($order->payment_status === 'pending') bg-amber-50 text-amber-700 border border-amber-200 animate-pulse
                @else bg-rose-50 text-rose-700 border border-rose-200 @endif">
                Bayar: {{ strtoupper($order->payment_status) }}
            </span>

            <!-- Order Status Badge -->
            <span class="px-3.5 py-1.5 rounded-xl text-xs font-bold uppercase tracking-wider
                @if($order->order_status === 'completed') bg-emerald-50 text-emerald-700 border border-emerald-200
                @elseif($order->order_status === 'processing') bg-cyan-50 text-cyan-700 border border-cyan-200
                @elseif($order->order_status === 'pending') bg-amber-50 text-amber-700 border border-amber-200
                @else bg-slate-100 text-slate-600 border border-slate-200 @endif">
                Order: {{ ucfirst($order->order_status) }}
            </span>
        </div>
    </div>

    <!-- Alert Notifikasi Flash -->
    @if(session('success'))
        <div class="mb-6 p-4 rounded-2xl bg-emerald-50 border border-emerald-200 text-emerald-800 flex items-center space-x-3 text-sm">
            <svg class="w-5 h-5 text-emerald-600 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
            </svg>
            <span class="font-medium">{{ session('success') }}</span>
        </div>
    @endif

    @if(session('info'))
        <div class="mb-6 p-4 rounded-2xl bg-slate-100 border border-slate-200 text-slate-800 flex items-center space-x-3 text-sm">
            <svg class="w-5 h-5 text-slate-600 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
            </svg>
            <span class="font-medium">{{ session('info') }}</span>
        </div>
    @endif

    @if(session('error'))
        <div class="mb-6 p-4 rounded-2xl bg-rose-50 border border-rose-200 text-rose-800 flex items-center space-x-3 text-sm">
            <svg class="w-5 h-5 text-rose-600 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
            </svg>
            <span class="font-medium">{{ session('error') }}</span>
        </div>
    @endif

    <div class="grid grid-cols-1 lg:grid-cols-12 gap-8">
        <!-- Main Column -->
        <div class="lg:col-span-8 space-y-6">

            <!-- KOTAK QRIS BUATQRIS (TAMPIL DI WEBSITE - PILIHAN 1A) -->
            @if($order->payment_status === 'pending')
                <div class="p-6 sm:p-8 rounded-3xl bg-white border border-slate-200 shadow-sm space-y-6">
                    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3 pb-4 border-b border-slate-100">
                        <div class="flex items-center space-x-3">
                            <div class="w-10 h-10 rounded-xl bg-indigo-50 border border-indigo-100 flex items-center justify-center text-indigo-600 font-extrabold text-sm">
                                QRIS
                            </div>
                            <div>
                                <h2 class="text-base font-extrabold text-slate-900">Scan QRIS untuk Bayar</h2>
                                <p class="text-xs text-slate-500">Mendukung semua bank dan e-wallet di Indonesia</p>
                            </div>
                        </div>

                        <!-- Timer Hitung Mundur -->
                        <div class="inline-flex items-center space-x-2 px-3 py-1.5 rounded-xl bg-amber-50 border border-amber-200 text-amber-800 text-xs font-bold self-start sm:self-auto">
                            <svg class="w-4 h-4 text-amber-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            <span>Sisa Waktu: <span x-text="formatTime(timeLeft)">15:00</span></span>
                        </div>
                    </div>

                    <!-- Area Barcode QRIS -->
                    <div class="flex flex-col items-center justify-center py-4 bg-slate-50/70 rounded-2xl border border-slate-100 p-6 text-center space-y-4">
                        <div class="relative bg-white p-3 rounded-2xl border-2 border-slate-200 shadow-xs">
                            @php
                                $displayQrUrl = !empty($order->qris_image) 
                                    ? $order->qris_image 
                                    : (!empty($order->qris_url) 
                                        ? $order->qris_url 
                                        : 'https://api.qrserver.com/v1/create-qr-code/?size=350x350&margin=10&data=' . urlencode('https://buatqris.site/trx/' . ($order->qris_transaction_id ?? $order->order_number)));
                            @endphp
                            <img src="{{ $displayQrUrl }}" alt="QRIS {{ $order->order_number }}" class="w-60 h-60 object-contain mx-auto rounded-lg">
                        </div>

                        <div>
                            <span class="text-xs text-slate-500 font-medium block">Total Pembayaran Pas:</span>
                            <span class="text-2xl font-black text-indigo-600">{{ $order->formatted_total }}</span>
                            <span class="text-[11px] text-slate-400 block mt-0.5">Nama Merchant: {{ config('buatqris.umkm_name', 'ANDRA JB') }}</span>
                        </div>

                        <!-- Logo E-Wallet & Bank Pendukung -->
                        <div class="pt-2 flex flex-wrap justify-center items-center gap-2 max-w-sm text-[11px] font-bold text-slate-600">
                            <span class="px-2.5 py-1 rounded-md bg-white border border-slate-200">BCA</span>
                            <span class="px-2.5 py-1 rounded-md bg-white border border-slate-200">Mandiri</span>
                            <span class="px-2.5 py-1 rounded-md bg-white border border-slate-200">BRI</span>
                            <span class="px-2.5 py-1 rounded-md bg-white border border-slate-200">GoPay</span>
                            <span class="px-2.5 py-1 rounded-md bg-white border border-slate-200">DANA</span>
                            <span class="px-2.5 py-1 rounded-md bg-white border border-slate-200">OVO</span>
                            <span class="px-2.5 py-1 rounded-md bg-white border border-slate-200">ShopeePay</span>
                        </div>
                    </div>

                    <!-- Status Pengecekan Otomatis Realtime -->
                    <div class="flex items-center justify-between p-4 rounded-2xl bg-indigo-50/60 border border-indigo-100 text-xs">
                        <div class="flex items-center space-x-3">
                            <div class="w-3 h-3 rounded-full bg-indigo-600 animate-ping"></div>
                            <span class="font-semibold text-slate-700">Mendeteksi pembayaran Anda secara otomatis...</span>
                        </div>
                        <button type="button" @click="checkManualStatus()" class="font-bold text-indigo-600 hover:text-indigo-800 underline">
                            Cek Sekarang
                        </button>
                    </div>

                    <!-- Tombol Batalkan Pesanan (Saat Status Masih Pending) -->
                    <div class="pt-3 border-t border-slate-100 flex flex-col sm:flex-row sm:items-center justify-between gap-2" x-data="{ confirmingCancel: false }">
                        <span class="text-xs text-slate-500">
                            Ingin membatalkan pesanan ini?
                        </span>
                        
                        <div>
                            <!-- Tombol Pemicu -->
                            <button type="button" 
                                    x-show="!confirmingCancel" 
                                    @click="confirmingCancel = true" 
                                    class="text-xs font-bold text-rose-600 hover:text-rose-700 hover:underline inline-flex items-center space-x-1.5 transition">
                                <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                </svg>
                                <span>Batalkan Pesanan</span>
                            </button>

                            <!-- Konfirmasi Inline -->
                            <div x-show="confirmingCancel" x-cloak class="flex items-center space-x-2">
                                <span class="text-xs font-bold text-rose-700">Yakin batalkan?</span>
                                
                                <form method="POST" action="{{ route('orders.cancel', $order->order_number) }}">
                                    @csrf
                                    <button type="submit" class="px-3 py-1 rounded-lg text-xs font-black bg-rose-600 hover:bg-rose-700 text-white transition shadow-xs">
                                        Ya, Batalkan
                                    </button>
                                </form>

                                <button type="button" 
                                        @click="confirmingCancel = false" 
                                        class="px-2.5 py-1 rounded-lg text-xs font-semibold bg-slate-100 hover:bg-slate-200 text-slate-600 transition">
                                    Kembali
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            @endif

            <!-- KOTAK PESANAN DIBATALKAN -->
            @if($order->order_status === 'cancelled')
                <div class="p-6 sm:p-8 rounded-3xl bg-white border border-rose-200 shadow-xs text-center space-y-4">
                    <div class="w-14 h-14 rounded-2xl bg-rose-50 border border-rose-100 flex items-center justify-center text-rose-600 mx-auto">
                        <svg class="w-7 h-7" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </div>
                    <div class="max-w-md mx-auto space-y-1">
                        <h3 class="text-lg font-black text-slate-900">Pesanan Telah Dibatalkan</h3>
                        <p class="text-xs text-slate-500 leading-relaxed">
                            Pembayaran untuk transaksi ini telah dibatalkan. Barcode QRIS sudah dinonaktifkan dan akun game telah dikembalikan ke etalase toko.
                        </p>
                    </div>
                    <div class="pt-2">
                        <a href="{{ route('products.index') }}" class="inline-flex items-center px-6 py-2.5 rounded-xl text-xs font-bold bg-slate-950 hover:bg-slate-800 text-white shadow-xs transition">
                            Cari Akun Lain di Katalog
                        </a>
                    </div>
                </div>
            @endif

            <!-- DATA AKUN GAME (CRITICAL SECTION) -->
            <div class="p-6 sm:p-8 rounded-3xl @if($order->isPaid()) bg-emerald-50/40 border-2 border-emerald-300 @else bg-white border border-slate-200 @endif shadow-xs">
                <div class="flex items-center justify-between pb-4 mb-5 border-b @if($order->isPaid()) border-emerald-200 @else border-slate-100 @endif">
                    <div class="flex items-center space-x-3">
                        <div class="w-10 h-10 rounded-xl @if($order->isPaid()) bg-emerald-100 text-emerald-700 border border-emerald-200 @else bg-slate-100 text-slate-500 @endif flex items-center justify-center">
                            @if($order->isPaid())
                                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 11V7a4 4 0 118 0m-4 8v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2z" />
                                </svg>
                            @else
                                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                                </svg>
                            @endif
                        </div>
                        <div>
                            <h3 class="text-base font-bold @if($order->isPaid()) text-emerald-900 @else text-slate-900 @endif">
                                Data Kredensial Akun Game
                            </h3>
                            <p class="text-xs @if($order->isPaid()) text-emerald-700 @else text-slate-500 @endif">
                                @if($order->isPaid())
                                    Pembayaran terverifikasi! Simpan data akun di bawah ini dengan aman.
                                @else
                                    Kredensial terkunci. Selesaikan pembayaran QRIS agar akun otomatis terbuka.
                                @endif
                            </p>
                        </div>
                    </div>
                </div>

                @if($order->isPaid() && $accountDetails)
                    <!-- Unlocked Credentials Box -->
                    <div class="space-y-4" x-data="{ showPass: false, userCopied: false, passCopied: false }">
                        <!-- Login Method -->
                        <div class="p-3.5 rounded-xl bg-white border border-emerald-200 flex items-center justify-between text-xs">
                            <span class="text-slate-600 font-medium">Metode Login:</span>
                            <span class="font-bold text-slate-900 bg-slate-100 px-2.5 py-1 rounded-md">{{ $order->product->login_method ?? 'Moonton / Akun Game' }}</span>
                        </div>

                        <!-- Username / ID / Email -->
                        <div class="p-4 rounded-2xl bg-white border border-emerald-200">
                            <div class="text-xs font-bold text-slate-500 uppercase tracking-wider mb-1">
                                Username / ID / Email Login:
                            </div>
                            <div class="flex items-center justify-between">
                                <span class="font-mono text-base font-bold text-slate-900 select-all">
                                    {{ $accountDetails['username'] ?? 'Tersedia setelah verifikasi' }}
                                </span>
                                @if(!empty($accountDetails['username']))
                                    <button type="button" @click="navigator.clipboard.writeText('{{ $accountDetails['username'] }}'); userCopied = true; setTimeout(() => userCopied = false, 2000)" class="text-xs px-3 py-1.5 rounded-lg bg-slate-100 hover:bg-slate-200 text-slate-800 font-semibold transition">
                                        <span x-show="!userCopied">Salin</span>
                                        <span x-show="userCopied" x-cloak class="text-emerald-600 font-bold">Tersalin!</span>
                                    </button>
                                @endif
                            </div>
                        </div>

                        <!-- Password -->
                        <div class="p-4 rounded-2xl bg-white border border-emerald-200">
                            <div class="text-xs font-bold text-slate-500 uppercase tracking-wider mb-1">
                                Password Akun:
                            </div>
                            <div class="flex items-center justify-between">
                                <span class="font-mono text-base font-bold text-emerald-700 select-all" x-text="showPass ? '{{ $accountDetails['password'] }}' : '••••••••••••'">
                                    ••••••••••••
                                </span>
                                <div class="flex items-center space-x-2">
                                    <button type="button" @click="showPass = !showPass" class="text-xs px-3 py-1.5 rounded-lg bg-slate-100 hover:bg-slate-200 text-slate-700 font-semibold transition">
                                        <span x-text="showPass ? 'Sembunyikan' : 'Lihat'">Lihat</span>
                                    </button>
                                    @if(!empty($accountDetails['password']))
                                        <button type="button" @click="navigator.clipboard.writeText('{{ $accountDetails['password'] }}'); passCopied = true; setTimeout(() => passCopied = false, 2000)" class="text-xs px-3 py-1.5 rounded-lg bg-slate-100 hover:bg-slate-200 text-slate-800 font-semibold transition">
                                            <span x-show="!passCopied">Salin</span>
                                            <span x-show="passCopied" x-cloak class="text-emerald-600 font-bold">Tersalin!</span>
                                        </button>
                                    @endif
                                </div>
                            </div>
                        </div>

                        @if(!empty($accountDetails['additional_info']))
                            <div class="p-4 rounded-2xl bg-white border border-emerald-200 text-xs text-slate-700 space-y-1">
                                <div class="font-bold text-slate-900">Catatan Pengamanan Akun:</div>
                                <p class="leading-relaxed">{{ $accountDetails['additional_info'] }}</p>
                            </div>
                        @endif

                        <div class="p-3.5 rounded-xl bg-amber-50 border border-amber-200 text-amber-800 text-xs leading-relaxed">
                            💡 <strong>Penting:</strong> Segera lakukan pergantian kata sandi (password) dan ubah email/nomor pemulihan yang terikat di akun game ini agar akun menjadi 100% milik Anda secara aman.
                        </div>
                    </div>
                @else
                    <!-- Locked Credentials Placeholder -->
                    <div class="p-6 rounded-2xl bg-slate-50 border border-slate-200 text-center space-y-3">
                        <div class="w-12 h-12 rounded-full bg-slate-200 text-slate-500 mx-auto flex items-center justify-center">
                            <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                            </svg>
                        </div>
                        <div class="max-w-md mx-auto">
                            <h4 class="text-sm font-bold text-slate-800">Kredensial Terenkripsi & Terkunci</h4>
                            <p class="text-xs text-slate-500 mt-1">
                                Username, password, dan informasi login akun game ini akan otomatis ditampilkan di sini seketika setelah pembayaran QRIS Anda sukses terkonfirmasi.
                            </p>
                        </div>
                    </div>
                @endif
            </div>

            <!-- Produk yang Dibeli -->
            <div class="p-6 rounded-3xl bg-white border border-slate-200 shadow-xs space-y-4">
                <h3 class="text-xs font-bold text-slate-500 uppercase tracking-wider">Produk Akun</h3>
                <div class="flex items-center space-x-4">
                    <div class="w-20 h-20 rounded-2xl bg-slate-100 border border-slate-200 overflow-hidden shrink-0">
                        @if($order->product->thumbnail)
                            <img src="{{ asset('storage/' . $order->product->thumbnail) }}" alt="{{ $order->product->title }}" class="w-full h-full object-cover">
                        @else
                            <div class="w-full h-full flex items-center justify-center text-slate-400 font-bold text-xs">Foto</div>
                        @endif
                    </div>
                    <div class="flex-1 min-w-0">
                        <span class="text-xs font-bold text-indigo-600">{{ $order->product->category->name }}</span>
                        <h4 class="font-bold text-slate-900 text-base truncate">{{ $order->product->title }}</h4>
                        <span class="text-sm font-extrabold text-indigo-600 block mt-1">{{ $order->formatted_total }}</span>
                    </div>
                    <div>
                        <a href="{{ route('products.show', $order->product->slug) }}" class="px-3.5 py-1.5 rounded-xl text-xs font-semibold bg-slate-100 hover:bg-slate-200 text-slate-800 transition">
                            Lihat Etalase
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Sidebar Column: Payment & Action -->
        <div class="lg:col-span-4 space-y-6">
            <!-- Payment Action Box -->
            <div class="p-6 rounded-3xl bg-white border border-slate-200 shadow-xs space-y-5">
                <h3 class="text-base font-bold text-slate-900">Rincian Pesanan</h3>

                <div class="space-y-2.5 text-xs">
                    <div class="flex justify-between text-slate-600">
                        <span>Total Tagihan</span>
                        <span class="font-bold text-indigo-600 text-sm">{{ $order->formatted_total }}</span>
                    </div>
                    <div class="flex justify-between text-slate-600">
                        <span>Status Pembayaran</span>
                        <span class="font-bold uppercase @if($order->isPaid()) text-emerald-600 @else text-amber-600 @endif">{{ $order->payment_status }}</span>
                    </div>
                    <div class="flex justify-between text-slate-600">
                        <span>Metode</span>
                        <span class="font-semibold text-slate-800">QRIS Dinamis</span>
                    </div>
                    <div class="flex justify-between text-slate-600">
                        <span>Provider</span>
                        <span class="font-semibold text-slate-800">BuatQris</span>
                    </div>
                    @if($order->paid_at)
                        <div class="flex justify-between text-slate-600">
                            <span>Waktu Lunas</span>
                            <span class="font-semibold text-slate-800">{{ $order->paid_at->format('d/m/Y H:i') }} WIB</span>
                        </div>
                    @endif
                </div>

                @if($order->payment_status === 'pending')
                    <div class="pt-3 border-t border-slate-100 space-y-2">
                        <button type="button" @click="checkManualStatus()" class="w-full py-3 px-4 rounded-xl text-xs font-bold bg-indigo-600 hover:bg-indigo-700 text-white shadow-xs transition text-center">
                            🔄 Cek Status Sekarang
                        </button>
                    </div>
                @else
                    <div class="p-3.5 rounded-2xl bg-emerald-50 border border-emerald-200 text-emerald-700 text-xs text-center font-bold">
                        ✓ Transaksi Berhasil & Selesai
                    </div>
                @endif
            </div>

            <!-- Customer Service Assistance -->
            <div class="p-6 rounded-3xl bg-white border border-slate-200 shadow-xs space-y-3 text-center">
                <h4 class="text-sm font-bold text-slate-900">Butuh Bantuan Akun?</h4>
                <p class="text-xs text-slate-500 leading-relaxed">
                    Jika ada kendala pembayaran, verifikasi email, atau pertanyaan lainnya, hubungi layanan admin kami melalui WhatsApp.
                </p>
                <a href="https://wa.me/6281234567890?text={{ urlencode('Halo Admin ANDRA JB, saya butuh bantuan untuk pesanan nomor ' . $order->order_number) }}" target="_blank" class="inline-flex items-center justify-center space-x-2 w-full py-2.5 px-4 rounded-xl text-xs font-bold bg-emerald-50 hover:bg-emerald-100 text-emerald-700 border border-emerald-200 transition">
                    <span>Chat WhatsApp Admin</span>
                </a>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
function orderTracker() {
    return {
        copied: false,
        isPending: {{ $order->payment_status === 'pending' ? 'true' : 'false' }},
        timeLeft: 900, // 15 menit dalam detik

        init() {
            if (this.isPending) {
                // Countdown timer
                setInterval(() => {
                    if (this.timeLeft > 0) {
                        this.timeLeft--;
                    }
                }, 1000);

                // Auto-polling status pembayaran setiap 4 detik
                setInterval(() => {
                    this.pollStatus();
                }, 4000);
            }
        },

        formatTime(seconds) {
            const m = Math.floor(seconds / 60);
            const s = seconds % 60;
            return `${m.toString().padStart(2, '0')}:${s.toString().padStart(2, '0')}`;
        },

        pollStatus() {
            if (!this.isPending) return;

            fetch('{{ route('orders.status', $order->order_number) }}')
                .then(res => res.json())
                .then(data => {
                    if (data.is_paid || data.order_status === 'cancelled') {
                        this.isPending = false;
                        window.location.reload();
                    }
                })
                .catch(() => {});
        },

        checkManualStatus() {
            fetch('{{ route('orders.status', $order->order_number) }}')
                .then(res => res.json())
                .then(data => {
                    if (data.is_paid) {
                        window.location.reload();
                    } else {
                        alert('Pembayaran belum terdeteksi. Silakan selesaikan pembayaran di aplikasi m-banking / e-wallet Anda.');
                    }
                })
                .catch(() => {
                    alert('Gagal mengecek status. Silakan muat ulang halaman.');
                });
        }
    }
}
</script>
@endpush
