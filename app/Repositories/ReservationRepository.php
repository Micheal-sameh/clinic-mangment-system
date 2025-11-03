<?php

namespace App\Repositories;

use App\Enums\ReservationStatus;
use App\Models\Reservation;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class ReservationRepository extends BaseRepository
{
    public function __construct(Reservation $model)
    {
        parent::__construct($model);
    }

    public function getAll()
    {
        return $this->model
            ->when(auth()->user()->hasRole(['patient', 'secretary']), fn ($q) => $q->where('user_id', auth()->id()))
            ->with('user')->get();
    }

    public function index($input = null)
    {
        if (auth()->user()->hasRole('admin')) {
            $this->checkDate();
        }

        return $this->query()->with('user:id,name,phone') // Eager load with specific columns
            ->when(isset($input->today), fn ($q) => $q->whereDate('date', today()))
            ->when(isset($input->history), fn ($q) => $q->where('date', '<', today()))
            ->when(Auth::user()->hasRole('patient'), fn ($q) => $q->where('user_id', auth()->id()))
            ->when(! isset($input->today) && ! isset($input->history), fn ($q) => $q->whereNotIn('status', [ReservationStatus::CANCELLED, ReservationStatus::PAID]))
            ->orderBy('date', 'asc')
            ->orderBy('reservation_number', 'asc')
            ->paginate(15);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store($input)
    {
        $data = $this->model->getFromAndToFromWoringDays($input->reservation_date, $input->slate_number);

        return $this->create([
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
        return $this->findById($id)->load('reservationNotes');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit()
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function delete($id)
    {
        $reservation = $this->findById($id);

        return $reservation->update([
            'status' => ReservationStatus::CANCELLED,
        ]);
    }

    public function storePrice($reservation, $total)
    {
        return $reservation->update([
            'total_price' => $total,
            'status' => ReservationStatus::TOPAY,
        ]);
    }

    public function paid($id)
    {
        $reservation = $this->findById($id);

        return $reservation->update([
            'status' => ReservationStatus::PAID,
        ]);
    }

    public function userShow($id)
    {
        return $this->query()->where('user_id', $id)
            ->latest('date')
            ->take(5)
            ->get();
    }

    public function userProfile($id)
    {
        return $this->query()->where('user_id', $id)
            ->where('status', ReservationStatus::WAITING)
            ->take(5)
            ->get();
    }

    public function checkDate()
    {
        // Use bulk update instead of individual updates in a loop
        $this->query()
            ->where('status', ReservationStatus::WAITING)
            ->where('date', '<', today())
            ->update(['status' => ReservationStatus::CANCELLED]);

        return true;
    }

    public function report()
    {
        $today = Carbon::today();
        $reservationsToday = $this->query()->whereDate('date', $today)->count();

        return compact('reservationsToday');
    }

    public function getUserTotals($id, $status, $upcoming = false)
    {
        return $this->query()
            ->where('user_id', $id)
            ->where('status', $status)
            ->when($upcoming, fn ($q) => $q->whereDate('date', '>=', today()))
            ->count();
    }
}
