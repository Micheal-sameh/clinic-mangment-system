<?php

namespace App\Http\Controllers;

use App\Services\WorkingDayService;
use Illuminate\Http\Request;

class WorkingDayController extends Controller
{
    public function __construct(
        protected WorkingDayService $workingDayService,
    )
    {

    }

    public function index()
    {
        $workingDays = $this->workingDayService->index();

        return view('workingDays.index', compact('workingDays'));
    }

    public function create()
    {
        return view('workingDays.create');
    }

    public function store(Request $request)
    {
        $this->workingDayService->store($request);
        return redirect()->route('workingDays.index');
    }

    public function slates(Request $request)
    {
        $slates = $this->workingDayService->slatesNumber($request->date);
        return $slates;
    }
}
