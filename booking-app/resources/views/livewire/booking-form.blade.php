<div class="max-w-2xl mx-auto p-6 bg-white shadow-md rounded-lg">
    <form wire:submit.prevent="submit">
        <div class="grid grid-cols-2 gap-4">
            <div>
                <label>Hotel Name*</label>
                <select wire:model.live="hotel_id" class="w-full border p-2 rounded" required>
                    <option value="">Select Hotel</option>
                    @foreach($hotels as $hotel)
                        <option value="{{ $hotel->id }}">{{ $hotel->name }}</option>
                    @endforeach
                </select>
                @error('hotel_id') <span class="text-red-500">{{ $message }}</span> @enderror
            </div>

            <div>
                <label>Room Type*</label>
                <select wire:model="room_type_id" class="w-full border p-2 rounded" required>
                    <option value="">Select Room Type</option>
                    @foreach($room_types as $room)
                        <option value="{{ $room->id }}">{{ $room->type }}</option>
                    @endforeach
                </select>
                @error('room_type_id') <span class="text-red-500">{{ $message }}</span> @enderror
            </div>

            <div>
            <label>Dates*</label>
            <input
                type="text"
                x-data
                x-init="flatpickr($el, {
                    mode: 'range',
                    dateFormat: 'Y-m-d',
                    minDate: 'today',
                    maxDate: new Date().fp_incr(365),
                    minRange: 1,
                    maxRange: 7,
                    onChange: function(selectedDates) {
                        if (selectedDates.length === 2) {
                            $wire.set('check_in', selectedDates[0].toISOString().split('T')[0]);
                            $wire.set('check_out', selectedDates[1].toISOString().split('T')[0]);
                            $wire.calculateNights();
                        }
                    }
                })"
                class="w-full border p-2 rounded"
                required
                placeholder="Select date range"
            >
            @error('check_in') <span class="text-red-500">{{ $message }}</span> @enderror
            @error('check_out') <span class="text-red-500">{{ $message }}</span> @enderror
        </div>

            <div>
                <label>Number of Nights*</label>
                <input type="number" wire:model="nights" class="w-full border p-2 rounded bg-gray-100" readonly>
                @error('nights') <span class="text-red-500">{{ $message }}</span> @enderror
            </div>

            <div>
                <label>Number of Rooms* (Max: 2)</label>
                <input type="number" wire:model="rooms" class="w-full border p-2 rounded" required min="1" max="2" step="1">
                @error('rooms') <span class="text-red-500">{{ $message }}</span> @enderror
            </div>

            <div>
                <label>Number of Pax* (Max: 5)</label>
                <input type="number" wire:model.live="pax" class="w-full border p-2 rounded" required min="1" max="5" step="1">
                @error('pax') <span class="text-red-500">{{ $message }}</span> @enderror
            </div>
        </div>

        <div class="mt-4">
            <label>Notes{{ (int)$pax > 1 ? '*' : '' }}</label>
            <textarea
                wire:model="notes"
                class="w-full border p-2 rounded"
                placeholder="Additional requests..."
                {{ (int)$pax > 1 ? 'required' : '' }}
            ></textarea>
            @error('notes') <span class="text-red-500">{{ $message }}</span> @enderror
        </div>

        <button type="submit" class="mt-4 w-full bg-blue-500 text-white p-2 rounded hover:bg-blue-600">
            Submit Booking
        </button>

        @if (session()->has('message'))
            <p class="mt-2 text-green-500">{{ session('message') }}</p>
        @endif
    </form>
</div>
