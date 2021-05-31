<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;

class Order extends Base
{
    use HasFactory;

    protected $casts = [
        'total' => 'float',
    ];

    public function items(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(OrderItem::class);
    }

    public function updateTotal()
    {
        $this->update([
            'total' => $this->items()->sum('total')
        ]);
    }
}
