<?php

namespace App\Http\Controllers\Api;

use App\Services\DiscountService;
use App\Services\OrderService;

class DiscountController
{
    private $discountService;
    private $orderService;

    /**
     * @param DiscountService $discountService
     * @param OrderService $orderService
     */
    public function __construct(DiscountService $discountService, OrderService $orderService)
    {
        $this->discountService = $discountService;
        $this->orderService = $orderService;
    }

    /**
     * Get active order discounts
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function __invoke(): \Illuminate\Http\JsonResponse
    {
        $order = $this->orderService->getActiveOrder(customer('id'));

        return responder()->send($this->discountService->getOrderDiscounts($order));
    }
}
