<?php

namespace App\Services;

use App\Repositories\ProcedureRepository;
use App\Repositories\ReservationProcedureRepository;
use App\Repositories\ReservationRepository;
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
        DB::commit();

        $total = $this->reservationProcedureRepository->getPrice($reservation->id);
        $this->reservationRepository->storePrice($reservation, $total);

        return $reservation;
    }

    public function show($id)
    {
        return $this->reservationRepository->show($id);
    }

    public function delete($id)
    {
        return $this->reservationRepository->delete($id);
    }

    public function report()
    {
        return $this->reservationProcedureRepository->report();
    }
}
