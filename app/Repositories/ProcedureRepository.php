<?php

namespace App\Repositories;

use App\DTOs\ProcedureCreateDTO;
use App\DTOs\ProcedureUpdateDTO;
use App\Models\Procedure;

class ProcedureRepository extends BaseRepository
{
    public function __construct(Procedure $model)
    {
        parent::__construct($model);
    }

    /**
     * Display a listing of the resource.
     */
    public function index($input)
    {
        $locale = app()->getLocale();

        return $this->query()
            ->when(isset($input->name), fn ($q) => $q->where('name', 'like', '%'.$input->name.'%'))
            ->orderByRaw("JSON_UNQUOTE(JSON_EXTRACT(name, '$.$locale')) ASC")  // Sort by localized name (e.g., name.en or name.ar)
            ->paginate();
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ProcedureCreateDTO $input)
    {
        return $this->create([
            'name' => ['en' => $input->name_en, 'ar' => $input->name_ar],
            'description' => ['en' => $input->description_en, 'ar' => $input->description_ar],
            'price' => $input->price,
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        return $this->findById($id);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        return $this->findById($id);
    }

    /**
     * Update the specified resource in storage.
     */
    public function updateData($id, ProcedureUpdateDTO $input)
    {
        return $this->update($id, [
            'name' => ['en' => $input->name_en, 'ar' => $input->name_ar],
            'description' => ['en' => $input->description_en, 'ar' => $input->description_ar],
            'price' => $input->price,
        ]);
    }
}
