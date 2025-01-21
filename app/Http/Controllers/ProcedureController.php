<?php

namespace App\Http\Controllers;

use App\DTOs\ProcedureCreateDTO;
use App\Http\Requests\ProcedureCreateRequest;
use App\Services\ProcedureService;
use Illuminate\Http\Request;

class ProcedureController extends Controller
{

    public function __construct(protected ProcedureService $procedureService)
    {

    }
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $procedures = $this->procedureService->index($request);

        return view('procedures.index', compact('procedures'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('procedures.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ProcedureCreateRequest $request)
    {
        $input = new ProcedureCreateDTO(...$request->only(
            'name_en', 'name_ar', 'description_en', 'description_ar', 'price',
        ));

        $this->procedureService->store($input);
        return redirect()->back()->with('success', 'Procedure created successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(Procedure $procedure)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Procedure $procedure)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Procedure $procedure)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function delete($id)
    {
        $this->procedureService->delete($id);
        return redirect()->route('procedures.index')->with('success', 'Procedure deleted successfully');
    }
}
