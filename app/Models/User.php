<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Support\Facades\Cache;

class User extends Authenticatable
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'username',
        'email',
    ];

    /**
     * @return HasMany
     */
    public function products(): HasMany
    {
        return $this->hasMany(Product::class);
    }

    /**
     * @param Builder $query
     */
    public function scopeOrderByProductsTotalValue(Builder $query) {
        $query->addSelect(['total_price_products' => Product::selectRaw('sum(price) as total_price')
            ->whereColumn('user_id', 'users.id')
            ->groupBy('user_id')
        ])->orderBy('total_price_products', 'DESC');
    }

    /**
     * @return Builder
     */
    public static function orderByProductsTotalValueFromCache(): Builder {
        $totalOf45Minutes = 60 * 45;
        return Cache::remember('orderByProductsTotalValueFromCache', $totalOf45Minutes, function() {
            return User::orderByProductsTotalValue();
        });
    }
}
