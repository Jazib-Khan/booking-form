<div class="max-w-2xl mx-auto p-6 bg-white shadow-md rounded-lg">
    <form wire:submit.prevent="submit">
        <div class="grid grid-cols-2 gap-4">
            <div>
                <label>Hotel Name*</label>
                <select wire:model="hotel_name" class="w-full border p-2 rounded">
                    <option value="">Select Hotel</option>
                    @foreach($hotels as $hotel)
                        <option value="{{ $hotel }}">{{ $hotel }}</option>
                    @endforeach
                </select>
                @error('hotel_name') <span class="text-red-500">{{ $message }}</span> @enderror
            </div>

            <div>
                <label>Room Type*</label>
                <select wire:model="room_type" class="w-full border p-2 rounded">
                    <option value="">Select Room Type</option>
                    @foreach($room_types as $room)
                        <option value="{{ $room }}">{{ $room }}</option>
                    @endforeach
                </select>
                @error('room_type') <span class="text-red-500">{{ $message }}</span> @enderror
            </div>

            <div>
                <label>Dates*</label>
                <input type="date" wire:model="dates" class="w-full border p-2 rounded">
                @error('dates') <span class="text-red-500">{{ $message }}</span> @enderror
            </div>

            <div>
                <label>Number of Nights*</label>
                <input type="number" wire:model="nights" class="w-full border p-2 rounded">
                @error('nights') <span class="text-red-500">{{ $message }}</span> @enderror
            </div>

            <div>
                <label>Number of Rooms*</label>
                <input type="number" wire:model="rooms" class="w-full border p-2 rounded">
                @error('rooms') <span class="text-red-500">{{ $message }}</span> @enderror
            </div>

            <div>
                <label>Number of Pax*</label>
                <input type="number" wire:model="pax" class="w-full border p-2 rounded">
                @error('pax') <span class="text-red-500">{{ $message }}</span> @enderror
            </div>
        </div>

        <div class="mt-4">
            <label>Notes</label>
            <textarea wire:model="notes" class="w-full border p-2 rounded" placeholder="Additional requests..."></textarea>
        </div>

        <button type="submit" class="mt-4 w-full bg-blue-500 text-white p-2 rounded hover:bg-blue-600">
            Submit Booking
        </button>

        @if (session()->has('message'))
            <p class="mt-2 text-green-500">{{ session('message') }}</p>
        @endif
    </form>
</div>
