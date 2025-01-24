<?php

namespace App\Repositories;

use App\DTOs\ProcedureCreateDTO;
use App\Models\Procedure;
use Illuminate\Http\Request;

class ProcedureRepository
{

    public function __construct(protected Procedure $model)
    {

    }
    /**
     * Display a listing of the resource.
     */
    public function index($input)
    {
        $locale = app()->getLocale();
        $procedures = $this->model
        ->when(isset($input->name), fn($q) => $q->where('name', 'like', '%' . $input->name . '%'))
        ->orderByRaw("JSON_UNQUOTE(JSON_EXTRACT(name, '$.$locale')) ASC")  // Sort by localized name (e.g., name.en or name.ar)
            ->get();

        return $procedures;
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ProcedureCreateDTO $input)
    {
        $p = $this->model->create([
            'name'  =>['en' => $input->name_en, 'ar' => $input->name_ar],
            'description'  =>['en' => $input->description_en, 'ar' => $input->description_ar],
            'price'  => $input->price,
        ]);

        return $p;

    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $user = $this->model->find($id);

        return $user;
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit()
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update()
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function delete($id)
    {
        return $this->model->find($id)->delete();
    }
}
