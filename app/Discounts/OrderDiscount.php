<?php

namespace App\Discounts;

use App\Models\Discount;
use App\Models\Order;

class OrderDiscount implements DiscountInterface
{
    /**
     * Checks total order amount if enough for discount.
     *  If amount is enough applies discount for one time.
     *
     * @param Order $order
     * @param Discount $discount
     * @return array
     */
    public function getDiscountAmount(Order $order, Discount $discount): array
    {
        $result = [];

        if ($order->total >= $discount->amount) {
            $discountAmount = $discount->getDiscountedValue($order->total);

            $result[] = new DiscountResult(
                $discount->reason,
                $discountAmount,
                $order->total - $discountAmount
            );
        }

        return $result;
    }
}
