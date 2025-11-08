<?php

namespace App\Services;

use App\Repositories\DoctorRepository;

class DoctorService
{
    public function __construct(
        protected DoctorRepository $doctorRepository
    ) {}

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return $this->doctorRepository->index();
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store($request)
    {
        return $this->doctorRepository->store($request);
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        return $this->doctorRepository->show($id);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update($id, $request)
    {
        return $this->doctorRepository->update($id, $request);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        return $this->doctorRepository->delete($id);
    }
}
