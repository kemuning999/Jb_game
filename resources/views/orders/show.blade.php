@extends('layouts.main')

@section('content')
<div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-10" x-data="orderTracker()">
    <!-- Top Header -->
    <div class="flex flex-col sm:flex-row sm:items-center justify-between pb-6 mb-8 border-b border-slate-800 gap-4">
        <div>
            <div class="flex items-center space-x-2">
                <span class="text-xs font-bold text-indigo-400 uppercase tracking-widest">Detail Pesanan</span>
                <span class="text-xs text-slate-500">•</span>
                <span class="text-xs text-slate-400">{{ $order->created_at->format('d M Y, H:i') }} WIB</span>
            </div>
            <h1 class="text-2xl sm:text-3xl font-extrabold text-white mt-1 flex items-center space-x-3">
                <span>{{ $order->order_number }}</span>
                <button type="button" @click="navigator.clipboard.writeText('{{ $order->order_number }}'); copied = true; setTimeout(() => copied = false, 2000)" class="text-slate-400 hover:text-white text-xs px-2.5 py-1 rounded-lg bg-slate-800 border border-slate-700 font-normal">
                    <span x-show="!copied">Salin No. Order</span>
                    <span x-show="copied" x-cloak class="text-emerald-400 font-semibold">Tersalin!</span>
                </button>
            </h1>
        </div>

        <!-- Status Badges -->
        <div class="flex items-center space-x-2">
            <!-- Payment Badge -->
            <span class="px-3.5 py-1.5 rounded-xl text-xs font-bold uppercase tracking-wider
                @if($order->payment_status === 'paid') bg-emerald-500/10 text-emerald-400 border border-emerald-500/30
                @elseif($order->payment_status === 'pending') bg-amber-500/10 text-amber-400 border border-amber-500/30 animate-pulse
                @else bg-rose-500/10 text-rose-400 border border-rose-500/30 @endif">
                Bayar: {{ strtoupper($order->payment_status) }}
            </span>

            <!-- Order Status Badge -->
            <span class="px-3.5 py-1.5 rounded-xl text-xs font-bold uppercase tracking-wider
                @if($order->order_status === 'completed') bg-emerald-500/10 text-emerald-400 border border-emerald-500/30
                @elseif($order->order_status === 'processing') bg-cyan-500/10 text-cyan-400 border border-cyan-500/30
                @elseif($order->order_status === 'pending') bg-amber-500/10 text-amber-400 border border-amber-500/30
                @else bg-slate-800 text-slate-400 border border-slate-700 @endif">
                Order: {{ ucfirst($order->order_status) }}
            </span>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-12 gap-8">
        <!-- Main Column -->
        <div class="lg:col-span-8 space-y-6">
            <!-- DATA AKUN GAME (CRITICAL SECTION) -->
            <div class="p-6 sm:p-8 rounded-3xl bg-slate-900 border @if($order->isPaid()) border-emerald-500/40 bg-gradient-to-b from-slate-900 via-slate-900 to-emerald-950/20 @else border-slate-800 @endif shadow-2xl">
                <div class="flex items-center justify-between pb-4 mb-5 border-b border-slate-800">
                    <div class="flex items-center space-x-3">
                        <div class="w-10 h-10 rounded-xl @if($order->isPaid()) bg-emerald-500/20 text-emerald-400 border border-emerald-500/30 @else bg-slate-800 text-slate-400 @endif flex items-center justify-center">
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
                            <h2 class="text-lg font-bold text-white">Data Kredensial Akun Game</h2>
                            <p class="text-xs text-slate-400">
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
                        <div class="p-4 rounded-2xl bg-slate-950 border border-slate-800">
                            <label class="block text-xs font-semibold text-slate-400 uppercase tracking-wider mb-1">
                                Username / ID / Email Login:
                            </label>
                            <div class="flex items-center justify-between">
                                <span class="font-mono text-base font-bold text-emerald-400 select-all">
                                    {{ $accountDetails['username'] ?? 'Hubungi CS / Admin' }}
                                </span>
                                @if(!empty($accountDetails['username']))
                                    <button type="button" @click="navigator.clipboard.writeText('{{ $accountDetails['username'] }}'); userCopied = true; setTimeout(() => userCopied = false, 2000)" class="text-xs px-3 py-1.5 rounded-lg bg-slate-800 hover:bg-slate-700 text-slate-200 transition">
                                        <span x-show="!userCopied">Salin</span>
                                        <span x-show="userCopied" x-cloak class="text-emerald-400 font-bold">Tersalin!</span>
                                    </button>
                                @endif
                            </div>
                        </div>

                        <!-- Password -->
                        <div class="p-4 rounded-2xl bg-slate-950 border border-slate-800">
                            <label class="block text-xs font-semibold text-slate-400 uppercase tracking-wider mb-1">
                                Password Akun:
                            </label>
                            <div class="flex items-center justify-between">
                                <span class="font-mono text-base font-bold text-emerald-400 select-all" x-text="showPass ? '{{ $accountDetails['password'] }}' : '••••••••••••'">
                                </span>
                                <div class="flex items-center space-x-2">
                                    <button type="button" @click="showPass = !showPass" class="text-xs px-3 py-1.5 rounded-lg bg-slate-800 hover:bg-slate-700 text-slate-200 transition">
                                        <span x-text="showPass ? 'Sembunyikan' : 'Tampilkan'"></span>
                                    </button>
                                    @if(!empty($accountDetails['password']))
                                        <button type="button" @click="navigator.clipboard.writeText('{{ $accountDetails['password'] }}'); passCopied = true; setTimeout(() => passCopied = false, 2000)" class="text-xs px-3 py-1.5 rounded-lg bg-slate-800 hover:bg-slate-700 text-slate-200 transition">
                                            <span x-show="!passCopied">Salin</span>
                                            <span x-show="passCopied" x-cloak class="text-emerald-400 font-bold">Tersalin!</span>
                                        </button>
                                    @endif
                                </div>
                            </div>
                        </div>

                        <!-- Additional Instructions -->
                        @if(!empty($accountDetails['additional_info']))
                            <div class="p-4 rounded-2xl bg-indigo-950/30 border border-indigo-500/30">
                                <span class="block text-xs font-bold text-indigo-300 uppercase tracking-wider mb-1.5">
                                    Panduan Bind & Info Pemulihan:
                                </span>
                                <p class="text-xs text-slate-300 whitespace-pre-line leading-relaxed">
                                    {{ $accountDetails['additional_info'] }}
                                </p>
                            </div>
                        @endif

                        <div class="p-3.5 rounded-xl bg-amber-500/10 border border-amber-500/20 text-xs text-amber-300 flex items-start space-x-2">
                            <svg class="w-4 h-4 text-amber-400 shrink-0 mt-0.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            <span><strong>Penting:</strong> Segera login ke dalam game dan ganti kata sandi serta kaitkan nomor HP atau email pribadi Anda demi keamanan maksimal.</span>
                        </div>
                    </div>
                @else
                    <!-- LOCKED CREDENTIALS STATE -->
                    <div class="space-y-4 filter blur-[2px] select-none pointer-events-none opacity-40">
                        <div class="p-4 rounded-2xl bg-slate-950 border border-slate-800">
                            <div class="text-xs font-semibold text-slate-400 uppercase tracking-wider mb-1">Username:</div>
                            <div class="font-mono text-base font-bold text-slate-500">Tersembunyi (example123)</div>
                        </div>
                        <div class="p-4 rounded-2xl bg-slate-950 border border-slate-800">
                            <div class="text-xs font-semibold text-slate-400 uppercase tracking-wider mb-1">Password:</div>
                            <div class="font-mono text-base font-bold text-slate-500">••••••••••••</div>
                        </div>
                    </div>

                    <div class="mt-4 p-4 rounded-2xl bg-amber-500/10 border border-amber-500/30 text-amber-300 text-xs flex items-center space-x-3">
                        <svg class="w-5 h-5 text-amber-400 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                        </svg>
                        <span>Selesaikan pembayaran QRIS di bawah ini agar sistem otomatis membuka data akun di atas.</span>
                    </div>
                @endif
            </div>

            <!-- Produk yang Dibeli -->
            <div class="p-6 rounded-3xl bg-slate-900 border border-slate-800 shadow-xl space-y-4">
                <h3 class="text-sm font-bold text-white uppercase tracking-wider">Produk Akun</h3>
                <div class="flex items-center space-x-4">
                    <div class="w-20 h-20 rounded-2xl bg-slate-800 overflow-hidden shrink-0">
                        @if($order->product->thumbnail)
                            <img src="{{ asset('storage/' . $order->product->thumbnail) }}" alt="{{ $order->product->title }}" class="w-full h-full object-cover">
                        @else
                            <div class="w-full h-full flex items-center justify-center text-slate-600 text-xs">Foto</div>
                        @endif
                    </div>
                    <div class="flex-1 min-w-0">
                        <span class="text-xs font-bold text-indigo-400">{{ $order->product->category->name }}</span>
                        <h4 class="font-bold text-white text-base truncate">{{ $order->product->title }}</h4>
                        <span class="text-sm font-extrabold text-emerald-400 block mt-1">{{ $order->formatted_total }}</span>
                    </div>
                    <div>
                        <a href="{{ route('products.show', $order->product->slug) }}" class="px-3.5 py-1.5 rounded-xl text-xs font-semibold bg-slate-800 hover:bg-slate-700 text-slate-200 transition">
                            Lihat Etalase
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Sidebar Column: Payment & Action -->
        <div class="lg:col-span-4 space-y-6">
            <!-- Payment Action Box -->
            <div class="p-6 rounded-3xl bg-slate-900 border border-slate-800 shadow-xl space-y-5">
                <h3 class="text-base font-bold text-white">Rincian Pembayaran</h3>

                <div class="space-y-2 text-xs">
                    <div class="flex justify-between text-slate-400">
                        <span>Total Tagihan</span>
                        <span class="font-bold text-emerald-400 text-sm">{{ $order->formatted_total }}</span>
                    </div>
                    <div class="flex justify-between text-slate-400">
                        <span>Status Bayar</span>
                        <span class="font-bold uppercase text-white">{{ $order->payment_status }}</span>
                    </div>
                    <div class="flex justify-between text-slate-400">
                        <span>Metode</span>
                        <span class="font-medium text-slate-200">{{ strtoupper($order->payment_type ?? 'QRIS / Midtrans') }}</span>
                    </div>
                    @if($order->paid_at)
                        <div class="flex justify-between text-slate-400">
                            <span>Waktu Lunas</span>
                            <span class="font-medium text-slate-200">{{ $order->paid_at->format('d/m/Y H:i') }}</span>
                        </div>
                    @endif
                </div>

                @if($order->payment_status === 'pending')
                    <div class="pt-3 border-t border-slate-800 space-y-3">
                        <button type="button" @click="payWithSnap()" class="w-full flex items-center justify-center space-x-2 py-3.5 px-4 rounded-2xl text-sm font-extrabold bg-gradient-to-r from-emerald-600 to-teal-500 hover:from-emerald-500 hover:to-teal-400 text-white shadow-xl shadow-emerald-600/30 transition transform hover:-translate-y-0.5">
                            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v1m6 11h2m-6 0h-2v4m0-11v3m0 0h.01M12 12h4.01M16 20h4M4 12h4m12 0h.01M5 8h2a1 1 0 001-1V5a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1zm12 0h2a1 1 0 001-1V5a1 1 0 00-1-1h-2a1 1 0 00-1 1v2a1 1 0 001 1zM5 20h2a1 1 0 001-1v-2a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1z" />
                            </svg>
                            <span>Bayar Sekarang (QRIS)</span>
                        </button>

                        <button type="button" @click="window.location.reload()" class="w-full py-2.5 px-4 rounded-xl text-xs font-semibold bg-slate-800 hover:bg-slate-700 text-slate-300 transition text-center">
                            🔄 Cek Status Pembayaran
                        </button>
                    </div>
                @else
                    <div class="p-3.5 rounded-2xl bg-emerald-500/10 border border-emerald-500/30 text-emerald-400 text-xs text-center font-bold">
                        ✓ Transaksi Berhasil & Selesai
                    </div>
                @endif
            </div>

            <!-- Customer Service Assistance -->
            <div class="p-6 rounded-3xl bg-slate-900 border border-slate-800 shadow-xl space-y-3 text-center">
                <h4 class="text-sm font-bold text-white">Butuh Bantuan Akun?</h4>
                <p class="text-xs text-slate-400 leading-relaxed">
                    Jika ada kendala verifikasi email, kode OTP, atau pertanyaan lainnya, hubungi layanan admin kami via WhatsApp.
                </p>
                <a href="https://wa.me/6281234567890?text={{ urlencode('Halo Admin JB GAME, saya butuh bantuan untuk pesanan nomor ' . $order->order_number) }}" target="_blank" class="inline-flex items-center justify-center space-x-2 w-full py-2.5 px-4 rounded-xl text-xs font-bold bg-emerald-600/20 hover:bg-emerald-600/30 text-emerald-300 border border-emerald-500/40 transition">
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
            // Auto open snap if pending and token exists
            if (this.isPending && this.snapToken && !this.snapToken.startsWith('mock_')) {
                // If user just created checkout, trigger modal
                const urlParams = new URLSearchParams(window.location.search);
                if (urlParams.get('pay') === '1') {
                    this.payWithSnap();
                }
            }

            // Periodic status polling if pending
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
