<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Models\Hotel;
use App\Models\RoomType;
use App\Models\Booking;
use Livewire\Livewire;
use App\Livewire\BookingForm;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;

class BookingFormTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_displays_validation_errors_when_required_fields_are_missing()
    {
        Livewire::test(BookingForm::class)
            ->call('submit')
            ->assertHasErrors([
                'hotel_id' => 'required',
                'room_type_id' => 'required',
                'check_in' => 'required',
                'check_out' => 'required',
                'nights' => 'required',
                'rooms' => 'required',
                'pax' => 'required',
            ]);
    }

    /** @test */
    public function it_does_not_allow_more_than_7_nights()
    {
        $hotel = Hotel::factory()->create();
        $roomType = RoomType::factory()->create(['hotel_id' => $hotel->id]);

        Livewire::test(BookingForm::class)
            ->set('hotel_id', $hotel->id)
            ->set('room_type_id', $roomType->id)
            ->set('check_in', Carbon::today()->format('Y-m-d'))
            ->set('check_out', Carbon::today()->addDays(8)->format('Y-m-d')) // Exceeds 7 nights
            ->call('calculateNights')
            ->assertSee('Maximum stay is 7 nights.');
    }

    /** @test */
    public function it_correctly_calculates_total_cost()
    {
        $hotel = Hotel::factory()->create();
        $roomType = RoomType::factory()->create([
            'hotel_id' => $hotel->id,
            'cost_per_night' => 150
        ]);

        Livewire::test(BookingForm::class)
            ->set('hotel_id', $hotel->id)
            ->set('room_type_id', $roomType->id)
            ->set('check_in', Carbon::today()->format('Y-m-d'))
            ->set('check_out', Carbon::today()->addDays(2)->format('Y-m-d'))
            ->set('rooms', 2)
            ->call('calculateCost')
            ->assertSet('totalCost', 2 * 150 * 2);
    }

    /** @test */
    public function it_stores_a_booking_in_the_database()
    {
        $hotel = Hotel::factory()->create();
        $roomType = RoomType::factory()->create(['hotel_id' => $hotel->id]);

        Livewire::test(BookingForm::class)
            ->set('hotel_id', $hotel->id)
            ->set('room_type_id', $roomType->id)
            ->set('check_in', Carbon::today()->format('Y-m-d'))
            ->set('check_out', Carbon::today()->addDays(2)->format('Y-m-d')) // 1 night
            ->set('nights', 1)
            ->set('rooms', 1)
            ->set('pax', 2)
            ->set('notes', 'Special request')
            ->call('submit');

        $this->assertDatabaseHas('bookings', [
            'hotel_id' => $hotel->id,
            'room_type_id' => $roomType->id,
            'nights' => 1,
            'rooms' => 1,
            'pax' => 2,
            'notes' => 'Special request',
        ]);
    }

    /** @test */
    public function it_updates_room_types_when_a_hotel_is_selected()
    {
        $hotel = Hotel::factory()->create();
        $roomType1 = RoomType::factory()->create(['hotel_id' => $hotel->id]);
        $roomType2 = RoomType::factory()->create(['hotel_id' => $hotel->id]);

        Livewire::test(BookingForm::class)
            ->set('hotel_id', $hotel->id)
            ->assertSee($roomType1->type)
            ->assertSee($roomType2->type);
    }
}
