<?php

namespace App\Repositories;

use App\DTOs\ProcedureCreateDTO;
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
    public function index()
    {

        return $this->model
        // ->when(isset($input->name), fn($q) => $q->where('name', 'like', '%' . $input->name . '%'))
        // ->orderByRaw("JSON_UNQUOTE(JSON_EXTRACT(name, '$.$locale')) ASC")  // Sort by localized name (e.g., name.en or name.ar)
            ->get();

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

    public function slatesNumber($date)
{
    // Fetch the day data
    $day = $this->model->where('date', $date)->first();

    // Parse start and end times
    $startTime = Carbon::createFromFormat('H:i:s', $day->from);
    $endTime = Carbon::createFromFormat('H:i:s', $day->to);

    // Initialize an array to store slate intervals
    $slateIntervals = [];

    // Fetch existing reservations for the selected date
    $reservations = Reservation::where('date', $date)->get();
    // Initialize an array to hold reserved intervals (in the format of 'H:i - H:i')
    $reservedIntervals = [];

    // Loop through the reservations and extract the reserved time intervals
    foreach ($reservations as $reservation) {
        $reservedIntervals[] = $reservation->reservation_number;  // assuming you store the slate number (1, 2, 3, etc.)
    }

    // Loop through the time period in 30-minute increments
    while ($startTime->lt($endTime)) {
        // Define the end of the current slate interval (30 minutes after start)
        $slateEnd = $startTime->copy()->addMinutes(30);

        // Ensure we don't go beyond the actual end time
        if ($slateEnd->gt($endTime)) {
            $slateEnd = $endTime;
        }

        // Format the times as 'H:i' (e.g., 4:00, 4:30)
        $slateIntervals[] = $startTime->format('H:i') . ' - ' . $slateEnd->format('H:i');
        // Check if this slate interval is already reserved


        // Move to the next slate by adding 30 minutes
        $startTime = $slateEnd;
    }
    foreach($reservedIntervals as $interval){
       $slateIntervals[$interval-1] = 'Reserved';
    }

    // Return the array of available slate intervals
    return $slateIntervals;
}

}
