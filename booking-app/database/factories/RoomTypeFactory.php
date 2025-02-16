<?php

namespace Database\Factories;

use App\Models\Hotel;
use App\Models\RoomType;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\RoomType>
 */
class RoomTypeFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    protected $model = RoomType::class;

    public function definition()
    {
        return [
            'hotel_id' => Hotel::factory(), // Automatically creates a hotel
            'type' => $this->faker->randomElement(['Standard', 'Deluxe', 'Suite']),
            'cost_per_night' => $this->faker->randomFloat(2, 50, 500),
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}
