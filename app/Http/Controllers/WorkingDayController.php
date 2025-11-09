<?php

namespace App\Http\Controllers;

use App\Http\Requests\WorkingDayFilterRequest;
use App\Http\Requests\WorkingDayUpdateRequest;
use App\Repositories\WorkingDayRepository;
use App\Services\WorkingDayService;
use Illuminate\Http\Request;

class WorkingDayController extends Controller
{
    public function __construct(
        protected WorkingDayService $workingDayService,
        protected WorkingDayRepository $workingDayRepository,
    ) {
        $this->middleware('permission:workDays_list', ['only' => ['index']]);
        $this->middleware('permission:workDays_create', ['only' => ['create', 'store']]);
    }

    public function index(WorkingDayFilterRequest $request)
    {
        $workingDays = $this->workingDayService->index($request, $request->doctor_id);
        $doctor = null;
        if (isset($request->doctor_id)) {
            $doctor = app(\App\Repositories\DoctorRepository::class)->findById($request->doctor_id);
        }
        $doctors = app(\App\Repositories\DoctorRepository::class)->all();

        return view('workingDays.index', compact('workingDays', 'doctor', 'doctors'));
    }

    public function update(WorkingDayUpdateRequest $request)
    {
        $this->workingDayService->update($request);

        $redirectUrl = route('working-days.index');
        if ($request->has('doctor_id') && $request->doctor_id) {
            $redirectUrl .= '?doctor_id='.$request->doctor_id;
        }

        return redirect($redirectUrl);
    }

    public function active($id)
    {
        $this->workingDayRepository->active($id);

        return redirect()->route('working-days.index');
    }

    public function slates(Request $request)
    {
        $slates = $this->workingDayService->slatesNumber($request->date, $request->doctor_id);

        return $slates;
    }
}
