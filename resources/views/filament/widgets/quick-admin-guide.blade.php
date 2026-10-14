<x-filament-widgets::widget>
    <x-filament::section>
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 pb-4 border-b border-gray-100 dark:border-gray-800">
            <div>
                <div class="flex items-center gap-2">
                    <span class="inline-flex items-center justify-center w-8 h-8 rounded-lg bg-indigo-50 dark:bg-indigo-950 text-indigo-600 dark:text-indigo-400 font-bold text-sm">
                        👋
                    </span>
                    <h2 class="text-base sm:text-lg font-bold text-gray-950 dark:text-white">
                        Pusat Kendali Toko ANDRA JB
                    </h2>
                </div>
                <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">
                    Kelola penjualan akun game, cek transfer QRIS, dan pantau transaksi dengan mudah.
                </p>
            </div>

            <!-- Tombol Aksi Cepat (Quick Action Buttons) -->
            <div class="flex flex-wrap items-center gap-2">
                <a href="/admin/products/create" 
                   class="inline-flex items-center justify-center gap-1.5 px-3.5 py-2 rounded-xl text-xs font-bold text-white bg-indigo-600 hover:bg-indigo-700 shadow-sm transition">
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                    </svg>
                    <span>+ Tambah Akun Baru</span>
                </a>

                @if($pendingOrdersCount > 0)
                    <a href="/admin/orders" 
                       class="inline-flex items-center justify-center gap-1.5 px-3.5 py-2 rounded-xl text-xs font-bold text-amber-800 bg-amber-50 hover:bg-amber-100 border border-amber-200 shadow-sm transition animate-pulse">
                        <span class="w-2 h-2 rounded-full bg-amber-500"></span>
                        <span>{{ $pendingOrdersCount }} Pesanan Butuh Dicek</span>
                    </a>
                @endif

                <a href="/" target="_blank" 
                   class="inline-flex items-center justify-center gap-1.5 px-3 py-2 rounded-xl text-xs font-semibold text-gray-700 dark:text-gray-300 bg-gray-100 dark:bg-gray-800 hover:bg-gray-200 dark:hover:bg-gray-700 transition">
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14" />
                    </svg>
                    <span>Lihat Web Toko</span>
                </a>
            </div>
        </div>

        <!-- 3 Langkah Panduan Singkat untuk Orang Awam -->
        <div class="grid grid-cols-1 sm:grid-cols-3 gap-3 pt-4">
            <!-- Langkah 1 -->
            <div class="p-3.5 rounded-2xl bg-gray-50/70 dark:bg-gray-900/50 border border-gray-100 dark:border-gray-800 flex items-start gap-3">
                <div class="w-7 h-7 shrink-0 rounded-lg bg-indigo-100 dark:bg-indigo-900/60 text-indigo-700 dark:text-indigo-300 font-black text-xs flex items-center justify-center">
                    1
                </div>
                <div>
                    <h3 class="text-xs font-bold text-gray-900 dark:text-white">Posting Akun Game</h3>
                    <p class="text-[11px] text-gray-500 dark:text-gray-400 mt-0.5 leading-relaxed">
                        Pilih game, tentukan harga, upload foto, dan isi data kredensial login akun secara rahasia.
                    </p>
                </div>
            </div>

            <!-- Langkah 2 -->
            <div class="p-3.5 rounded-2xl bg-gray-50/70 dark:bg-gray-900/50 border border-gray-100 dark:border-gray-800 flex items-start gap-3">
                <div class="w-7 h-7 shrink-0 rounded-lg bg-emerald-100 dark:bg-emerald-900/60 text-emerald-700 dark:text-emerald-300 font-black text-xs flex items-center justify-center">
                    2
                </div>
                <div>
                    <h3 class="text-xs font-bold text-gray-900 dark:text-white">Pembeli Scan QRIS</h3>
                    <p class="text-[11px] text-gray-500 dark:text-gray-400 mt-0.5 leading-relaxed">
                        Pembeli melakukan scan QRIS instan dari DANA, GoPay, ShopeePay, atau Bank apa saja.
                    </p>
                </div>
            </div>

            <!-- Langkah 3 -->
            <div class="p-3.5 rounded-2xl bg-gray-50/70 dark:bg-gray-900/50 border border-gray-100 dark:border-gray-800 flex items-start gap-3">
                <div class="w-7 h-7 shrink-0 rounded-lg bg-cyan-100 dark:bg-cyan-900/60 text-cyan-700 dark:text-cyan-300 font-black text-xs flex items-center justify-center">
                    3
                </div>
                <div>
                    <h3 class="text-xs font-bold text-gray-900 dark:text-white">Penyerahan Otomatis</h3>
                    <p class="text-[11px] text-gray-500 dark:text-gray-400 mt-0.5 leading-relaxed">
                        Setelah lunas, sistem otomatis membuka username & password akun game kepada pembeli.
                    </p>
                </div>
            </div>
        </div>
    </x-filament::section>
</x-filament-widgets::widget>
