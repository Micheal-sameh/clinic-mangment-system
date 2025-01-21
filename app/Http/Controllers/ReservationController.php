<?php

namespace App\Http\Controllers;

use App\Http\Requests\ReservationRequest;
use App\Models\Reservation;
use App\Services\ReservationService;
use Illuminate\Http\Request;

class ReservationController extends Controller
{
    public function __construct(protected ReservationService $reservationService)
    {

    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $input = 1;
        $reservations = $this->reservationService->index($input);

        return view('reservations.index', compact('reservations'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $data = $this->reservationService->create();
        return view('reservations.create', ['users' => $data['users']]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ReservationRequest $request)
    {
        $this->reservationService->store($request);

        return redirect()->route('reservations.create')->with('success', 'Reservation created successfully!');
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $reservation = $this->reservationService->show($id);

        return view('reservations.show', compact('reservation'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Reservation $reservation)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Reservation $reservation)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Reservation $reservation)
    {
        //
    }
}
