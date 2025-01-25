<?php

namespace App\Services;

use App\DTOs\ProcedureCreateDTO;
use App\Models\User;
use App\Repositories\ProcedureRepository;
use App\Repositories\WorkingDayRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class WorkingDayService
{

    public function __construct(protected WorkingDayRepository $workingDayRepository)
    {

    }

    /**
     * Display a listing of the resource.
     */
    public function index($input)
    {
        return $this->workingDayRepository->index($input);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store($input)
    {
        DB::beginTransaction();
        foreach($input->working_days as $day){
            $this->workingDayRepository->store($day);
        }
        DB::commit();
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
        // return $this->procedureRepository->delete($id);
    }

    public function slatesNumber($date)
    {
        return $this->workingDayRepository->slatesNumber($date);
    }
}
