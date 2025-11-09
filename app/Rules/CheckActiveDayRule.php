<?php

namespace App\Rules;

use App\Enums\WorkingDayStatus;
use App\Models\WorkingDay;
use Carbon\Carbon;
use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class CheckActiveDayRule implements ValidationRule
{
    protected $doctorId;

    public function __construct($doctorId = null)
    {
        $this->doctorId = $doctorId;
    }

    /**
     * Run the validation rule.
     *
     * @param  \Closure(string): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        $weekday = Carbon::create($value)->format('l');
        $query = WorkingDay::where('name->en', $weekday);

        if ($this->doctorId) {
            $query->where('doctor_id', $this->doctorId);
        }

        $day = $query->first();

        if (! $day || $day->status == WorkingDayStatus::INACTIVE) {
            $fail(__('messages.holiday'));
        }
    }
}
