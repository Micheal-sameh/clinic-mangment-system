<?php

namespace App\Http\Controllers;

use App\Models\Diagnosis;
use App\Models\Reservation;
use Illuminate\Http\Request;

class DiagnosisController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:reservations_apply|users_edit');
    }

    public function store(Request $request)
    {
        $request->validate([
            'reservation_id' => 'required|exists:reservations,id',
            'diagnosis' => 'required|string|max:2000',
            'icd_code' => 'nullable|string|max:20',
            'notes' => 'nullable|string|max:3000',
        ]);

        $reservation = Reservation::findOrFail($request->reservation_id);

        Diagnosis::create([
            'reservation_id' => $reservation->id,
            'user_id' => $reservation->user_id,
            'doctor_id' => $reservation->doctor_id,
            'diagnosis' => $request->diagnosis,
            'icd_code' => $request->icd_code,
            'notes' => $request->notes,
        ]);

        return redirect()->back()->with('success', __('messages.diagnosis_saved') ?? 'Diagnosis saved.');
    }

    public function destroy($id)
    {
        Diagnosis::findOrFail($id)->delete();

        return redirect()->back()->with('success', __('messages.deleted') ?? 'Deleted.');
    }
}
