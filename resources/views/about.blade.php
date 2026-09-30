@extends('layouts.main')

@section('content')
<div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-14 space-y-12">
    <div class="text-center space-y-4">
        <span class="inline-flex items-center px-3.5 py-1.5 rounded-full text-xs font-bold text-indigo-700 bg-indigo-50 border border-indigo-200 uppercase tracking-widest">
            Tentang Platform Kami
        </span>
        <h1 class="text-3xl sm:text-4xl font-extrabold text-slate-900 tracking-tight">Platform Jual Beli Akun Game No. 1</h1>
        <p class="text-slate-600 text-base max-w-2xl mx-auto leading-relaxed">
            JB GAME hadir sebagai solusi transaksi akun game yang aman, transparan, dan bebas dari risiko penipuan serta hackback.
        </p>
    </div>

    <div class="p-8 rounded-3xl bg-white border border-slate-200 shadow-xs space-y-6">
        <h2 class="text-2xl font-bold text-slate-900">Komitmen Keamanan Kami</h2>
        <p class="text-slate-600 text-sm leading-relaxed">
            Banyak gamer sering mengalami kerugian saat melakukan jual beli akun melalui media sosial tanpa perantara terpercaya. Sering kali terjadi kasus penipuan, akun ditarik kembali setelah pembayaran, atau penjual menghilang begitu saja.
        </p>
        <p class="text-slate-600 text-sm leading-relaxed">
            JB GAME menghadirkan ekosistem terpadu dan terpercaya:
        </p>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 pt-2">
            <div class="p-4 rounded-2xl bg-slate-50 border border-slate-200 flex items-start space-x-3">
                <div class="w-8 h-8 rounded-xl bg-indigo-100 text-indigo-700 font-bold flex items-center justify-center shrink-0">1</div>
                <div class="text-xs">
                    <strong class="text-slate-900 block font-bold mb-1">Verifikasi Akun Berlapis</strong>
                    Setiap akun dicek kelengkapan bind (Moonton, Google Play, Facebook, Riot, dan lainnya) sebelum dipublikasikan.
                </div>
            </div>
            <div class="p-4 rounded-2xl bg-slate-50 border border-slate-200 flex items-start space-x-3">
                <div class="w-8 h-8 rounded-xl bg-emerald-100 text-emerald-700 font-bold flex items-center justify-center shrink-0">2</div>
                <div class="text-xs">
                    <strong class="text-slate-900 block font-bold mb-1">Pembayaran QRIS Resmi</strong>
                    Semua transaksi melewati QRIS resmi berstandar Bank Indonesia yang terawasi, otomatis, dan aman.
                </div>
            </div>
            <div class="p-4 rounded-2xl bg-slate-50 border border-slate-200 flex items-start space-x-3">
                <div class="w-8 h-8 rounded-xl bg-cyan-100 text-cyan-700 font-bold flex items-center justify-center shrink-0">3</div>
                <div class="text-xs">
                    <strong class="text-slate-900 block font-bold mb-1">Kredensial Otomatis</strong>
                    Data login tidak perlu menunggu admin membuka obrolan manual, sistem otomatis menampilkannya setelah status lunas.
                </div>
            </div>
            <div class="p-4 rounded-2xl bg-slate-50 border border-slate-200 flex items-start space-x-3">
                <div class="w-8 h-8 rounded-xl bg-amber-100 text-amber-700 font-bold flex items-center justify-center shrink-0">4</div>
                <div class="text-xs">
                    <strong class="text-slate-900 block font-bold mb-1">Garansi Seumur Hidup</strong>
                    Perlindungan ganti rugi jika terbukti terjadi penarikan kembali (hackback) oleh pemilik asal.
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
