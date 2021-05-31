<?php


namespace App\Discounts;

use App\Models\Discount;
use App\Models\Order;

interface DiscountInterface
{
    /**
     * @param Order $order
     * @param Discount $discount
     * @return DiscountResult[]
     */
    public function getDiscountAmount(Order $order, Discount $discount): array;
}
