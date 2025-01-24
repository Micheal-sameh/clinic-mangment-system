<?php

namespace App\Http\Controllers;

use App\Repositories\ReservationRepository;
use App\Services\ReservationNoteService;
use Illuminate\Http\Request;

class ReservationNoteController extends Controller
{

    public function __construct(
        protected ReservationRepository $reservationRepository,
        protected ReservationNoteService $reservationNoteService
        ){
            $this->middleware('permission:reservations_notes', ['only' => ['store']]);

        }

    public function store(Request $request)
    {
        $this->reservationNoteService->store($request);
        return redirect()->back()->with('success', 'Notes added successfully!');
    }
}
