<?php

namespace App\Repositories;

use App\Models\ReservationNote;

class ReservationNoteRepository extends BaseRepository
{
    public function __construct(ReservationNote $model)
    {
        parent::__construct($model);
    }

    public function store($reservation_id, $note)
    {
        $this->create([
            'reservation_id' => $reservation_id,
            'note' => $note,
        ]);
    }
}
