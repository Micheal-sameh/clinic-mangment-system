<?php

namespace App\Services;

use App\Models\User;
use App\Repositories\ReservationRepository;
use App\Repositories\UserRepository;
use Illuminate\Http\Request;

class UserService
{

    public function __construct(
        protected UserRepository $userRepository,
        protected ReservationRepository $reservationRepository
        )
    {

    }

    /**
     * Display a listing of the resource.
     */
    public function index($input)
    {
        $users = $this->userRepository->index($input);

        return $users;
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
        //
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $user = $this->userRepository->show($id);
        $reservations = $this->reservationRepository->userShow($id);
        return compact('user', 'reservations');
    }

    public function profile($id)
    {
        $user = $this->userRepository->show($id);
        $reservations = $this->reservationRepository->userProfile($id);
        $reservationsCount = $this->reservationRepository->getAll()->count();
        
        return compact('user', 'reservations', 'reservationsCount');
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
}
