<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class HomeController extends Controller
{
    public function index()
    {
        $categories = Cache::remember('home_categories_count', 120, function () {
            return Category::where('is_active', true)
                ->withCount(['products' => function ($q) {
                    $q->where('status', 'available');
                }])
                ->get();
        });

        $latestProducts = Product::with('category')
            ->where('status', 'available')
            ->latest()
            ->take(8)
            ->get();

        $stats = Cache::remember('home_counts_stats', 120, function () {
            return [
                'allAvailableCount' => Product::where('status', 'available')->count(),
                'soldCount' => Product::where('status', 'sold')->count(),
            ];
        });

        $allAvailableCount = $stats['allAvailableCount'];
        $soldCount = $stats['soldCount'];

        return view('home', compact('categories', 'latestProducts', 'allAvailableCount', 'soldCount'));
    }
}
