<?php

namespace App\Repositories;

use App\Enums\ReservationStatus;
use App\Models\Reservation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReservationRepository
{

    public function __construct(protected Reservation $model)
    {

    }
    /**
     * Display a listing of the resource.
     */
    public function index($input)
    {
        // dd($input);
        return $this->model
            ->with('user')
            ->when(isset($input->today), fn($q) => $q->where('date', today()))
            ->where('date', '>=', today())
            ->orderBy('date')
            ->get();
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store($input)
    {
        return $this->model->create([
            'user_id' => $input->user_id ?? Auth::id(),
            'date' => $input->reservation_date,
            'reservation_number' => $input->slate_number,
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
        return $this->model->find($id)->update([
            'status'    => ReservationStatus::CANCELLED,
        ]);
    }

    public function storePrice($reservation, $totalprice)
    {
        return $reservation->update([
            'total_price'   => $totalprice,
            'status'        => ReservationStatus::TOPAY,
        ]);
    }

    public function paid($id)
    {
        return $this->model->find($id)->update([
            'status'        => ReservationStatus::DONE,
        ]);
    }

    public function history()
    {
        return $this->model->where('date', '<=', today())->get();
    }
}
