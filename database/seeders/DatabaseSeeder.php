<?php

namespace Database\Seeders;

use App\Models\Discount;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        \App\Models\Category::factory(5)->create();
        \App\Models\Product::factory(5)->create();

        $customers = \App\Models\Customer::factory(5)->create();

        foreach ($customers as $customer) {
            $orders = \App\Models\Order::factory(rand(1, 10))->create(['customer_id' => $customer->id]);

            foreach ($orders as $order) {
                \App\Models\OrderItem::factory(rand(1, 10))->create(['order_id' => $order->id]);
                $order->updateTotal();
            }
        }

        \App\Models\Discount::factory(1)->create([
            'reason' => '10_PERCENT_OVER_1000',
            'amount_operator' => '>=',
            'amount' => 1000,
            'discount' => 10,
            'discount_type' => Discount::DISCOUNT_TYPES['PERCENTAGE'],
            'class' => 'App\Discounts\OrderDiscount',
        ]);

        \App\Models\Discount::factory(1)->create([
            'category_id' => 2,
            'reason' => 'BUY_5_GET_1',
            'amount_operator' => '>=',
            'amount' => 5,
            'discount' => 1,
            'discount_type' => Discount::DISCOUNT_TYPES['PRODUCT'],
            'class' => 'App\Discounts\GetFreeProduct',
        ]);

        \App\Models\Discount::factory(1)->create([
            'category_id' => 1,
            'reason' => 'CHEAPEST_20_PERCENT_OVER_BUY_2',
            'amount_operator' => '>=',
            'amount' => 2,
            'discount' => 20,
            'discount_type' => Discount::DISCOUNT_TYPES['PERCENTAGE'],
            'class' => 'App\Discounts\DiscountToCheapest',
        ]);
    }
}
