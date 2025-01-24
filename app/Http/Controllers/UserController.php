<?php

namespace App\Http\Controllers;

use App\Http\Requests\PasswordUpdateRequest;
use App\Models\User;
use App\Repositories\UserRepository;
use App\Services\UserService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{

    public function __construct(
        protected UserService $userService,
        protected UserRepository $userRepository,
        )
    {
        $this->middleware('permission:users_list|users_create|users_edit|users_delete', ['only' => ['index', 'store']]);
        $this->middleware('permission:users_create', ['only' => ['create', 'store']]);
        $this->middleware('permission:users_edit', ['only' => ['edit', 'update']]);
        $this->middleware('permission:users_delete', ['only' => ['destroy']]);
        $this->middleware('permission:users_profile', ['only' => ['profile']]);
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $users = $this->userService->index($request);

        return view('users.index', compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('users.create');
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
        $data = $this->userService->show($id);
        return view('users.show',['user' => $data['user'], 'reservations' => $data['reservations']]);
    }

    public function profile()
    {
        $data = $this->userService->profile(Auth::id());
        return view('users.profile', ['user' => $data['user'], 'reservations' => $data['reservations']]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $user = User::find($id);

        return view('users.edit', compact('user'));
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
        $this->userRepository->delete($id);

        return response()->back()->with(['message' => 'User deleted successfully']);
    }

    public function updatePassword(PasswordUpdateRequest $request)
    {
        if (!Hash::check($request->current_password, Auth::user()->password)) {
            return back()->withErrors(['current_password' => 'Current password is incorrect.']);
        }
        $user = User::find(Auth::id());
        $user->update([
            'password' => Hash::make($request->password),
        ]);

        return redirect()->back()->with('success', 'Password updated successfully.');
    }

    public function resetPassword($id)
    {
        $this->userRepository->resetPassword($id);

        return redirect()->back()->with('message', 'Password reset successfully');
    }
}
