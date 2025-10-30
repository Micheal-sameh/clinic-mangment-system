<?php

namespace App\Http\Controllers;

use App\DTOs\ProcedureCreateDTO;
use App\DTOs\ProcedureUpdateDTO;
use App\Http\Requests\ProcedureCreateRequest;
use App\Http\Requests\ProcedureUpdateRequest;
use App\Services\ProcedureService;
use Illuminate\Http\Request;

class ProcedureController extends Controller
{
    public function __construct(protected ProcedureService $procedureService)
    {
        $this->middleware('permission:procedures_list', ['only' => ['index', 'show']]);
        $this->middleware('permission:procedures_create', ['only' => ['create', 'store']]);
        $this->middleware('permission:procedures_edit', ['only' => ['edit', 'update']]);
        $this->middleware('permission:procedures_delete', ['only' => ['delete']]);
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

        return redirect()->route('procedures.index')->with('message', 'Procedure created successfully');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $procedure = $this->procedureService->show($id);

        return view('procedures.edit', compact('procedure'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(ProcedureUpdateRequest $request, $id)
    {
        $input = new ProcedureUpdateDTO(...$request->only(
            'name_en', 'name_ar', 'description_en', 'description_ar', 'price',
        ));

        $this->procedureService->update($id, $input);

        return redirect()->route('procedures.index')->with('message', 'Procedure updated successfully');
    }

    public function delete($id)
    {
        $this->procedureService->delete($id);

        return redirect()->route('procedures.index')->with('success', 'Procedure deleted successfully');
    }
}
