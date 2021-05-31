<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;

class OrderItem extends Base
{
    use HasFactory;

    protected $casts = [
        'total' => 'float',
        'unit_price' => 'float',
    ];
}
