<?php

namespace App\Repositories;

use App\Models\ReservationProcedure;
use Carbon\Carbon;

class ReservationProcedureRepository extends BaseRepository
{
    public function __construct(ReservationProcedure $model)
    {
        parent::__construct($model);
    }

    /**
     * Display a listing of the resource.
     */
    public function index($input)
    {
        return $this->query()
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
        return $this->create([
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
        return $this->findById($id);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit()
    {
        //
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

    public function getPrice($reservation_id)
    {
        return $this->model->where('reservation_id', $reservation_id)->sum('price');
    }
}
