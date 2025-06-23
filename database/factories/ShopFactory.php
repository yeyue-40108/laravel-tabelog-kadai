<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Shop>
 */
class ShopFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'name' => fake()->firstKanaName(),
            'description' => 'テスト店舗の説明です。',
            'postal_code' => fake()->postcode(),
            'address' => fake()->streetAddress(),
            'phone' => fake()->phoneNumber(),
            'category_id' => fake()->numberBetween(1, 14),
            'open_time' => fake()->time('H:00'),
            'close_time' => fake()->time('H:00'),
            'price_id' => fake()->numberBetween(1, 6),
            'master_id' => fake()->numberBetween(2, 11),
        ];
    }
}
