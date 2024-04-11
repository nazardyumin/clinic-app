<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Doctor;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;

class StaffAuthController extends Controller
{
    public function login(Request $request): RedirectResponse
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        if (Auth::guard('staff')->attempt($credentials)) {
            $request->session()->regenerate();

            $user = Doctor::firstWhere('email', $request->email);
            if ($user->timezone != $request['timezone']) {
                $user->timezone = $request['timezone'];
                $user->save();
            }
            return redirect()->intended(route('staff.profile', absolute: false));
        }
        return redirect(route('login'))->withErrors(["password" => "Неверный логин или пароль"]);
    }

    public function logout()
    {
        auth(guard: "staff")->logout();
        session()->invalidate();
        return redirect(route('staff.login'));
    }
}
