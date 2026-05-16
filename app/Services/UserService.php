<?php

namespace App\Services;

use App\Enums\ReservationStatus;
use App\Models\Diagnosis;
use App\Models\Prescription;
use App\Models\User;
use App\Repositories\ReservationRepository;
use App\Repositories\UserRepository;
use Spatie\Permission\Models\Role;

class UserService
{
    public function __construct(
        protected UserRepository $userRepository,
        protected ReservationRepository $reservationRepository
    ) {}

    /**
     * Display a listing of the resource.
     */
    public function index($input)
    {
        $users = $this->userRepository->index($input);
        $roles = isset($input->roles) ? Role::whereIn('name', $input->roles)->get() : Role::where('name', '!=', 'admin')->get();

        return compact('users', 'roles');
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
    public function store($request)
    {
        return $this->userRepository->store($request);
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $user = $this->userRepository->show($id);
        $reservations = $this->reservationRepository->userShow($id);
        // Get reservation statistics
        $totalReservations = $user->reservations_count;
        $completedReservations = $this->reservationRepository->getUserTotals($user, ReservationStatus::PAID);
        $upcomingReservations = $this->reservationRepository->getUserTotals($user, ReservationStatus::WAITING, true);
        $cancelledReservations = $this->reservationRepository->getUserTotals($user, ReservationStatus::CANCELLED);

        $diagnoses = Diagnosis::where('user_id', $user->id)
            ->with(['reservation', 'doctor.user'])
            ->latest()
            ->get();
        $prescriptions = Prescription::where('user_id', $user->id)
            ->with(['reservation', 'doctor.user'])
            ->latest()
            ->get();

        return compact('user', 'reservations', 'totalReservations', 'completedReservations', 'upcomingReservations', 'cancelledReservations', 'diagnoses', 'prescriptions');
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
    public function update($id, $request)
    {
        return $this->userRepository->update($id, $request);
    }

    public function report()
    {
        return $this->userRepository->report();
    }

    public function getRolesForCreate()
    {
        return Role::where('name', '!=', 'admin')->get();
    }
}
