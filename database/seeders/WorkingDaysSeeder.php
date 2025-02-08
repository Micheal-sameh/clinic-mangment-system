<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Enums\WorkingDayStatus;
use App\Models\User;
use App\Models\WorkingDay;
use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

class WorkingDaysSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        WorkingDay::create([
            'name' => [
                'en' => 'Sunday',
                'ar' => 'الأحد',
            ],
            'from'      => '10:00:00',
            'to'        => '10:00:00',
            'status'    => WorkingDayStatus::INACTIVE,
        ]);
        WorkingDay::create([
            'name' => [
                'en' => 'Monday',
                'ar' => 'الاثنين',
            ],
            'from'      => '10:00:00',
            'to'        => '10:00:00',
            'status'    => WorkingDayStatus::INACTIVE,
        ]);
        WorkingDay::create([
            'name' => [
                'en' => 'Tuesday',
                'ar' => 'الثلاثاء',
            ],
            'from'      => '10:00:00',
            'to'        => '10:00:00',
            'status'    => WorkingDayStatus::INACTIVE,
        ]);
        WorkingDay::create([
            'name' => [
                'en' => 'Wednesday',
                'ar' => 'الأربعاء',
            ],
            'from'      => '10:00:00',
            'to'        => '10:00:00',
            'status'    => WorkingDayStatus::INACTIVE,
        ]);
        WorkingDay::create([
            'name' => [
                'en' => 'Thursday',
                'ar' => 'الخميس',
            ],
            'from'      => '10:00:00',
            'to'        => '10:00:00',
            'status'    => WorkingDayStatus::INACTIVE,
        ]);
        WorkingDay::create([
            'name' => [
                'en' => 'Friday',
                'ar' => 'الجمعة',
            ],
            'from'      => '10:00:00',
            'to'        => '10:00:00',
            'status'    => WorkingDayStatus::INACTIVE,
        ]);
        WorkingDay::create([
            'name' => [
                'en' => 'Saturday',
                'ar' => 'السبت',
            ],
            'from'      => '10:00:00',
            'to'        => '10:00:00',
            'status'    => WorkingDayStatus::INACTIVE,
        ]);
    }
}
