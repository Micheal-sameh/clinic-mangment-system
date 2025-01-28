<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Reservation extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'date',
        'reservation_number',
        'total_price',
        'status',
        'paid',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function reservationProcedures()
    {
        return $this->hasMany(ReservationProcedure::class);
    }

    public function reservationNotes()
    {
        return $this->hasMany(ReservationNote::class);
    }

   // Reservation model
    public function workingDay()
    {
        return $this->belongsTo(WorkingDay::class, 'date', 'date'); // Adjust based on your foreign key and primary key
    }



    public function getReservationNumberAttribute()
    {
        // Assuming the reservation has a related working day
        $workingDay = $this->workingDay;
        if (!$workingDay) {
            return null;
        }

        $fromTime = Carbon::createFromFormat('H:i:s', $workingDay->from);
        $toTime = Carbon::createFromFormat('H:i:s', $workingDay->to);

        // Calculate the slate start and end times
        $slateStart = $fromTime->copy();
        $slateEnd = $slateStart->copy()->addMinutes(30);

        // Return slate time if within working hours
        if ($slateStart->lt($toTime)) {
            return $slateStart->format('H:i') . ' - ' . $slateEnd->format('H:i');
        }

        return null; // Slate time is outside working hours
    }

}
