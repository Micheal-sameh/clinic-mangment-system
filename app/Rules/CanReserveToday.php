<?php

namespace App\Rules;

use App\Models\Reservation;
use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class CanReserveToday implements ValidationRule
{
    /**
     * Run the validation rule.
     *
     * @param  \Closure(string): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */

    public function __construct(protected $reservation_date)
    {

    }

    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        $reservations = Reservation::where('date', $this->reservation_date)
        ->where('user_id', $value)
        ->get();

        if ($reservations->count() >= 1) {
            $fail(__('messages.You can only reserve one time today'));
        }
    }
}
