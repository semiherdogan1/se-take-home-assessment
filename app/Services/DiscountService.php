<?php

namespace App\Services;

use App\Models\Discount;

class DiscountService
{
    private $productService;

    /**
     * @param ProductService $productService
     */
    public function __construct(ProductService $productService)
    {
        $this->productService = $productService;
    }

    /**
     * Get discounts for given order.
     *
     * @param $order
     * @return array
     */
    public function getOrderDiscounts($order): array
    {
        // add product data into order items
        foreach ($order->items as &$orderItem) {
            $orderItem->product = $this->productService->findById($orderItem->product_id);
        }

        $discounts = [];

        Discount::query()
            ->active()
            ->get()
            ->each(function (Discount $discount) use ($order, &$discounts) {
                $results = (new $discount->class())->getDiscountAmount($order, $discount);

                if (!is_null($results)) {
                    foreach ($results as $result) {
                        $discounts[] = $result->toArray();
                    }
                }
            });

        $totalDiscounts = array_sum(array_column($discounts, 'amount'));

        return [
            'order_id' => $order->id,
            'discounts' => $discounts,
            'total' => formatFloat($order->total),
            'total_discounts' => formatFloat($totalDiscounts),
            'discounted_total' => formatFloat($order->total - $totalDiscounts),
        ];
    }
}
