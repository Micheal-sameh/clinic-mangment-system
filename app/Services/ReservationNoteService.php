<?php

namespace App\Services;

use App\Models\User;
use App\Repositories\ReservationNoteRepository;
use App\Repositories\ReservationRepository;
use Illuminate\Http\Request;

class ReservationNoteService
{
    public function __construct(
        protected ReservationNoteRepository $reservationNoteRepository,
        protected ReservationRepository $reservationRepository,
        ){

    }

    /**
     * Display a listing of the resource.
     */

    public function store($input)
    {
        foreach($input->notes as $note){
            $this->reservationNoteRepository->store($input->reservation_id, $note);
        }
        $reservation = $this->reservationRepository->show($input->reservation_id);
        $reservation->touch();

    }
}
