<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use App\Http\Requests\StoreUserRequest;
use App\Http\Resources\UserResource;
use App\Models\User;
use App\Providers\RouteServiceProvider;
use App\Traits\HttpResponses;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

class AuthController extends Controller
{
    use HttpResponses;

    public function loginPage()
    {
        return view('auth.login');
    }

    public function login(LoginRequest $request)
    {
        $request->authenticate();

        $request->session()->regenerate();

        return redirect()->intended(RouteServiceProvider::HOME);
    }

    public function register(StoreUserRequest $request)
    {
        $request->validated($request->all());
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => 'user',
            'status' => 'inactive',
        ]);
        $role = Role::where('name', 'user')->first();
        $user->assignRole([$role->id]);

        return $this->success([
            'user' => new UserResource($user),
            'token' => $user->createToken('API Token of' . $user->name)->plainTextToken,

        ]);
    }

    public function logout()
    {
        return response()->json('this is my logout method');
    }
}
