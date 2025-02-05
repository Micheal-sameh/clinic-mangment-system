<?php

namespace App\Rules;

use App\Enums\WorkingDayStatus;
use App\Models\WorkingDay;
use Carbon\Carbon;
use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class CheckActiveDayRule implements ValidationRule
{
    /**
     * Run the validation rule.
     *
     * @param  \Closure(string): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        $weekday = Carbon::create($value)->format('l');
        $day = WorkingDay::where('name->en', $weekday)->first();
        // dd($day, $weekday);

        if($day->status == WorkingDayStatus::INACTIVE){
            $fail(__('messages.holiday'));
        }
    }
}
