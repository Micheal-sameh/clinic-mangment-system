<?php

namespace App\Services;

use App\Repositories\ReservationRepository;
use App\Repositories\UserRepository;

class ReservationService
{
    public function __construct(
        protected ReservationRepository $reservationRepository,
        protected UserRepository $userRepository,
        protected WorkingDayService $workingDayService
    ) {}

    /**
     * Display a listing of the resource.
     */
    public function index($input)
    {
        return $this->reservationRepository->index($input);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store($input)
    {
        return $this->reservationRepository->store($input);
    }

    public function create()
    {
        $users = $this->userRepository->patients();

        return compact('users');
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        return $this->reservationRepository->show($id);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($reservation)
    {
        $allSlates = $this->workingDayService->slatesNumber($reservation->date);
        $availableSlates = [];

        foreach ($allSlates as $index => $slate) {
            if ($slate !== 'Reserved' || $index + 1 == $reservation->reservation_number) {
                $availableSlates[$index + 1] = $slate;
            }
        }

        return compact('availableSlates');
    }

    /**
     * Update the specified resource in storage.
     */
    public function updateTimeSlot($input, $reservation)
    {
        // Get all slates for the date
        $allSlates = $this->workingDayService->slatesNumber($reservation->date);

        // Check if the selected slate is available (not reserved by another reservation)
        $selectedIndex = $input['slate_number'] - 1;
        if (! isset($allSlates[$selectedIndex]) || ($allSlates[$selectedIndex] === 'Reserved' && $input['slate_number'] != $reservation->reservation_number)) {
            throw new \Exception('Selected time slot is not available.');
        }

        // Update the reservation with new time slot
        $data = $reservation->getFromAndToFromWoringDays($reservation->date, $input['slate_number']);

        $reservation->update([
            'reservation_number' => $input['slate_number'],
            'from' => $data['from'],
            'to' => $data['to'],
        ]);

        return $reservation;
    }

    public function delete($id)
    {
        return $this->reservationRepository->delete($id);
    }

    public function report()
    {
        return $this->reservationRepository->report();
    }
}
