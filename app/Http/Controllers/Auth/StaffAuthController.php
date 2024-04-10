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


        // if (auth(guard: "staff")->attempt($request->only('email', 'password'))) {
        //     $request->session()->regenerate();
        //     // $user_id = Auth::id();
        //     // $user = Doctor::find($user_id);
        //     // if ($user->timezone != $data['timezone']) {
        //     //     $user->timezone = $data['timezone'];
        //     //     $user->save();
        //     // }
        //     return redirect(route('staff.profile'));
        // }

        //return redirect(route('login'))->withErrors(["password" => "Неверный логин или пароль"]);

        //return redirect()->intended(route('account', absolute: false));
    }
}