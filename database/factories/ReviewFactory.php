<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Review>
 */
class ReviewFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'content' => fake()->realText(20, 5),
            'score' => fake()->numberBetween(1, 5),
            'shop_id' => fake()->numberBetween(1, 45),
            'user_id' => fake()->numberBetween(2, 31),
            'display' => 1,
        ];
    }
}
