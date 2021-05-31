<?php

namespace App\Http\Controllers\Api;

use App\Services\ProductService;

class ProductController
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
     * Get product list
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function __invoke(): \Illuminate\Http\JsonResponse
    {
        return responder()->send($this->productService->getAll());
    }
}
