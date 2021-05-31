<?php

namespace App\Services;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Cache;

class ProductService
{
    /**
     * Gets product by given id
     *
     * @param int $productId
     * @return Product
     */
    public function findById(int $productId): Product
    {
        return Cache::remember(
            sprintf(Product::CACHE_KEYS['single'], $productId),
            now()->addWeek(),
            function () use ($productId) {
                return Product::findOrFail($productId);
            }
        );
    }

    /**
     * Checks if product has enough stock for given quantity
     *
     * @param int $productId
     * @param int $quantity
     * @return bool
     */
    public function hasStock(int $productId, int $quantity = 1): bool
    {
        $product = $this->findById($productId);

        return $product->stock >= $quantity;
    }

    /**
     * Get all products from cache.
     *
     * @return Collection
     */
    public function getAll(): Collection
    {
        return Cache::remember(
            Product::CACHE_KEYS['all'],
            now()->addWeek(),
            function () {
                return Product::query()
                    ->from('products', 'p')
                    ->select(
                        'p.id',
                        'p.name',
                        'c.id AS category_id',
                        'c.name AS category',
                        'p.price',
                        'p.stock'
                    )
                    ->join('categories AS c', 'c.id', '=', 'p.id')
                    ->get();
            }
        );
    }
}
