<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    use HasFactory;

    protected $fillable = [
        'hotel_id',
        'room_type_id',
        'check_in',
        'check_out',
        'nights',
        'rooms',
        'pax',
        'notes',
        'total_cost'
    ];

    public function hotel() {
        return $this->belongsTo(Hotel::class);
    }

    public function roomType() {
        return $this->belongsTo(RoomType::class);
    }
}
