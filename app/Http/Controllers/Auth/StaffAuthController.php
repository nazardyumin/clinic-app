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
            if (redirect()->intended()->getTargetUrl() == route('staff.logout') || redirect()->intended()->getTargetUrl() == route('staff.show.pdf.p') || redirect()->intended()->getTargetUrl() == route('staff.update')) {
                return redirect(route('staff.profile'));
            }
            return redirect()->intended(route('staff.profile', absolute: false));
        }
        return redirect(route('staff.login'))->withErrors(["password" => "Неверный логин или пароль."])->withInput();
    }

    public function logout(Request $request): RedirectResponse
    {
        Auth::guard('staff')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect(route('staff.login'));
    }
}
