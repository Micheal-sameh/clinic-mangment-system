<?php

namespace App\Repositories;

use App\DTOs\ProcedureCreateDTO;
use App\DTOs\ProcedureUpdateDTO;
use App\Models\Procedure;

class ProcedureRepository
{
    public function __construct(protected Procedure $model) {}

    /**
     * Display a listing of the resource.
     */
    public function index($input)
    {
        $locale = app()->getLocale();

        return $this->model
            ->when(isset($input->name), fn ($q) => $q->where('name', 'like', '%'.$input->name.'%'))
            ->orderByRaw("JSON_UNQUOTE(JSON_EXTRACT(name, '$.$locale')) ASC")  // Sort by localized name (e.g., name.en or name.ar)
            ->paginate();
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ProcedureCreateDTO $input)
    {
        $p = $this->model->create([
            'name' => ['en' => $input->name_en, 'ar' => $input->name_ar],
            'description' => ['en' => $input->description_en, 'ar' => $input->description_ar],
            'price' => $input->price,
        ]);

        return $p;

    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $procedure = $this->model->find($id);

        return $procedure;
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        return $this->model->find($id);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update($id, ProcedureUpdateDTO $input)
    {
        $procedure = $this->model->find($id);
        $procedure->update([
            'name' => ['en' => $input->name_en, 'ar' => $input->name_ar],
            'description' => ['en' => $input->description_en, 'ar' => $input->description_ar],
            'price' => $input->price,
        ]);

        return $procedure;
    }

    /**
     * Remove the specified resource from storage.
     */
    public function delete($id)
    {
        return $this->model->find($id)->delete();
    }
}
