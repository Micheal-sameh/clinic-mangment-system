<?php

namespace App\Repositories;

use App\Enums\UserStatus;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Hash;

class UserRepository extends BaseRepository
{
    public function __construct(User $model)
    {
        parent::__construct($model);
    }

    /**
     * Display a listing of the resource.
     */
    public function index($input)
    {
        return $this->query()->with('roles:id,name')
            ->when(! is_null($input->role), function ($q) use ($input) {
                return $q->whereHas('roles', function ($query) use ($input) {
                    $query->where('name', $input->role);
                });
            })
            ->when(isset($input->roles), function ($q) use ($input) {
                return $q->whereHas('roles', function ($query) use ($input) {
                    $query->whereIn('name', $input->roles);
                });
            })
            ->when(! is_null($input->name), fn ($q) => $q->where('name', 'like', '%'.$input->name.'%'))
            ->orderby('name')
            ->paginate(20); // Limit page size for better performance
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store($request)
    {
        $user = $this->create([
            'name' => ['en' => $request->name_en, 'ar' => $request->name_ar],
            'email' => $request->email,
            'phone' => $request->phone,
            'age' => $request->age,
            'password' => Hash::make('123456'), // Default password
            'status' => 1, // Active by default
        ]);

        $user->assignRole($request->role);

        return $user;
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        return $this->query()->where('id', $id)->with('roles:id,name')->withCount('reservations')->firstOrFail();
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(User $user)
    {
        return $user;
    }

    /**
     * Update the specified resource in storage.
     */
    public function update($id, $request)
    {
        $user = $this->findById($id);

        $user->update([
            'name' => ['en' => $request->name_en, 'ar' => $request->name_ar],
            'email' => $request->email,
            'phone' => $request->phone,
            'age' => $request->age,
        ]);

        $user->syncRoles([$request->role]);

        return $user;
    }

    public function resetPassword($id)
    {
        $user = $this->findById($id);

        return $user->update([
            'password' => Hash::make('123456'),
        ]);
    }

    public function changeStatus($id)
    {
        $user = $this->findById($id);

        return $user->update([
            'status' => $user->status == UserStatus::ACTIVE ? UserStatus::INACTIVE : UserStatus::ACTIVE,
        ]);
    }

    public function patients()
    {
        return $this->query()->whereHas('roles', function ($query) {
            $query->where('name', 'patient');
        })->select('id', 'name', 'phone')->get(); // Select only needed columns
    }

    public function report()
    {
        $today = Carbon::today();
        $usersThisMonth = $this->model->whereHas('roles', function ($query) {
            $query->where('name', 'patient');
        })->whereMonth('created_at', '=', $today->month)
            ->whereYear('created_at', '=', $today->year)
            ->count();

        $usersAllTime = $this->model->whereHas('roles', function ($query) {
            $query->where('name', 'patient');
        })->count();

        $newUsersToday = $this->model->whereHas('roles', function ($query) {
            $query->where('name', 'patient');
        })->whereDate('created_at', '=', $today)->count();

        $usersLastMonth = $this->model->whereHas('roles', function ($query) {
            $query->where('name', 'patient');
        })->whereMonth('created_at', '=', today()->subMonth()->month)
            ->whereYear('created_at', '=', $today->year)
            ->count();

        return compact('usersThisMonth', 'usersAllTime', 'usersLastMonth', 'newUsersToday');
    }
}
