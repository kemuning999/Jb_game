@extends('layouts.main')

@section('content')
<div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 py-10">
    <div class="mb-8">
        <h1 class="text-3xl font-extrabold text-slate-900 tracking-tight">Pesanan Saya</h1>
        <p class="text-slate-500 text-sm mt-1">Daftar semua akun game yang pernah Anda beli di JB GAME.</p>
    </div>

    @if($orders->isEmpty())
        <div class="text-center py-20 bg-white rounded-3xl border border-slate-200 shadow-xs">
            <svg class="w-16 h-16 text-slate-400 mx-auto mb-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" />
            </svg>
            <h3 class="text-xl font-bold text-slate-900">Belum Ada Riwayat Pesanan</h3>
            <p class="text-slate-500 text-sm mt-1">Anda belum pernah melakukan pembelian akun game.</p>
            <a href="{{ route('products.index') }}" class="inline-block mt-5 px-6 py-2.5 rounded-xl text-sm font-bold bg-indigo-600 hover:bg-indigo-700 text-white shadow-xs transition">
                Mulai Belanja Akun
            </a>
        </div>
    @else
        <div class="bg-white border border-slate-200 rounded-3xl overflow-hidden shadow-xs">
            <div class="overflow-x-auto">
                <table class="w-full text-left text-sm text-slate-700">
                    <thead class="bg-slate-50 text-xs uppercase tracking-wider text-slate-500 border-b border-slate-200">
                        <tr>
                            <th class="py-4 px-6">No. Order</th>
                            <th class="py-4 px-6">Akun Game</th>
                            <th class="py-4 px-6">Total Tagihan</th>
                            <th class="py-4 px-6">Status Bayar</th>
                            <th class="py-4 px-6">Status Pesanan</th>
                            <th class="py-4 px-6">Waktu</th>
                            <th class="py-4 px-6 text-right">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        @foreach($orders as $order)
                            <tr class="hover:bg-slate-50/80 transition">
                                <td class="py-4 px-6 font-mono font-bold text-slate-900">
                                    {{ $order->order_number }}
                                </td>
                                <td class="py-4 px-6">
                                    <div class="flex items-center space-x-3">
                                        <div class="w-12 h-12 rounded-xl bg-slate-100 border border-slate-200 overflow-hidden shrink-0">
                                            @if($order->product->thumbnail)
                                                <img src="{{ asset('storage/' . $order->product->thumbnail) }}" alt="{{ $order->product->title }}" class="w-full h-full object-cover">
                                            @else
                                                <div class="w-full h-full flex items-center justify-center text-slate-400 font-bold text-[10px]">Foto</div>
                                            @endif
                                        </div>
                                        <div class="min-w-0">
                                            <span class="text-[10px] font-bold text-indigo-600 block">{{ $order->product->category->name }}</span>
                                            <span class="font-bold text-slate-900 block truncate max-w-xs" title="{{ $order->product->title }}">
                                                {{ $order->product->title }}
                                            </span>
                                        </div>
                                    </div>
                                </td>
                                <td class="py-4 px-6 font-extrabold text-indigo-600">
                                    {{ $order->formatted_total }}
                                </td>
                                <td class="py-4 px-6">
                                    <span class="px-2.5 py-1 rounded-lg text-xs font-bold uppercase
                                        @if($order->payment_status === 'paid') bg-emerald-50 text-emerald-700 border border-emerald-200
                                        @elseif($order->payment_status === 'pending') bg-amber-50 text-amber-700 border border-amber-200
                                        @else bg-rose-50 text-rose-700 border border-rose-200 @endif">
                                        {{ $order->payment_status }}
                                    </span>
                                </td>
                                <td class="py-4 px-6">
                                    <span class="px-2.5 py-1 rounded-lg text-xs font-semibold
                                        @if($order->order_status === 'completed') bg-emerald-50 text-emerald-700
                                        @elseif($order->order_status === 'processing') bg-cyan-50 text-cyan-700
                                        @elseif($order->order_status === 'pending') bg-amber-50 text-amber-700
                                        @else bg-slate-100 text-slate-600 @endif">
                                        {{ ucfirst($order->order_status) }}
                                    </span>
                                </td>
                                <td class="py-4 px-6 text-xs text-slate-500">
                                    {{ $order->created_at->format('d/m/Y H:i') }}
                                </td>
                                <td class="py-4 px-6 text-right">
                                    <a href="{{ route('orders.show', $order->order_number) }}" class="inline-flex items-center px-3.5 py-1.5 rounded-xl text-xs font-bold @if($order->isPaid()) bg-emerald-600 hover:bg-emerald-700 text-white @else bg-indigo-600 hover:bg-indigo-700 text-white @endif transition shadow-xs">
                                        @if($order->isPaid())
                                            Lihat Akun
                                        @else
                                            Bayar Sekarang
                                        @endif
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <div class="p-4 border-t border-slate-100">
                {{ $orders->links() }}
            </div>
        </div>
    @endif
</div>
@endsection
