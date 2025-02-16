<?php

namespace App\Livewire;

use App\Models\Hotel;
use App\Models\RoomType;
use Carbon\Carbon;
use Livewire\Component;

class BookingForm extends Component
{
    public $hotel_id, $room_type_id, $dates, $nights, $rooms, $pax, $notes;
    public $hotels = [];
    public $room_types = [];
    public $check_in, $check_out;

    public function mount()
    {
        $this->hotels = Hotel::all();
        $this->room_types = collect();
    }

    public function updatedHotelId($hotelId)
    {
        if ($hotelId) {
            $this->room_types = RoomType::where('hotel_id', $hotelId)->get();
        } else {
            $this->room_types = collect(); // Empty the dropdown if no hotel is selected
        }
        $this->room_type_id = ''; // Reset room type selection
    }

    public function calculateNights()
    {
        if ($this->check_in && $this->check_out) {
            $start = Carbon::parse($this->check_in);
            $end = Carbon::parse($this->check_out);
            $this->nights = $start->diffInDays($end);
        }
    }

    protected function rules()
    {
        $maxCheckOut = Carbon::parse($this->check_in)->addDays(7)->format('Y-m-d');

        return [
            'hotel_id' => 'required|exists:hotels,id',
            'room_type_id' => 'required|exists:room_types,id',
            'check_in' => 'required|date|after_or_equal:today',
            'check_out' => [
                'required',
                'date',
                'after:check_in',
                "before_or_equal:$maxCheckOut"
            ],
            'nights' => 'required|integer|min:1|max:7',
            'rooms' => 'required|integer|min:1|max:2',
            'pax' => 'required|integer|min:1|max:5',
            'notes' => (int)$this->pax > 1 ? 'required|string' : 'nullable|string',
        ];
    }

    public function submit()
    {
        $validatedData = $this->validate();

        session()->flash('message', 'Booking successfully submitted!');
    }

    public function render()
    {
        return view('livewire.booking-form');
    }
}
