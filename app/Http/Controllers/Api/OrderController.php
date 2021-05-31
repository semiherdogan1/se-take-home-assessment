<?php

namespace App\Http\Controllers\Api;

use App\Classes\ResponseCodes;
use App\Exceptions\ResponderException;
use App\Http\Requests\OrderAddRequest;
use App\Http\Requests\OrderRemoveRequest;
use App\Services\OrderService;
use App\Services\ProductService;

class OrderController
{
    private $orderService;
    private $productService;

    /**
     * @param OrderService $orderService
     * @param ProductService $productService
     */
    public function __construct(OrderService $orderService, ProductService $productService)
    {
        $this->orderService = $orderService;
        $this->productService = $productService;
    }

    /**
     * Get order list
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(): \Illuminate\Http\JsonResponse
    {
        return responder()->send($this->orderService->getList(customer('id')));
    }

    /**
     * Add to order
     *
     * @param OrderAddRequest $request
     * @return \Illuminate\Http\JsonResponse
     * @throws ResponderException
     */
    public function add(OrderAddRequest $request): \Illuminate\Http\JsonResponse
    {
        $hasStock = $this->productService->hasStock(
            $request->input('product_id'),
            $request->input('quantity')
        );

        if (!$hasStock) {
            throw new ResponderException(ResponseCodes::VALIDATION_NOT_ENOUGH_STOCK);
        }

        $this->orderService->addProduct(
            customer('id'),
            $request->input('product_id'),
            $request->input('quantity')
        );

        return responder()->send();
    }

    /**
     * Remove product from order
     *
     * @param OrderRemoveRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function remove(OrderRemoveRequest $request): \Illuminate\Http\JsonResponse
    {
        $this->orderService->removeProduct(
            customer('id'),
            $request->input('product_id')
        );

        return responder()->send();
    }
}
