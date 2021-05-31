<?php

namespace App\Discounts;

use App\Models\Discount;
use App\Models\Order;

class GetFreeProduct implements DiscountInterface
{
    /**
     * Gets order items for given category and checks quantity.
     *  If match any records, applies discount.
     *  If customer bought enough for multiple discount, applies discount for multiple times.
     *
     * @param Order $order
     * @param Discount $discount
     * @return array|DiscountResult[]
     * @throws \Exception
     */
    public function getDiscountAmount(Order $order, Discount $discount): array
    {
        $orderItems = $order->items
            ->where('product.category_id', $discount->category_id)
            ->where('quantity', $discount->amount_operator, $discount->amount);

        $result = [];

        foreach ($orderItems as $item) {
            $discountAmount = $discount->getDiscountedValue($item->unit_price);
            $discountCountToAdd = (int) ($item->quantity / $discount->amount);

            for ($i = 0; $i < $discountCountToAdd; $i++) {
                $result[] = new DiscountResult(
                    $discount->reason,
                    $discountAmount,
                    $item->total - $discountAmount
                );
            }
        }

        return $result;
    }
}
