<?php

namespace App\Filament\Widgets;

use App\Models\Order;
use App\Models\Product;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class StatsOverview extends BaseWidget
{
    protected static ?int $sort = 1;

    protected function getStats(): array
    {
        $totalProducts = Product::count();
        $availableProducts = Product::where('status', 'available')->count();
        $soldProducts = Product::where('status', 'sold')->count();

        $totalOrders = Order::count();
        $pendingOrders = Order::where('payment_status', 'pending')->count();
        $completedOrders = Order::where('order_status', 'completed')->count();

        $totalRevenue = Order::where('payment_status', 'paid')->sum('total_amount');

        return [
            Stat::make('Total Produk', $totalProducts)
                ->description($soldProducts . ' akun sudah terjual')
                ->descriptionIcon('heroicon-m-cube')
                ->color('primary'),

            Stat::make('Produk Tersedia', $availableProducts)
                ->description('Siap dibeli oleh customer')
                ->descriptionIcon('heroicon-m-check-circle')
                ->color('success'),

            Stat::make('Total Order', $totalOrders)
                ->description('Semua riwayat transaksi')
                ->descriptionIcon('heroicon-m-shopping-cart')
                ->color('info'),

            Stat::make('Order Pending', $pendingOrders)
                ->description('Menunggu pembayaran QRIS')
                ->descriptionIcon('heroicon-m-clock')
                ->color('warning'),

            Stat::make('Order Selesai', $completedOrders)
                ->description('Akun berhasil diserahkan')
                ->descriptionIcon('heroicon-m-check-badge')
                ->color('success'),

            Stat::make('Total Pendapatan', 'Rp ' . number_format($totalRevenue, 0, ',', '.'))
                ->description('Dari seluruh order lunas')
                ->descriptionIcon('heroicon-m-banknotes')
                ->color('success'),
        ];
    }
}
