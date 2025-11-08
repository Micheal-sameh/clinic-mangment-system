<?php

namespace App\Repositories;

use App\Models\Doctor;

class DoctorRepository extends BaseRepository
{
    public function __construct(Doctor $model)
    {
        parent::__construct($model);
    }

    public function index()
    {
        return $this->model->paginate(10);
    }

    public function store(array $data)
    {
        $data['name'] = [
            'ar' => $data['name_ar'],
            'en' => $data['name_en'],
        ];
        unset($data['name_ar'], $data['name_en']);
        $doctor = $this->model->create($data);

        // Create default working days for the doctor
        $workingDays = [
            ['name' => ['en' => 'Sunday', 'ar' => 'الأحد'], 'from' => '10:00:00', 'to' => '18:00:00', 'status' => 2],
            ['name' => ['en' => 'Monday', 'ar' => 'الاثنين'], 'from' => '10:00:00', 'to' => '18:00:00', 'status' => 2],
            ['name' => ['en' => 'Tuesday', 'ar' => 'الثلاثاء'], 'from' => '10:00:00', 'to' => '18:00:00', 'status' => 2],
            ['name' => ['en' => 'Wednesday', 'ar' => 'الأربعاء'], 'from' => '10:00:00', 'to' => '18:00:00', 'status' => 2],
            ['name' => ['en' => 'Thursday', 'ar' => 'الخميس'], 'from' => '10:00:00', 'to' => '18:00:00', 'status' => 2],
            ['name' => ['en' => 'Friday', 'ar' => 'الجمعة'], 'from' => '10:00:00', 'to' => '18:00:00', 'status' => 2],
            ['name' => ['en' => 'Saturday', 'ar' => 'السبت'], 'from' => '10:00:00', 'to' => '18:00:00', 'status' => 2],
        ];

        foreach ($workingDays as $day) {
            $doctor->workingDays()->create($day);
        }

        return $doctor;
    }

    public function show($id)
    {
        return $this->model->with('reservations')->findOrFail($id);
    }

    public function update($id, array $data)
    {
        if (isset($data['name_ar']) && isset($data['name_en'])) {
            $data['name'] = [
                'ar' => $data['name_ar'],
                'en' => $data['name_en'],
            ];
            unset($data['name_ar'], $data['name_en']);
        }
        $doctor = $this->model->findOrFail($id);
        $doctor->update($data);

        return $doctor;
    }
}
