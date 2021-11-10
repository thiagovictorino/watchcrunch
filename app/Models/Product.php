<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    use HasFactory;
    use SoftDeletes;

    /**
     * @return BelongsTo
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * @param Builder $query
     * @param int $min
     * @param int $max
     * @param string $sort
     */
    public function scopePriceRange(Builder $query, int $min, int $max, string $sort = 'ASC') {
        if(strtoupper($sort) !== 'ASC' && strtoupper($sort) !== 'DESC') {
            throw new \InvalidArgumentException('The `sort` parameter should be ASC or DESC');
        }
        $query->whereBetween('price', [$min, $max])->orderBy('price', $sort);
    }
}
