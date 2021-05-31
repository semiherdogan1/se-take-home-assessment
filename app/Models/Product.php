<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;

class Product extends Base
{
    use HasFactory;

    protected $casts = [
        'price' => 'float',
    ];

    public const CACHE_KEYS = [
        'all' => 'products',
        'single' => 'product:%d',
    ];
}
