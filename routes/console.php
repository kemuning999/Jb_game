<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;

Artisan::command('check:catalog', function () {
    $total = \App\Models\Product::count();
    $withThumb = \App\Models\Product::whereNotNull('thumbnail')->where('thumbnail', '!=', '')->count();
    $noThumb = \App\Models\Product::whereNull('thumbnail')->orWhere('thumbnail', '')->count();
    $this->info("Total Products: {$total} (With Thumb: {$withThumb}, No Thumb: {$noThumb})");

    foreach (\App\Models\Category::all() as $cat) {
        $count = $cat->products()->count();
        $min = $cat->products()->min('price');
        $max = $cat->products()->max('price');
        $this->line("- [{$cat->id}] {$cat->name} (Icon: {$cat->icon}): {$count} prods (Rp {$min} - Rp {$max})");
    }
})->purpose('Check products and categories');
