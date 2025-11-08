<?php

namespace App\Http\Controllers;

use App\Services\DoctorService;
use Illuminate\Http\Request;

class DoctorController extends Controller
{
    public function __construct(
        protected DoctorService $doctorService,
    ) {
        $this->middleware('permission:users_list|users_create|users_edit|users_delete', ['only' => ['index', 'store']]);
        $this->middleware('permission:users_create', ['only' => ['create', 'store']]);
        $this->middleware('permission:users_edit', ['only' => ['edit', 'update']]);
        $this->middleware('permission:users_delete', ['only' => ['destroy']]);
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $doctors = $this->doctorService->index();

        return view('doctors.index', compact('doctors'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('doctors.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $this->doctorService->store($request->all());

        return redirect()->route('doctors.index')->with('success', __('messages.success'));
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $doctor = $this->doctorService->show($id);

        return view('doctors.show', compact('doctor'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $doctor = $this->doctorService->show($id);

        return view('doctors.edit', compact('doctor'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $this->doctorService->update($id, $request->all());

        return redirect()->route('doctors.index')->with('success', __('messages.success'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $this->doctorService->destroy($id);

        return redirect()->route('doctors.index')->with('success', __('messages.success'));
    }
}
