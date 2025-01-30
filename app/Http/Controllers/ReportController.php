<?php

namespace App\Http\Controllers;

use App\Services\ReservationProcedureService;
use App\Services\ReservationService;
use App\Services\UserService;
use Carbon\Carbon;

class ReportController extends Controller
{
    public function __construct(
        protected UserService $userService,
        protected ReservationService $reservationService,
        protected ReservationProcedureService $reservationProcedureservice,
    ) {
        $this->middleware('permission:reports_list', ['only' => ['index']]);

    }
    public function index()
    {
        // Current date
        $today = Carbon::today();

        $users        = $this->userService->report();
        $reservations = $this->reservationService->report();
        $income       = $this->reservationProcedureservice->report();

        //users
        $usersThisMonth = $users['usersThisMonth'];
        $usersLastMonth = $users['usersLastMonth'];
        $usersAllTime   = $users['usersAllTime'];
        $newUsersToday  = $users['newUsersToday'];

        // Income
        $incomeThisMonth = $income['incomeThisMonth'];
        $incomeLastMonth = $income['incomeLastMonth'];
        $incomeAllTime   = $income['incomeAllTime'];
        $incomeToday     = $income['incomeToday'];

        // reservations
        $reservationsToday = $reservations['reservationsToday'];

        return view('reports.index', compact(
            'usersThisMonth',
            'usersLastMonth',
            'usersAllTime',
            'incomeThisMonth',
            'incomeLastMonth',
            'incomeAllTime',
            'newUsersToday',
            'incomeToday',
            'reservationsToday',
        ));
    }
}