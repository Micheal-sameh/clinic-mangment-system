<?php

namespace App\Http\Controllers;

use App\Http\Requests\WorkingDayFilterRequest;
use App\Http\Requests\WorkingDayStoreRequest;
use App\Http\Requests\WorkingDayUpdateRequest;
use App\Repositories\WorkingDayRepository;
use App\Services\WorkingDayService;
use Illuminate\Http\Request;

class WorkingDayController extends Controller
{
    public function __construct(
        protected WorkingDayService $workingDayService,
        protected WorkingDayRepository $workingDayRepository,
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

    public function update(WorkingDayUpdateRequest $request)
    {
        $this->workingDayService->update($request);
        return redirect()->route('working-days.index');
    }

    public function active($id)
    {
        $this->workingDayRepository->active($id);

        return redirect()->route('working-days.index');
    }

    public function slates(Request $request)
    {
        $slates = $this->workingDayService->slatesNumber($request->date);
        return $slates;
    }
}
