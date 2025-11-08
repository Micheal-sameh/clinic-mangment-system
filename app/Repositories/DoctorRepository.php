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
            'en' => $data['name_en']
        ];
        unset($data['name_ar'], $data['name_en']);
        return $this->model->create($data);
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
                'en' => $data['name_en']
            ];
            unset($data['name_ar'], $data['name_en']);
        }
        $doctor = $this->model->findOrFail($id);
        $doctor->update($data);
        return $doctor;
    }
}
