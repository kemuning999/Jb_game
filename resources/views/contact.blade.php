@extends('layouts.main')

@section('content')
<div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-14 space-y-12">
    <div class="text-center space-y-4">
        <span class="text-xs font-bold text-indigo-400 uppercase tracking-widest">Pusat Layanan Pelanggan</span>
        <h1 class="text-3xl sm:text-4xl font-extrabold text-white tracking-tight">Hubungi Kami & Layanan CS</h1>
        <p class="text-slate-400 text-base max-w-xl mx-auto leading-relaxed">
            Tim admin dan teknis kami siap mendampingi proses pengamanan akun Anda 24 jam sehari.
        </p>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
        <!-- WhatsApp Quick Chat -->
        <div class="p-8 rounded-3xl bg-slate-900 border border-slate-800 space-y-5 flex flex-col justify-between">
            <div class="space-y-4">
                <div class="w-14 h-14 rounded-2xl bg-emerald-500/10 border border-emerald-500/30 flex items-center justify-center text-emerald-400">
                    <svg class="w-7 h-7" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M12.031 6.172c-3.181 0-5.767 2.586-5.768 5.766-.001 1.298.38 2.27 1.019 3.287l-.582 2.128 2.182-.573c.978.58 1.911.928 3.145.929 3.178 0 5.767-2.587 5.768-5.766.001-3.187-2.575-5.77-5.764-5.771zm3.392 8.244c-.144.405-.837.774-1.17.824-.299.045-.677.063-1.092-.069-.252-.08-.575-.187-.988-.365-1.739-.751-2.874-2.502-2.961-2.617-.087-.116-.708-.94-.708-1.793s.448-1.273.607-1.446c.159-.173.346-.217.462-.217l.332.006c.106.005.249-.04.39.298.144.347.491 1.2.534 1.287.043.087.072.188.014.304-.058.116-.087.188-.173.289l-.26.304c-.087.086-.177.18-.076.354.101.174.449.741.964 1.201.662.591 1.221.774 1.394.86.173.086.275.072.376-.044.101-.116.433-.506.549-.68.116-.173.231-.145.39-.086s1.011.477 1.184.564.289.13.332.202c.045.072.045.419-.099.824zm-3.423-14.416c-6.627 0-12 5.373-12 12 0 2.12.553 4.11 1.521 5.836l-1.616 5.908 6.07-1.593c1.664.908 3.57 1.42 5.603 1.42 6.627 0 12-5.373 12-12s-5.373-12-12-12zm0 21.6c-1.848 0-3.573-.506-5.06-1.385l-.363-.215-3.766.988.995-3.673-.235-.374c-.958-1.527-1.471-3.308-1.471-5.141 0-5.293 4.307-9.6 9.6-9.6s9.6 4.307 9.6 9.6-4.307 9.6-9.6 9.6z"/>
                    </svg>
                </div>
                <h2 class="text-xl font-bold text-white">WhatsApp Customer Service</h2>
                <p class="text-sm text-slate-400 leading-relaxed">
                    Respon kilat untuk panduan ganti bind email, kode OTP verifikasi, dan bantuan transaksi.
                </p>
                <div class="text-emerald-400 font-bold text-sm">
                    +62 812-3456-7890 (Online 24/7)
                </div>
            </div>
            <a href="https://wa.me/6281234567890?text={{ urlencode('Halo Admin JB GAME, saya ingin bertanya seputar akun game.') }}" target="_blank" class="w-full py-3.5 px-6 rounded-2xl text-center font-bold bg-emerald-600 hover:bg-emerald-500 text-white shadow-xl shadow-emerald-600/30 transition">
                Chat WhatsApp Sekarang
            </a>
        </div>

        <!-- Jam Operasional & Alamat -->
        <div class="p-8 rounded-3xl bg-slate-900 border border-slate-800 space-y-6">
            <h2 class="text-xl font-bold text-white">Informasi Operasional</h2>
            <div class="space-y-4 text-sm text-slate-300">
                <div class="flex items-start space-x-3">
                    <svg class="w-5 h-5 text-indigo-400 shrink-0 mt-0.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    <div>
                        <strong class="text-white block font-semibold">Sistem Pembayaran QRIS</strong>
                        Otomatis 24 Jam Nonstop tanpa jeda.
                    </div>
                </div>
                <div class="flex items-start space-x-3">
                    <svg class="w-5 h-5 text-indigo-400 shrink-0 mt-0.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 5.636l-3.536 3.536m0 5.656l3.536 3.536M9.172 9.172L5.636 5.636m3.536 9.192l-3.536 3.536M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-5 0a4 4 0 11-8 0 4 4 0 018 0z" />
                    </svg>
                    <div>
                        <strong class="text-white block font-semibold">Bantuan Teknis & Rekber</strong>
                        Setiap hari, pukul 08:00 - 24:00 WIB.
                    </div>
                </div>
                <div class="flex items-start space-x-3">
                    <svg class="w-5 h-5 text-indigo-400 shrink-0 mt-0.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                    </svg>
                    <div>
                        <strong class="text-white block font-semibold">Email Resmi</strong>
                        support@jbgame.com
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
