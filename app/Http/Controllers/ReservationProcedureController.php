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
        )
    {

    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $this->reservationProcedureService->store($request);
        
        return redirect()->back()->with('success', 'Procedure created successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(ReservationProcedure $reservationProcedure)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(ReservationProcedure $reservationProcedure)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, ReservationProcedure $reservationProcedure)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ReservationProcedure $reservationProcedure)
    {
        //
    }
}
