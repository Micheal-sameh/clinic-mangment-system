<?php

namespace App\Services;

use App\DTOs\ProcedureCreateDTO;
use App\DTOs\ProcedureUpdateDTO;
use App\Repositories\ProcedureRepository;

class ProcedureService
{
    public function __construct(protected ProcedureRepository $procedureRepository) {}

    /**
     * Display a listing of the resource.
     */
    public function index($input)
    {
        return $this->procedureRepository->index($input);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ProcedureCreateDTO $input)
    {
        return $this->procedureRepository->store($input);
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        return $this->procedureRepository->show($id);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        return $this->procedureRepository->show($id);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update($id, ProcedureUpdateDTO $input)
    {
        return $this->procedureRepository->update($id, $input);
    }

    public function delete($id)
    {
        return $this->procedureRepository->delete($id);
    }
}
