<?php

namespace Database\Seeders;

use App\Enums\WorkingDayStatus;
use App\Models\Doctor;
use App\Models\WorkingDay;
use Illuminate\Database\Seeder;

class WorkingDaysSeeder extends Seeder
{
    public function run(): void
    {
        $doctor = Doctor::create([
            'name'           => ['en' => 'Doctor', 'ar' => 'دكتور'],
            'specialization' => 'General',
            'phone'          => '01000000000',
            'whatsapp'       => '01000000000',
            'age'            => 35,
        ]);

        $days = [
            ['en' => 'Sunday',    'ar' => 'الأحد'],
            ['en' => 'Monday',    'ar' => 'الاثنين'],
            ['en' => 'Tuesday',   'ar' => 'الثلاثاء'],
            ['en' => 'Wednesday', 'ar' => 'الأربعاء'],
            ['en' => 'Thursday',  'ar' => 'الخميس'],
            ['en' => 'Friday',    'ar' => 'الجمعة'],
            ['en' => 'Saturday',  'ar' => 'السبت'],
        ];

        foreach ($days as $day) {
            WorkingDay::create([
                'name'      => $day,
                'from'      => '10:00:00',
                'to'        => '18:00:00',
                'status'    => WorkingDayStatus::INACTIVE,
                'doctor_id' => $doctor->id,
            ]);
        }
    }
}
