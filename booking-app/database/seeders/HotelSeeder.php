<?php

namespace Database\Seeders;

use App\Models\Hotel;
use App\Models\RoomType;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class HotelSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $hotel1 = Hotel::create(['name' => 'The Evergreen Oasis']);
        $hotel2 = Hotel::create(['name' => 'Ocean View Resort']);

        RoomType::create([
            'hotel_id' => $hotel1->id,
            'type' => 'Deluxe Suite',
            'cost_per_night' => 200.00
        ]);

        RoomType::create([
            'hotel_id' => $hotel1->id,
            'type' => 'Standard Room',
            'cost_per_night' => 120.00
        ]);

        RoomType::create([
            'hotel_id' => $hotel2->id,
            'type' => 'Ocean View Room',
            'cost_per_night' => 180.00
        ]);
    }
}
