<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;
use App\Models\User;

class AuthenticatedSessionController extends Controller
{
    public function create(): View
    {
        return view('auth.login');
    }

    public function store(LoginRequest $request): RedirectResponse
    {
        $request->authenticate();

        $user = User::firstWhere('email', $request['email']);
        if ($user->timezone != $request['timezone']) {
            $user->timezone = $request['timezone'];
            $user->save();
        }

        $request->session()->regenerate();

        if (redirect()->intended()->getTargetUrl() == route('logout') || redirect()->intended()->getTargetUrl() == route('show.pdf.p')) {
            return redirect(route('profile'));
        } else
            return redirect()->intended(route('profile', absolute: false));
    }

    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        //$request->session()->invalidate();
        session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/');
    }
}
