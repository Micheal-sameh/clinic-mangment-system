<?php

namespace App\Repositories;

use App\DTOs\ProcedureCreateDTO;
use App\Enums\WorkingDayStatus;
use App\Models\Procedure;
use App\Models\Reservation;
use App\Models\WorkingDay;
use Carbon\Carbon;
use Illuminate\Http\Request;

class WorkingDayRepository
{

    public function __construct(protected WorkingDay $model)
    {

    }
    /**
     * Display a listing of the resource.
     */
    public function index($input)
    {
        return $this->model->get();
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store($day)
    {
       return $this->model->create([
            'date'  => $day['date'],
            'from'  => $day['from'],
            'to'    => $day['to'],
        ]);
    }

    public function update($key, $day)
    {
        $worlingDay = $this->model->find($key);
        $worlingDay->update([
            'from'  => $day['from'],
            'to'    => $day['to'],
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $user = $this->model->find($id);

        return $user;
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function active($id)
    {
        $day = $this->model->find($id);
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
        return $this->model->find($id)->delete();
    }

    public function slatesNumber($date)
    {
        $weekday = Carbon::create($date)->format('l');

        $day = $this->model->where('name->' . 'en', $weekday)->first();

        $startTime = Carbon::createFromFormat('H:i:s', $day->from);
        $endTime = Carbon::createFromFormat('H:i:s', $day->to);
        $slateIntervals = [];

        $reservations = Reservation::where('date', $date)->get();
        $reservedIntervals = [];

        foreach ($reservations as $reservation) {
            $reservedIntervals[] = $reservation->reservation_number;
        }

        while ($startTime->lt($endTime)) {
            $slateEnd = $startTime->copy()->addMinutes(30);

            if ($slateEnd->gt($endTime)) {
                $slateEnd = $endTime;
            }

            $slateIntervals[] = $startTime->format('H:i') . ' - ' . $slateEnd->format('H:i');
            $startTime = $slateEnd;
        }

        foreach($reservedIntervals as $interval){
            $slateIntervals[$interval-1] = 'Reserved';
        }

        return $slateIntervals;
    }
}
