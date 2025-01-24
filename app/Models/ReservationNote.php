<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ReservationNote extends Model
{
    use HasFactory;

    protected $fillable = [
        'reservation_id',
        'note',
    ];
    
    public function reservation()
    {
        return $this->belongsTo(Reservation::class);
    }
}
