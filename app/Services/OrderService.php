<?php

namespace App\Services;

use App\Models\Order;
use Illuminate\Support\Collection;

class OrderService
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
     * Get order list
     *
     * @param int $customerId
     * @param int $limit
     * @return Collection
     */
    public function getList(int $customerId, int $limit = 20): Collection
    {
        return Order::query()
            ->select('id', 'total')
            ->with(['items' => function ($itemsQuery) {
                $itemsQuery->select(
                    'order_id',
                    'product_id',
                    'quantity',
                    'unit_price',
                    'total',
                );
            }])
            ->where('customer_id', $customerId)
            ->limit($limit)
            ->get()
            ->each(function ($order) {
                return $order->items->makeHidden('order_id');
            });
    }

    /**
     * Add product into orders
     *
     * @param int $customerId
     * @param int $productId
     * @param int $quantity
     */
    public function addProduct(int $customerId, int $productId, int $quantity): void
    {
        $order = $this->getActiveOrder($customerId);
        $product = $this->productService->findById($productId);

        $orderItem = $order->items()->firstOrNew([
            'product_id' => $product->id,
        ]);

        $orderItem->quantity = $quantity;
        $orderItem->unit_price = $product->price;
        $orderItem->total = $quantity * $product->price;
        $orderItem->save();

        $order->updateTotal();
    }

    /**
     * Remove product from orders
     *
     * @param int $customerId
     * @param int $productId
     */
    public function removeProduct(int $customerId, int $productId): void
    {
        $order = $this->getActiveOrder($customerId);
        $order->items()->where('product_id', $productId)->delete();

        $order->updateTotal();
    }

    /**
     * Get active order
     *
     * @param int $customerId
     * @return Order
     */
    public function getActiveOrder(int $customerId): Order
    {
        $order = Order::firstOrCreate([
            'customer_id' => $customerId,
            'completed' => false,
        ], [
            'total' => 0,
        ]);

        $order->load('items');

        return $order;
    }
}
