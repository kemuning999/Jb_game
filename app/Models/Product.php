<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'category_id',
        'seller_id',
        'title',
        'slug',
        'price',
        'short_description',
        'description',
        'thumbnail',
        'images',
        'account_username',
        'account_password',
        'account_additional_info',
        'status',
    ];

    protected $hidden = [
        'account_username',
        'account_password',
        'account_additional_info',
    ];

    protected function casts(): array
    {
        return [
            'price' => 'decimal:2',
            'images' => 'array',
        ];
    }

    protected static function booted(): void
    {
        static::creating(function ($product) {
            if (empty($product->slug) && !empty($product->title)) {
                $product->slug = \Illuminate\Support\Str::slug($product->title) . '-' . \Illuminate\Support\Str::random(4);
            }
        });

        static::saved(function () {
            \Illuminate\Support\Facades\Cache::forget('home_categories_count');
            \Illuminate\Support\Facades\Cache::forget('home_counts_stats');
            \Illuminate\Support\Facades\Cache::forget('active_categories_list');
            \Illuminate\Support\Facades\Cache::forget('home_latest_products');
        });

        static::deleted(function () {
            \Illuminate\Support\Facades\Cache::forget('home_categories_count');
            \Illuminate\Support\Facades\Cache::forget('home_counts_stats');
            \Illuminate\Support\Facades\Cache::forget('active_categories_list');
            \Illuminate\Support\Facades\Cache::forget('home_latest_products');
        });
    }

    public function scopeAvailable(Builder $query): Builder
    {
        return $query->where('status', 'available');
    }

    public function isAvailable(): bool
    {
        return $this->status === 'available';
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function seller(): BelongsTo
    {
        return $this->belongsTo(User::class, 'seller_id');
    }

    public function orders(): HasMany
    {
        return $this->hasMany(Order::class);
    }

    public function getFormattedPriceAttribute(): string
    {
        return 'Rp ' . number_format((float) $this->price, 0, ',', '.');
    }
}
