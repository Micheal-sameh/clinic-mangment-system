<?php

namespace App\Repositories;

use App\Enums\ReservationStatus;
use App\Enums\WorkingDayStatus;
use App\Models\Reservation;
use App\Models\WorkingDay;
use Carbon\Carbon;

class WorkingDayRepository extends BaseRepository
{
    public function __construct(WorkingDay $model)
    {
        parent::__construct($model);
    }

    /**
     * Display a listing of the resource.
     */
    public function index($input)
    {
        return $this->model->with('doctor')->get();
    }

    /**
     * Display a listing of working days for a specific doctor.
     */
    public function indexByDoctor($doctorId)
    {
        return $this->model->where('doctor_id', $doctorId)->get()->append(['doctorId']);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store($day)
    {
        return $this->model->create([
            'date' => $day['date'],
            'from' => $day['from'],
            'to' => $day['to'],
        ]);
    }

    public function update($key, $day)
    {
        $worlingDay = $this->model->find($key);
        $worlingDay->update([
            'from' => $day['from'],
            'to' => $day['to'],
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
    public function active($id)
    {
        $day = $this->findById($id);
        $day->status == WorkingDayStatus::ACTIVE
        ? $day->status = WorkingDayStatus::INACTIVE
        : $day->status = WorkingDayStatus::ACTIVE;
        $day->save();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function delete($id)
    {
        return parent::delete($id);
    }

    public function slatesNumber($date, $doctorId = null)
    {
        $weekday = Carbon::create($date)->format('l');

        $query = $this->query()->where('name->'.'en', $weekday);

        if ($doctorId) {
            $query->where('doctor_id', $doctorId);
        }

        $day = $query->first();

        if (! $day) {
            return [];
        }

        $startTime = Carbon::createFromFormat('H:i:s', $day->from);
        $endTime = Carbon::createFromFormat('H:i:s', $day->to);
        $slateIntervals = [];

        // Get reserved intervals more efficiently using pluck, filtered by doctor_id if provided
        $reservedQuery = Reservation::where('date', $date)
            ->where('status', '!=', ReservationStatus::CANCELLED);

        if ($doctorId) {
            $reservedQuery->where('doctor_id', $doctorId);
        }

        $reservedIntervals = $reservedQuery->pluck('reservation_number')->toArray();

        while ($startTime->lt($endTime)) {
            $slateEnd = $startTime->copy()->addMinutes(30);

            if ($slateEnd->gt($endTime)) {
                $slateEnd = $endTime;
            }

            $slateIntervals[] = $startTime->format('H:i').' - '.$slateEnd->format('H:i');
            $startTime = $slateEnd;
        }

        // Mark reserved slots
        foreach ($reservedIntervals as $interval) {
            if (isset($slateIntervals[$interval - 1])) {
                $slateIntervals[$interval - 1] = 'Reserved';
            }
        }

        return $slateIntervals;
    }
}
