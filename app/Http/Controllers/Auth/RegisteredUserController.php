<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\View\View;
use Carbon\Carbon;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): View
    {
        return view('auth.register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'first_name' => ['required', 'string', 'max:255', 'min:2', 'regex:/^([^0-9]*)$/'],
            'last_name' => ['required', 'string', 'max:255', 'min:2', 'regex:/^([^0-9]*)$/'],
            'patronymic' => ['required', 'string', 'max:255', 'min:2', 'regex:/^([^0-9]*)$/'],
            'date_of_birth' => ['required'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:' . User::class],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        if (Carbon::parse($request->date_of_birth)->age < 18) {
            return redirect()->back()->withErrors(["date_of_birth" => "Для регистрации Вы должны быть старше 18 лет."])->withInput();
        }

        $user = User::create([
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'patronymic' => $request->patronymic,
            'date_of_birth' => $request->date_of_birth,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            "timezone" => $request->timezone,
            "role_id" => 2
        ]);

        Auth::login($user);
        event(new Registered($user));

        return redirect(route('profile', absolute: false));
    }
}
