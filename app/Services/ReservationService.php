<?php

namespace App\Services;

use App\DTOs\ProcedureCreateDTO;
use App\Models\User;
use App\Repositories\ReservationRepository;
use App\Repositories\UserRepository;
use Illuminate\Http\Request;

class ReservationService
{

    public function __construct(
        protected ReservationRepository $reservationRepository,
        protected UserRepository $userRepository
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
        return $this->reservationRepository->store($input);
    }

    public function create()
    {
        $users = $this->userRepository->patients();

        return compact('users');
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
    public function update(Request $request, User $user)
    {
        //
    }

    public function delete($id)
    {
        return $this->reservationRepository->delete($id);
    }

    public function report()
    {
        return $this->reservationRepository->report();
    }
}
