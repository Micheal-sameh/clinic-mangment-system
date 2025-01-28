<?php

namespace App\Rules;

use App\Models\WorkingDay;
use Carbon\Carbon;
use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class CheckDate implements ValidationRule
{
    public function __construct(protected $working_days)
    {

    }
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {

        foreach($this->working_days as $day){
            if($day['date'] < today()){
                $fail('Invalid date');
            }


            if($day['from'] > $day['to']){
                $fail('Invalid date');
            }
            $work = WorkingDay::where('date', $day['date'])->first();
            if($work){
                $fail('Date is already booked');
            }

            $fromTime = Carbon::createFromFormat('H:i', $day['from']);
            $toTime = carbon::createFromFormat('H:i', $day['to']);

            // Calculate the difference between the two times
            $minutesDiff = $fromTime->diffInMinutes($toTime);
            if($minutesDiff / 30 < 1){
                $fail('interval must be 30 minutes');
            }
        }
    }
}
