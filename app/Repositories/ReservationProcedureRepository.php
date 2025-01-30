<?php

namespace App\Repositories;

use App\Models\ReservationProcedure;
use Carbon\Carbon;
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

    public function report()
    {
        $today = Carbon::today();
        $incomeThisMonth = $this->model->whereMonth('created_at', '=', $today->month)
            ->whereYear('created_at', '=', $today->year)
            ->sum('price');

        $incomeAllTime = $this->model->sum('price');
        $incomeToday = $this->model->whereDate('created_at', $today)->sum('price');
        $incomeLastMonth = $this->model->whereMonth('created_at', '=', today()->subMonth()->month)
            ->whereYear('created_at', '=', $today->year)
            ->sum('price');

        return compact('incomeThisMonth', 'incomeAllTime', 'incomeToday', 'incomeLastMonth');
    }
}
