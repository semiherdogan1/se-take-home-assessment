<?php

namespace App\Discounts;

use App\Models\Discount;
use App\Models\Order;

class DiscountToCheapest implements DiscountInterface
{
    /**
     * Gets order items for given category and checks quantity.
     *  If match any records, finds cheapest record and applies discount for one time.
     *
     * @param Order $order
     * @param Discount $discount
     * @return array|DiscountResult[]
     */
    public function getDiscountAmount(Order $order, Discount $discount): array
    {
        $orderItems = $order->items
            ->where('product.category_id', $discount->category_id)
            ->where('quantity', $discount->amount_operator, $discount->amount);

        $result = [];

        if ($orderItems->count() > 0) {
            $cheapestItem = $order->items()->where('unit_price', $orderItems->min('unit_price'))->first();

            $discountAmount = $discount->getDiscountedValue($cheapestItem->unit_price);

            $result[] = new DiscountResult(
                $discount->reason,
                $discountAmount,
                $cheapestItem->total - $discountAmount
            );
        }

        return $result;
    }
}
