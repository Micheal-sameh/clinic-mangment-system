<?php

namespace App\Repositories;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserRepository
{

    public function __construct(protected User $model)
    {

    }
    /**
     * Display a listing of the resource.
     */
    public function index($input)
    {
        $users = $this->model
            ->when(!is_null($input->role), function ($q) use ($input) {
                return $q->whereHas('roles', function ($query) use ($input) {
                    $query->where('name', $input->role);
                });
            })
            ->when(!is_null($input->name), fn($q) => $q->where('name', 'like', '%' . $input->name . '%'))
            ->orderby('name')
            ->get();

        return $users;
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $user = $this->model->find($id);

        return $user;
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(User $user)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, User $user)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function delete($id)
    {
        return $this->model->find($id)->delete();
    }
    public function resetPassword($id)
    {
        return $this->model->find($id)->update([
            'password' => Hash::make('123456')
        ]);
    }
}
