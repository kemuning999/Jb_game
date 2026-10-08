<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Category extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'slug',
        'icon',
        'description',
        'is_active',
    ];

    protected function casts(): array
    {
        return [
            'is_active' => 'boolean',
        ];
    }

    public function products(): HasMany
    {
        return $this->hasMany(Product::class);
    }

    protected static function booted(): void
    {
        static::saved(function () {
            \Illuminate\Support\Facades\Cache::forget('home_categories_count');
            \Illuminate\Support\Facades\Cache::forget('home_counts_stats');
            \Illuminate\Support\Facades\Cache::forget('active_categories_list');
        });

        static::deleted(function () {
            \Illuminate\Support\Facades\Cache::forget('home_categories_count');
            \Illuminate\Support\Facades\Cache::forget('home_counts_stats');
            \Illuminate\Support\Facades\Cache::forget('active_categories_list');
        });
    }
}
