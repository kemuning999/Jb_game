@extends('layouts.main')

@section('content')
<div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-14 space-y-12">
    <div class="text-center space-y-4">
        <span class="text-xs font-bold text-indigo-400 uppercase tracking-widest">Tentang Platform Kami</span>
        <h1 class="text-3xl sm:text-4xl font-extrabold text-white tracking-tight">Platform Jual Beli Akun Game No. 1</h1>
        <p class="text-slate-400 text-base max-w-2xl mx-auto leading-relaxed">
            JB GAME hadir sebagai solusi transaksi akun game yang aman, transparan, dan bebas dari risiko penipuan serta hackback.
        </p>
    </div>

    <div class="p-8 rounded-3xl bg-slate-900 border border-slate-800 space-y-6">
        <h2 class="text-2xl font-bold text-white">Komitmen Keamanan Kami</h2>
        <p class="text-slate-300 text-sm leading-relaxed">
            Banyak gamer sering mengalami kerugian saat melakukan jual beli akun melalui media sosial seperti Facebook atau WhatsApp tanpa perantara resmi. Sering kali terjadi kasus penipuan, akun di-hack back setelah uang ditransfer, atau penjual kabur setelah pembayaran diterima.
        </p>
        <p class="text-slate-300 text-sm leading-relaxed">
            JB GAME menghadirkan ekosistem terintegrasi:
        </p>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 pt-2">
            <div class="p-4 rounded-2xl bg-slate-950 border border-slate-800 flex items-start space-x-3">
                <div class="w-8 h-8 rounded-xl bg-indigo-600/20 text-indigo-400 flex items-center justify-center shrink-0">1</div>
                <div class="text-xs">
                    <strong class="text-white block font-semibold mb-1">Verifikasi Akun Berlapis</strong>
                    Setiap akun dicek kelengkapan bind (Moonton, Google Play, Facebook, Riot, dsb) sebelum dipublikasikan.
                </div>
            </div>
            <div class="p-4 rounded-2xl bg-slate-950 border border-slate-800 flex items-start space-x-3">
                <div class="w-8 h-8 rounded-xl bg-emerald-600/20 text-emerald-400 flex items-center justify-center shrink-0">2</div>
                <div class="text-xs">
                    <strong class="text-white block font-semibold mb-1">Payment Gateway Terdaftar</strong>
                    Semua transaksi melewati Midtrans resmi yang diawasi oleh Bank Indonesia.
                </div>
            </div>
            <div class="p-4 rounded-2xl bg-slate-950 border border-slate-800 flex items-start space-x-3">
                <div class="w-8 h-8 rounded-xl bg-cyan-600/20 text-cyan-400 flex items-center justify-center shrink-0">3</div>
                <div class="text-xs">
                    <strong class="text-white block font-semibold mb-1">Kredensial Otomatis</strong>
                    Data login tidak perlu menunggu admin membuka chat manual, sistem otomatis menampilkannya setelah status lunas.
                </div>
            </div>
            <div class="p-4 rounded-2xl bg-slate-950 border border-slate-800 flex items-start space-x-3">
                <div class="w-8 h-8 rounded-xl bg-amber-600/20 text-amber-400 flex items-center justify-center shrink-0">4</div>
                <div class="text-xs">
                    <strong class="text-white block font-semibold mb-1">Garansi Seumur Hidup</strong>
                    Perlindungan ganti rugi jika terbukti terjadi penarikan kembali (hackback) oleh pemilik asal.
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
