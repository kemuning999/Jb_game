@extends('layouts.main')

@section('content')
<div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-10 bg-white" x-data="orderTracker()">
    <!-- Top Header -->
    <div class="flex flex-col sm:flex-row sm:items-center justify-between pb-6 mb-8 border-b border-slate-200 gap-4">
        <div>
            <div class="flex items-center space-x-2">
                <span class="text-xs font-bold text-indigo-600 uppercase tracking-widest">Detail Pesanan</span>
                <span class="text-xs text-slate-400">•</span>
                <span class="text-xs text-slate-500">{{ $order->created_at->format('d M Y, H:i') }} WIB</span>
            </div>
            <h1 class="text-2xl sm:text-3xl font-extrabold text-slate-900 mt-1 flex items-center space-x-3">
                <span>{{ $order->order_number }}</span>
                <button type="button" @click="navigator.clipboard.writeText('{{ $order->order_number }}'); copied = true; setTimeout(() => copied = false, 2000)" class="text-slate-600 hover:text-slate-900 text-xs px-2.5 py-1 rounded-lg bg-slate-100 hover:bg-slate-200 border border-slate-200 font-medium transition">
                    <span x-show="!copied">Salin No. Order</span>
                    <span x-show="copied" x-cloak class="text-emerald-600 font-semibold">Tersalin!</span>
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

    <div class="grid grid-cols-1 lg:grid-cols-12 gap-8">
        <!-- Main Column -->
        <div class="lg:col-span-8 space-y-6">
            <!-- DATA AKUN GAME (CRITICAL SECTION) -->
            <div class="p-6 sm:p-8 rounded-3xl @if($order->isPaid()) bg-emerald-50/50 border border-emerald-200 @else bg-white border border-slate-200 @endif shadow-sm">
                <div class="flex items-center justify-between pb-4 mb-5 border-b @if($order->isPaid()) border-emerald-200/80 @else border-slate-200 @endif">
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
                            <h2 class="text-lg font-bold text-slate-900">Data Kredensial Akun Game</h2>
                            <p class="text-xs text-slate-500">
                                @if($order->isPaid())
                                    Pembayaran Lunas! Data login akun game Anda telah dibuka di bawah ini:
                                @else
                                    Kredensial terkunci sampai pembayaran QRIS diverifikasi oleh sistem.
                                @endif
                            </p>
                        </div>
                    </div>
                </div>

                @if($order->isPaid() && $accountDetails)
                    <!-- UNLOCKED CREDENTIALS -->
                    <div class="space-y-4" x-data="{ showPass: false, userCopied: false, passCopied: false }">
                        <!-- Username / ID -->
                        <div class="p-4 rounded-2xl bg-white border border-emerald-200 shadow-2xs">
                            <label class="block text-xs font-semibold text-slate-500 uppercase tracking-wider mb-1">
                                Username / ID / Email Login:
                            </label>
                            <div class="flex items-center justify-between">
                                <span class="font-mono text-base font-bold text-emerald-700 select-all">
                                    {{ $accountDetails['username'] ?? 'Hubungi CS / Admin' }}
                                </span>
                                @if(!empty($accountDetails['username']))
                                    <button type="button" @click="navigator.clipboard.writeText('{{ $accountDetails['username'] }}'); userCopied = true; setTimeout(() => userCopied = false, 2000)" class="text-xs px-3 py-1.5 rounded-lg bg-slate-100 hover:bg-slate-200 text-slate-700 transition">
                                        <span x-show="!userCopied">Salin</span>
                                        <span x-show="userCopied" x-cloak class="text-emerald-600 font-bold">Tersalin!</span>
                                    </button>
                                @endif
                            </div>
                        </div>

                        <!-- Password -->
                        <div class="p-4 rounded-2xl bg-white border border-emerald-200 shadow-2xs">
                            <label class="block text-xs font-semibold text-slate-500 uppercase tracking-wider mb-1">
                                Password Akun:
                            </label>
                            <div class="flex items-center justify-between">
                                <span class="font-mono text-base font-bold text-emerald-700 select-all" x-text="showPass ? '{{ $accountDetails['password'] }}' : '••••••••••••'">
                                </span>
                                <div class="flex items-center space-x-2">
                                    <button type="button" @click="showPass = !showPass" class="text-xs px-3 py-1.5 rounded-lg bg-slate-100 hover:bg-slate-200 text-slate-700 transition">
                                        <span x-text="showPass ? 'Sembunyikan' : 'Tampilkan'"></span>
                                    </button>
                                    @if(!empty($accountDetails['password']))
                                        <button type="button" @click="navigator.clipboard.writeText('{{ $accountDetails['password'] }}'); passCopied = true; setTimeout(() => passCopied = false, 2000)" class="text-xs px-3 py-1.5 rounded-lg bg-slate-100 hover:bg-slate-200 text-slate-700 transition">
                                            <span x-show="!passCopied">Salin</span>
                                            <span x-show="passCopied" x-cloak class="text-emerald-600 font-bold">Tersalin!</span>
                                        </button>
                                    @endif
                                </div>
                            </div>
                        </div>

                        <!-- Additional Instructions -->
                        @if(!empty($accountDetails['additional_info']))
                            <div class="p-4 rounded-2xl bg-white border border-indigo-200 shadow-2xs">
                                <span class="block text-xs font-bold text-indigo-700 uppercase tracking-wider mb-1.5">
                                    Panduan Bind & Info Pemulihan:
                                </span>
                                <p class="text-xs text-slate-700 whitespace-pre-line leading-relaxed">
                                    {{ $accountDetails['additional_info'] }}
                                </p>
                            </div>
                        @endif

                        <div class="p-3.5 rounded-xl bg-amber-50 border border-amber-200 text-xs text-amber-800 flex items-start space-x-2">
                            <svg class="w-4 h-4 text-amber-600 shrink-0 mt-0.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            <span><strong>Penting:</strong> Segera login ke dalam game dan ganti kata sandi serta kaitkan nomor HP atau email pribadi Anda demi keamanan maksimal.</span>
                        </div>
                    </div>
                @else
                    <!-- LOCKED CREDENTIALS STATE -->
                    <div class="space-y-4 filter blur-[2px] select-none pointer-events-none opacity-50">
                        <div class="p-4 rounded-2xl bg-slate-50 border border-slate-200">
                            <div class="text-xs font-semibold text-slate-500 uppercase tracking-wider mb-1">Username:</div>
                            <div class="font-mono text-base font-bold text-slate-400">Tersembunyi (example123)</div>
                        </div>
                        <div class="p-4 rounded-2xl bg-slate-50 border border-slate-200">
                            <div class="text-xs font-semibold text-slate-500 uppercase tracking-wider mb-1">Password:</div>
                            <div class="font-mono text-base font-bold text-slate-400">••••••••••••</div>
                        </div>
                    </div>

                    <div class="mt-4 p-4 rounded-2xl bg-amber-50 border border-amber-200 text-amber-800 text-xs flex items-center space-x-3">
                        <svg class="w-5 h-5 text-amber-600 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                        </svg>
                        <span>Selesaikan pembayaran QRIS di bawah ini agar sistem otomatis membuka data akun di atas.</span>
                    </div>
                @endif
            </div>

            <!-- Produk yang Dibeli -->
            <div class="p-6 rounded-3xl bg-white border border-slate-200 shadow-sm space-y-4">
                <h3 class="text-sm font-bold text-slate-900 uppercase tracking-wider">Produk Akun</h3>
                <div class="flex items-center space-x-4">
                    <div class="w-20 h-20 rounded-2xl bg-slate-100 overflow-hidden shrink-0">
                        @if($order->product->thumbnail)
                            <img src="{{ asset('storage/' . $order->product->thumbnail) }}" alt="{{ $order->product->title }}" class="w-full h-full object-cover">
                        @else
                            <div class="w-full h-full flex items-center justify-center text-slate-400 text-xs">Foto</div>
                        @endif
                    </div>
                    <div class="flex-1 min-w-0">
                        <span class="text-xs font-bold text-indigo-600">{{ $order->product->category->name }}</span>
                        <h4 class="font-bold text-slate-900 text-base truncate">{{ $order->product->title }}</h4>
                        <span class="text-sm font-extrabold text-emerald-600 block mt-1">{{ $order->formatted_total }}</span>
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
            <div class="p-6 rounded-3xl bg-white border border-slate-200 shadow-sm space-y-5">
                <h3 class="text-base font-bold text-slate-900">Rincian Pembayaran</h3>

                <div class="space-y-2 text-xs">
                    <div class="flex justify-between text-slate-600">
                        <span>Total Tagihan</span>
                        <span class="font-bold text-emerald-600 text-sm">{{ $order->formatted_total }}</span>
                    </div>
                    <div class="flex justify-between text-slate-600">
                        <span>Status Bayar</span>
                        <span class="font-bold uppercase text-slate-900">{{ $order->payment_status }}</span>
                    </div>
                    <div class="flex justify-between text-slate-600">
                        <span>Metode</span>
                        <span class="font-medium text-slate-800">{{ strtoupper($order->payment_type ?? 'QRIS / Midtrans') }}</span>
                    </div>
                    @if($order->paid_at)
                        <div class="flex justify-between text-slate-600">
                            <span>Waktu Lunas</span>
                            <span class="font-medium text-slate-800">{{ $order->paid_at->format('d/m/Y H:i') }}</span>
                        </div>
                    @endif
                </div>

                @if($order->payment_status === 'pending')
                    <div class="pt-3 border-t border-slate-100 space-y-3">
                        <button type="button" @click="payWithSnap()" class="w-full flex items-center justify-center space-x-2 py-3.5 px-4 rounded-2xl text-sm font-extrabold bg-emerald-600 hover:bg-emerald-700 text-white shadow-md shadow-emerald-600/20 transition transform hover:-translate-y-0.5">
                            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v1m6 11h2m-6 0h-2v4m0-11v3m0 0h.01M12 12h4.01M16 20h4M4 12h4m12 0h.01M5 8h2a1 1 0 001-1V5a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1zm12 0h2a1 1 0 001-1V5a1 1 0 00-1-1h-2a1 1 0 00-1 1v2a1 1 0 001 1zM5 20h2a1 1 0 001-1v-2a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1z" />
                            </svg>
                            <span>Bayar Sekarang (QRIS)</span>
                        </button>

                        <button type="button" @click="window.location.reload()" class="w-full py-2.5 px-4 rounded-xl text-xs font-semibold bg-slate-100 hover:bg-slate-200 text-slate-700 transition text-center">
                            🔄 Cek Status Pembayaran
                        </button>
                    </div>
                @else
                    <div class="p-3.5 rounded-2xl bg-emerald-50 border border-emerald-200 text-emerald-800 text-xs text-center font-bold">
                        ✓ Transaksi Berhasil & Selesai
                    </div>
                @endif
            </div>

            <!-- Customer Service Assistance -->
            <div class="p-6 rounded-3xl bg-white border border-slate-200 shadow-sm space-y-3 text-center">
                <h4 class="text-sm font-bold text-slate-900">Butuh Bantuan Akun?</h4>
                <p class="text-xs text-slate-600 leading-relaxed">
                    Jika ada kendala verifikasi email, kode OTP, atau pertanyaan lainnya, hubungi layanan admin kami via WhatsApp.
                </p>
                <a href="https://wa.me/6281234567890?text={{ urlencode('Halo Admin JB GAME, saya butuh bantuan untuk pesanan nomor ' . $order->order_number) }}" target="_blank" class="inline-flex items-center justify-center space-x-2 w-full py-2.5 px-4 rounded-xl text-xs font-bold bg-emerald-50 hover:bg-emerald-100 text-emerald-700 border border-emerald-200 transition">
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
        snapToken: '{{ $order->snap_token }}',
        isPending: {{ $order->payment_status === 'pending' ? 'true' : 'false' }},

        init() {
            if (this.isPending && this.snapToken && !this.snapToken.startsWith('mock_')) {
                const urlParams = new URLSearchParams(window.location.search);
                if (urlParams.get('pay') === '1') {
                    this.payWithSnap();
                }
            }

            if (this.isPending) {
                setInterval(() => {
                    fetch('{{ route('orders.status', $order->order_number) }}')
                        .then(res => res.json())
                        .then(data => {
                            if (data.is_paid) {
                                window.location.reload();
                            }
                        })
                        .catch(() => {});
                }, 5000);
            }
        },

        payWithSnap() {
            if (!this.snapToken) {
                alert('Token pembayaran belum tersedia. Silakan hubungi admin atau refresh halaman.');
                return;
            }

            if (this.snapToken.startsWith('mock_')) {
                alert('Mode Percobaan (Kunci Midtrans belum diisi di .env):\n\nUntuk menguji di local, Anda dapat memasukkan MIDTRANS_SERVER_KEY dan MIDTRANS_CLIENT_KEY di file .env. Pembayaran simulasi dapat diverifikasi via webhook.');
                return;
            }

            window.snap.pay(this.snapToken, {
                onSuccess: function(result) {
                    window.location.reload();
                },
                onPending: function(result) {
                    window.location.reload();
                },
                onError: function(result) {
                    alert('Pembayaran gagal atau dibatalkan.');
                },
                onClose: function() {
                    console.log('Popup ditutup tanpa menyelesaikan pembayaran.');
                }
            });
        }
    }
}
</script>
@endpush
