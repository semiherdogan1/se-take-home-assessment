<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Discount extends Base
{
    use HasFactory;

    public const DISCOUNT_TYPES = [
        'PERCENTAGE' => 0,
        'CURRENCY' => 1,
        'PRODUCT' => 2,
    ];

    /**
     * Calculates discount according to discount_type
     *
     * @param float $amount
     * @return float
     * @throws \Exception
     */
    public function getDiscountedValue(float $amount): float
    {
        if ($this->discount_type === self::DISCOUNT_TYPES['PERCENTAGE']) {
            return ($this->discount / 100) * $amount;
        }

        if ($this->discount_type === self::DISCOUNT_TYPES['CURRENCY']) {
            return $this->discount;
        }

        if ($this->discount_type === self::DISCOUNT_TYPES['PRODUCT']) {
            return $this->discount * $amount;
        }

        throw new \Exception('Unknown discount type');
    }

    /**
     * Adds start_date and end_date checks into query
     *
     * @param Builder $query
     * @return Builder
     */
    public function scopeActive(Builder $query): Builder
    {
        return $query->whereRaw('? between start_date and end_date', [now()]);
    }
}
