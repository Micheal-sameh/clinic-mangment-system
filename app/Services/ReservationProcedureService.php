<?php

namespace App\Services;

use App\Models\User;
use App\Repositories\ProcedureRepository;
use App\Repositories\ReservationProcedureRepository;
use App\Repositories\ReservationRepository;
use App\Repositories\UserRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ReservationProcedureService
{

    public function __construct(
        protected ReservationRepository $reservationRepository,
        protected ReservationProcedureRepository $reservationProcedureRepository,
        protected ProcedureRepository $procedureRepository,
        ){

    }

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
        DB::beginTransaction();
        $reservation = $this->reservationRepository->show($input->reservation_id);

        $currentProcedures = $reservation->reservationProcedures->pluck('procedure_id')->toArray();
        $selectedProcedures = $input->input('procedures', []);

        $proceduresToAdd = array_diff($selectedProcedures, $currentProcedures);
        $proceduresToRemove = array_diff($currentProcedures, $selectedProcedures);

        foreach ($proceduresToAdd as $procedureId) {
            $procedure = $this->procedureRepository->show($procedureId);
            $this->reservationProcedureRepository->store($reservation, $procedure);
        }

        // Detach removed procedures
        foreach ($proceduresToRemove as $procedureId) {
            $this->reservationProcedureRepository->delete($procedureId);
        }

        $totalPrice = $reservation->reservationProcedures->sum('price');
        $this->reservationRepository->storePrice($reservation, $totalPrice);
        DB::commit();
    }

    public function create()
    {
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
    public function edit(User $user)
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

    public function delete($id)
    {
        return $this->reservationRepository->delete($id);
    }
}
