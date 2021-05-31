<?php

namespace Database\Factories;

use App\Models\Category;
use App\Models\Discount;
use Illuminate\Database\Eloquent\Factories\Factory;

class DiscountFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Discount::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'category_id' => null,
            'reason' => $this->faker->word(),
            'amount_operator' => '=',
            'amount' => rand(300, 1500),
            'discount' => rand(10, 20),
            'discount_type' => Discount::DISCOUNT_TYPES['PERCENTAGE'],
            'start_date' => now(),
            'end_date' => now()->addWeek(),
        ];
    }
}
