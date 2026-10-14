<?php

namespace App\Filament\Widgets;

use App\Models\Order;
use App\Models\Product;
use Filament\Widgets\Widget;

class QuickAdminGuide extends Widget
{
    protected string $view = 'filament.widgets.quick-admin-guide';

    protected static ?int $sort = -1; // Tampil paling atas di Dashboard

    protected int | string | array $columnSpan = 'full';

    public function getViewData(): array
    {
        return [
            'pendingOrdersCount' => Order::where('payment_status', 'pending')->count(),
            'availableProductsCount' => Product::where('status', 'available')->count(),
        ];
    }
}
