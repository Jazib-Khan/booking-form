<?php

namespace Database\Factories;

use App\Models\Hotel;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Hotel>
 */
class HotelFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */

    protected $model = Hotel::class;

    public function definition()
    {
        return [
            'name' => $this->faker->company . ' Hotel',
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}
