<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Order>
 */
class OrderFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'number' => $this->faker->randomNumber(8),
            'total_harga' => $this->faker->numberBetween(25000, 200000),
            'payment_status' => 1,
            'user_id' => 2,
            'tgl_pesanan' => '2023-04-21',
            'shipping_cost_id' => 3,
            'stok_skrng' => 0,
            
        ];
    }
}
