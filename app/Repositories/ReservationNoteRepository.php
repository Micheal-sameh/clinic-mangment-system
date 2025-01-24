<?php

namespace App\Repositories;

use App\Enums\ReservationStatus;
use App\Models\Reservation;
use App\Models\ReservationNote;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReservationNoteRepository
{

    public function __construct(protected ReservationNote $model)
    {

    }

    public function store($reservation_id, $note)
    {
        $this->model->create([
            'reservation_id'    => $reservation_id,
            'note'              => $note,
        ]);
    }
}
