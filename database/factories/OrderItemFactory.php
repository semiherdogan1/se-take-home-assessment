<?php

namespace Database\Factories;

use App\Models\OrderItem;
use App\Models\Product;
use Illuminate\Database\Eloquent\Factories\Factory;

class OrderItemFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = OrderItem::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $quantity = $this->faker->numberBetween(1, 20);
        $unitPrice = $this->faker->randomFloat(500, 10, 300);

        return [
            'order_id' => 1,
            'product_id' => Product::inRandomOrder()->first()->id,
            'quantity' => $quantity,
            'unit_price' => $unitPrice,
            'total' => $unitPrice * $unitPrice,
        ];
    }
}
