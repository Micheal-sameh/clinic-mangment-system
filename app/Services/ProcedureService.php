<?php

namespace App\Services;

use App\DTOs\ProcedureCreateDTO;
use App\Models\User;
use App\Repositories\ProcedureRepository;
use Illuminate\Http\Request;

class ProcedureService
{

    public function __construct(protected ProcedureRepository $procedureRepository)
    {

    }

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
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(User $user)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, User $user)
    {
        //
    }

    public function delete($id)
    {
        return $this->procedureRepository->delete($id);
    }
}
