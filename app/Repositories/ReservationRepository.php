<?php

namespace App\Repositories;

use App\Enums\ReservationStatus;
use App\Models\Reservation;
use App\Models\WorkingDay;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReservationRepository
{

    public function __construct(protected Reservation $model)
    {

    }

    public function getAll()
    {
        return $this->model
        ->when(auth()->user()->hasRole(['patient', 'secretary']) , fn($q) => $q->where('user_id', auth()->id()))
        ->with('user')->get();
    }

    public function index($input = null)
    {
        if(auth()->user()->hasRole('admin')){
            $this->checkDate();
        }
        return $this->model->with('user')
            ->when(isset($input->today), fn($q) => $q->whereDate('date', today()))
            ->when(isset($input->history), fn($q) => $q->where('date', '<', today()))
            ->when(Auth::user()->hasRole('patient'), fn($q) => $q->where('user_id', auth()->id()))
            // ->when(!isset($input->today) && !isset($input->history), fn($q) => $q->where('date', '>=', today()))
            ->when(!isset($input->today) && !isset($input->history), fn($q) => $q->whereNotIn('status', [ReservationStatus::CANCELLED, ReservationStatus::PAID]))
            ->orderBy('date', 'asc')
            ->orderBy('reservation_number', 'asc')
            ->paginate();
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store($input)
    {
        $data = $this->model->getFromAndToFromWoringDays($input->reservation_date, $input->slate_number);

        return $this->model->create([
            'user_id' => $input->user_id ?? Auth::id(),
            'date' => $input->reservation_date,
            'reservation_number' => $input->slate_number,
            'from' => $data['from'],
            'to' => $data['to'],
        ]);

    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        return $this->model->find($id)->load('reservationNotes');
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

    public function storePrice($reservation, $total)
    {
        return $reservation->update([
            'total_price'   => $total,
            'status'        => ReservationStatus::TOPAY,
        ]);
    }

    public function paid($id)
    {
        return $this->model->find($id)->update([
            'status' => ReservationStatus::PAID,
        ]);
    }

    public function userShow($id)
    {
        return $this->model->where('user_id', $id)
        ->latest('date')
        ->take(5)
        ->get();
    }

    public function userProfile($id)
    {
        return $this->model->where('user_id', $id)
        ->where('status', ReservationStatus::WAITING)
        ->take(5)
        ->get();
    }

    public function checkDate()
    {
        $reservations = $this->model
            ->where('status', ReservationStatus::WAITING)
            ->where('date', '<', today())
            ->get();

            $reservations->each(function ($reservation) {
                $reservation->update([
                    'status' => ReservationStatus::CANCELLED,
                ]);
            });
            return true;
    }

    public function report()
    {
        $today = Carbon::today();
        $reservationsToday = $this->model->whereDate('date', $today)->count();

        return compact('reservationsToday');
    }
}
