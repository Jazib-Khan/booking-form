<?php

namespace App\Livewire;

use App\Models\Hotel;
use App\Models\RoomType;
use Carbon\Carbon;
use Livewire\Component;

class BookingForm extends Component
{
    public $hotel_id, $room_type_id, $dates, $nights, $rooms, $pax, $notes;
    public $hotels = [], $room_types=[], $check_in, $check_out;
    public $costDetails = [], $totalCost = 0;
    public $showCostTable = false;

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
            $days = $start->diffInDays($end);
        }

        if ($days > 7 ) {
            $this->check_out = null;
            $this->nights = $days;
            session()->flash('error', 'Maximum stay is 7 nights.');
        } else {
            $this->nights = $days;
        }
    }

    public function calculateCost()
    {
        if (!$this->hotel_id || !$this->room_type_id || !$this->check_in || !$this->check_out || !$this->rooms) {
            $this->costDetails = [];
            $this->totalCost = 0;
            return;
        }

        $roomType = RoomType::find($this->room_type_id);
        if (!$roomType) {
            return;
        }

        $this->costDetails = [];
        $this->totalCost = 0;
        $start = Carbon::parse($this->check_in);
        $end = Carbon::parse($this->check_out);

        while ($start->lt($end)) {
            $dailyTotal = $roomType->cost_per_night * $this->rooms;
            $this->costDetails[] = [
                'date' => $start->format('d M Y'),
                'details' => "{$this->rooms} Room" . ($this->rooms > 1 ? "s" : "") . " * {$roomType->cost_per_night} USD",
                'dailyTotal' => $dailyTotal,
            ];
            $this->totalCost += $dailyTotal;
            $start->addDay();
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

        $this->calculateCost();
        $this->showCostTable = true;

        session()->flash('message', 'Booking successfully submitted!');
    }

    public function render()
    {
        return view('livewire.booking-form');
    }
}
