<?php

namespace App\Repositories;

use App\Models\ReservationProcedure;
use Illuminate\Support\Facades\Auth;

class ReservationProcedureRepository
{

    public function __construct(protected ReservationProcedure $model)
    {

    }
    /**
     * Display a listing of the resource.
     */
    public function index($input)
    {
        return $this->model
            ->with('user')
            ->where('date', '>=', today())
            ->orderBy('date')
            ->get();
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store($reservation, $procedure)
    {
        return $this->model->create([
            'reservation_id' => $reservation->id,
            'procedure_id' => $procedure->id,
            'price' => $procedure->price,
        ]);

    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        return $this->model->find($id);
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
