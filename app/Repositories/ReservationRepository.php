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
        if (! isset($input['date_from'])) {
            $input['date_from'] = null;
        }
        if (! isset($input['date_to'])) {
            $input['date_to'] = null;
        }

        return $this->query()->with('user:id,name,phone') // Eager load with specific columns
            ->when(isset($input['today']), fn ($q) => $q->whereDate('date', today()))
            ->when(isset($input['history']), fn ($q) => $q->where('date', '<', today()))
            ->when(isset($input['date_from']) && isset($input['date_to']), fn ($q) => $q->whereBetween('date', [$input['date_from'], $input['date_to']]))
            ->when(isset($input['date_from']) && ! isset($input['date_to']), fn ($q) => $q->whereDate('date', '>=', $input['date_from']))
            ->when(! isset($input['date_from']) && isset($input['date_to']), fn ($q) => $q->whereDate('date', '<=', $input['date_to']))
            ->when(isset($input['search']), fn ($q) => $q->whereHas('user', function ($query) use ($input) {
                $query->where('name', 'like', '%'.$input['search'].'%')
                    ->orWhere('phone', 'like', '%'.$input['search'].'%');
            }))
            ->when(Auth::user()->hasRole('patient'), fn ($q) => $q->where('user_id', auth()->id()))
            ->when(! isset($input['today']) && ! isset($input['history']), fn ($q) => $q->whereNotIn('status', [ReservationStatus::CANCELLED, ReservationStatus::PAID]))
            ->orderBy('date', 'asc')
            ->orderBy('reservation_number', 'asc')
            ->paginate(15);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store($input)
    {
        $data = $this->model->getFromAndToFromWoringDays($input['reservation_date'], $input['slate_number']);

        return $this->create([
            'user_id' => $input['user_id'] ?? Auth::id(),
            'date' => $input['reservation_date'],
            'reservation_number' => $input['slate_number'],
            'from' => $data['from'],
            'to' => $data['to'],
            'doctor_id' => $input['doctor_id'],
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

    public function getUserTotals($user, $status, $upcoming = false)
    {
        $field = $user->isDoctor() ? 'doctor_id' : 'user_id';
        $value = $user->isDoctor() ? $user->doctor->id : $user->id;

        return $this->query()
            ->where($field, $value)
            ->where('status', $status)
            ->when($upcoming, fn ($q) => $q->whereDate('date', '>=', today()))
            ->count();
    }

    public function getAvailableSlatesForDate($date, $excludeReservationNumber = null)
    {
        $weekday = Carbon::create($date)->format('l');

        $day = $this->query()->where('name->'.'en', $weekday)->first();

        if (! $day) {
            return [];
        }

        $startTime = Carbon::createFromFormat('H:i:s', $day->from);
        $endTime = Carbon::createFromFormat('H:i:s', $day->to);
        $slateIntervals = [];

        // Get reserved intervals more efficiently using pluck, excluding the current reservation if provided
        $reservedIntervals = Reservation::where('date', $date)
            ->where('status', '!=', ReservationStatus::CANCELLED)
            ->when($excludeReservationNumber, fn ($q) => $q->where('reservation_number', '!=', $excludeReservationNumber))
            ->pluck('reservation_number')
            ->toArray();

        $index = 1;
        while ($startTime->lt($endTime)) {
            $slateEnd = $startTime->copy()->addMinutes(30);

            if ($slateEnd->gt($endTime)) {
                $slateEnd = $endTime;
            }

            if (! in_array($index, $reservedIntervals)) {
                $slateIntervals[$index] = $startTime->format('H:i').' - '.$slateEnd->format('H:i');
            }

            $startTime = $slateEnd;
            $index++;
        }

        return $slateIntervals;
    }
}
