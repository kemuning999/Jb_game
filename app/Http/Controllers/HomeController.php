<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        $categories = Category::where('is_active', true)
            ->withCount(['products' => function ($q) {
                $q->where('status', 'available');
            }])
            ->get();

        $latestProducts = Product::with('category')
            ->where('status', 'available')
            ->latest()
            ->take(8)
            ->get();

        $allAvailableCount = Product::where('status', 'available')->count();
        $soldCount = Product::where('status', 'sold')->count();

        return view('home', compact('categories', 'latestProducts', 'allAvailableCount', 'soldCount'));
    }
}
