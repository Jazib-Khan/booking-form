<?php

namespace App\Livewire;

use Livewire\Component;

class BookingForm extends Component
{
    public $hotel_name, $room_type, $dates, $nights, $rooms, $pax, $notes;

    public $hotels = ['Hotel A', 'Hotel B', 'Hotel C'];
    public $room_types = ['Single', 'Double', 'Suite'];

    public function submit()
    {
        $this->validate([
            'hotel_name' => 'required',
            'room_type' => 'required',
            'dates' => 'required',
            'nights' => 'required|numeric',
            'rooms' => 'required|numeric',
            'pax' => 'required|numeric',
        ]);

        session()->flash('message', 'Booking successfully submitted!');
    }

    public function render()
    {
        return view('livewire.booking-form');
    }
}
