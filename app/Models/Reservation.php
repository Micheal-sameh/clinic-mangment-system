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

    public function getReservationNumberAttribute($value)
    {
        $weekday = Carbon::create($this->date)->format('l');
        $day = workingDay::where('name->en', $weekday)->first();

        $fromTime = Carbon::createFromFormat('H:i:s', $day->from);
        $toTime = Carbon::createFromFormat('H:i:s', $day->to);

        $slateStart = $fromTime->copy();
        $slateEnd = $slateStart->copy()->addMinutes(30);

        if ($slateStart->lt($toTime)) {
            return $slateStart->format('H:i') . ' - ' . $slateEnd->format('H:i');
        }

        return null;
    }
}
