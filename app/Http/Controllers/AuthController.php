<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
use App\Models\User;
use App\Providers\RouteServiceProvider;
use App\Traits\HttpResponses;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
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
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);
        $remember = $request->has('remember');

        if (Auth::attempt($credentials, $remember)) {
            $request->session()->regenerate();
            return redirect()->intended(RouteServiceProvider::HOME);
        }
        return redirect()->intended(RouteServiceProvider::HOME);
    }

    public function registerPage()
    {
        return view('auth.register');
    }

    public function register(RegisterRequest $request)
    {
        $user = User::create([
            'name' => ['en' => $request->name_en, 'ar' => $request->name_ar],
            'email' => $request->email,
            'phone' => $request->phone,
            'age'   => $request->age,
            'password' => Hash::make($request->password),
            'status' => '1',
        ]);
        $role = Role::where('name', 'patient')->first();
        $user->assignRole([$role->id]);

        return redirect()->route('login');
    }

    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('loginPage');
    }
}
