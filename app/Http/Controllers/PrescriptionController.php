<?php

namespace App\Http\Controllers;

use App\Models\Prescription;
use App\Models\Reservation;
use Illuminate\Http\Request;

class PrescriptionController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:reservations_apply|users_edit');
    }

    public function store(Request $request)
    {
        $request->validate([
            'reservation_id' => 'required|exists:reservations,id',
            'medicine_name' => 'required|string|max:255',
            'dosage' => 'nullable|string|max:100',
            'frequency' => 'nullable|string|max:100',
            'duration' => 'nullable|string|max:100',
            'notes' => 'nullable|string|max:2000',
        ]);

        $reservation = Reservation::findOrFail($request->reservation_id);

        Prescription::create([
            'reservation_id' => $reservation->id,
            'user_id' => $reservation->user_id,
            'doctor_id' => $reservation->doctor_id,
            'medicine_name' => $request->medicine_name,
            'dosage' => $request->dosage,
            'frequency' => $request->frequency,
            'duration' => $request->duration,
            'notes' => $request->notes,
        ]);

        return redirect()->back()->with('success', __('messages.prescription_saved') ?? 'Prescription saved.');
    }

    public function destroy($id)
    {
        Prescription::findOrFail($id)->delete();

        return redirect()->back()->with('success', __('messages.deleted') ?? 'Deleted.');
    }
}
