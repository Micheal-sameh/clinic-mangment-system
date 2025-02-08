<?php

namespace App\Http\Controllers;

use App\Models\ReservationProcedure;
use App\Services\ProcedureService;
use App\Services\ReservationProcedureService;
use App\Services\ReservationService;
use Illuminate\Http\Request;

class ReservationProcedureController extends Controller
{
    public function __construct(
        protected ReservationProcedureService $reservationProcedureService,
        ){
        $this->middleware('permission:reservations_apply', ['only' => ['store']]);
    }

    public function store(Request $request)
    {
        $this->reservationProcedureService->store($request);

        return to_route('reservations.applyPage', ['id' => $request->reservation_id])
            ->with('success', 'Procedure created successfully');
    }
}
