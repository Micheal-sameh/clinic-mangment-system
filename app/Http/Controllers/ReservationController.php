<?php

namespace App\Http\Controllers;

use App\Enums\ReservationStatus;
use App\Http\Requests\ReservationIndexRequest;
use App\Http\Requests\ReservationRequest;
use App\Http\Requests\ReservationUpdateRequest;
use App\Models\Reservation;
use App\Repositories\ReservationRepository;
use App\Services\ProcedureService;
use App\Services\ReservationService;

class ReservationController extends Controller
{
    public function __construct(
        protected ReservationService $reservationService,
        protected ReservationRepository $reservationRepository,
        protected ProcedureService $procedureService
    ) {
        $this->middleware('permission:reservations_list', ['only' => ['index', 'show']]);
        $this->middleware('permission:reservations_create', ['only' => ['create', 'store']]);
        $this->middleware('permission:reservations_edit', ['only' => ['edit', 'update']]);
        $this->middleware('permission:reservations_apply', ['only' => ['applyPage']]);
        $this->middleware('permission:reservations_paid', ['only' => ['paid']]);
        $this->middleware('permission:reservations_history', ['only' => ['history']]);

    }

    /**
     * Display a listing of the resource.
     */
    public function index(ReservationIndexRequest $request)
    {
        // dd($request->validated());
        $reservations = $this->reservationService->index($request->validated());

        return view('reservations.index', compact('reservations'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $data = $this->reservationService->create();

        return view('reservations.create', ['users' => $data['users'], 'doctors' => $data['doctors']]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ReservationRequest $request)
    {
        $this->reservationService->store($request->validated());

        return redirect()->route('reservations.index')->with('success', 'Reservation created successfully!');
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $reservation = $this->reservationService->show($id);
        $procedures = $reservation->reservationProcedures()->get();

        return view('reservations.show', compact('reservation', 'procedures'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $reservation = $this->reservationService->show($id);
        // Only allow editing if user owns the reservation and it's in waiting status
        if ($reservation->user_id !== auth()->id() && ! auth()->user()->hasRole(['admin', 'secretary']) && $reservation->status !== \App\Enums\ReservationStatus::WAITING) {
            abort(403, 'You can only edit your own pending reservations.');
        }

        $data = $this->reservationService->edit($reservation);

        return view('reservations.edit', compact('reservation', 'data'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(ReservationUpdateRequest $request, $id)
    {
        $reservation = $this->reservationService->show($id);
        // Only allow updating if user owns the reservation and it's in waiting status
        if ($reservation->user_id !== auth()->id() && ! auth()->user()->hasRole(['admin', 'secretary']) && $reservation->status !== \App\Enums\ReservationStatus::WAITING) {
            abort(403, 'You can only edit your own pending reservations.');
        }

        $this->reservationService->updateTimeSlot($request->validated(), $reservation);

        return redirect()->route('reservations.index')->with('success', 'Reservation time slot updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $this->reservationRepository->delete($id);

        return redirect()->back()->with('success', 'Reservation deleted successfully!');
    }

    public function applyPage($id)
    {
        $input = 1;
        $reservation = $this->reservationService->show($id);
        if ($reservation->status != ReservationStatus::WAITING) {
            return redirect()->route('reservations.index')->with('error', 'You can only apply for a reservation that is in the waiting status!');
        }
        $procedures = $this->procedureService->index($input);

        return view('reservations.apply', compact('reservation', 'procedures'));
    }

    public function paid($id)
    {
        $this->reservationRepository->paid($id);

        return redirect()->back()->with('success', 'Reservation paid successfully!');
    }
}
