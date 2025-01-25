<?php

namespace App\Http\Controllers;

use App\Http\Requests\WorkingDayFilterRequest;
use App\Http\Requests\WorkingDayStoreRequest;
use App\Services\WorkingDayService;
use Illuminate\Http\Request;

class WorkingDayController extends Controller
{
    public function __construct(
        protected WorkingDayService $workingDayService,
    )
    {
        $this->middleware('permission:workDays_list', ['only' => ['index']]);
        $this->middleware('permission:workDays_create', ['only' => ['create', 'store']]);
    }

    public function index(WorkingDayFilterRequest $request)
    {
        $workingDays = $this->workingDayService->index($request);

        return view('workingDays.index', compact('workingDays'));
    }

    public function create()
    {
        return view('workingDays.create');
    }

    public function store(WorkingDayStoreRequest $request)
    {
        $this->workingDayService->store($request);
        return redirect()->route('working-days.index');
    }

    public function slates(Request $request)
    {
        $slates = $this->workingDayService->slatesNumber($request->date);
        return $slates;
    }
}
