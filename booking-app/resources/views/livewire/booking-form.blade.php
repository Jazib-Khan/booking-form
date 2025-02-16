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
                <input type="date" wire:model="dates" class="w-full border p-2 rounded" required>
                @error('dates') <span class="text-red-500">{{ $message }}</span> @enderror
            </div>

            <div>
                <label>Number of Nights*</label>
                <input type="number" wire:model="nights" class="w-full border p-2 rounded" required>
                @error('nights') <span class="text-red-500">{{ $message }}</span> @enderror
            </div>

            <div>
                <label>Number of Rooms* (Max: 2)</label>
                <input type="number" wire:model="rooms" class="w-full border p-2 rounded" required min="1" max="2" step="1">
                @error('rooms') <span class="text-red-500">{{ $message }}</span> @enderror
            </div>

            <div>
                <label>Number of Pax* (Max: 5)</label>
                <input type="number" wire:model.live="pax" class="w-full border p-2 rounded" required>
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
