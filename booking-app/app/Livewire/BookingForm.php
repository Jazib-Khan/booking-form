<?php

namespace App\Livewire;

use App\Models\Hotel;
use App\Models\RoomType;
use Livewire\Component;

class BookingForm extends Component
{
    public $hotel_id, $room_type_id, $dates, $nights, $rooms, $pax, $notes;
    public $hotels = [];
    public $room_types = [];

    public function mount()
    {
        $this->hotels = Hotel::all();
        $this->room_types = collect(); // Start with an empty collection
    }

    // Automatically called when hotel_id is updated
    public function updatedHotelId($hotelId)
    {
        if ($hotelId) {
            $this->room_types = RoomType::where('hotel_id', $hotelId)->get();
        } else {
            $this->room_types = collect(); // Empty the dropdown if no hotel is selected
        }
        $this->room_type_id = null; // Reset room type selection
    }

    public function submit()
    {
        $this->validate([
            'hotel_id' => 'required|exists:hotels,id',
            'room_type_id' => 'required|exists:room_types,id',
            'dates' => 'required|date',
            'nights' => 'required|numeric|min:1',
            'rooms' => 'required|numeric|min:1',
            'pax' => 'required|numeric|min:1',
        ]);

        if ((int)$this->pax > 1) {
            $rules['notes'] = 'required|string';
        }

        $validatedData = $this->validate($rules);

        session()->flash('message', 'Booking successfully submitted!');
    }

    public function render()
    {
        return view('livewire.booking-form');
    }
}
