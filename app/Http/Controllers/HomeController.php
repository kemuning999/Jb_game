<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class HomeController extends Controller
{
    public function index(Request $request)
    {
        $categories = Category::where('is_active', true)
            ->withCount(['products' => function ($q) {
                $q->where('status', 'available');
            }])
            ->get();

        $productsQuery = Product::with('category')->where('status', 'available');

        if ($request->filled('category')) {
            $productsQuery->whereHas('category', function ($q) use ($request) {
                $q->where('slug', $request->category);
            });
        }

        $latestProducts = $productsQuery->latest()->take(8)->get();

        $allAvailableCount = Product::where('status', 'available')->count();
        $soldCount = Product::where('status', 'sold')->count();

        return view('home', compact('categories', 'latestProducts', 'allAvailableCount', 'soldCount'));
    }
}
