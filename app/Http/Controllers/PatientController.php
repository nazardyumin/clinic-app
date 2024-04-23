<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use App\Models\Appointment;
use Carbon\Carbon;

class PatientController extends Controller
{
    public function show_user_appointments()
    {
        $appointments = Appointment::where('user_id', Auth::id())->get()->sortByDesc('date');
        $now = Carbon::now(Auth::getUser()->timezone);
        $now->hour;
        $greetings = ['Доброе утро, ', 'Добрый день, ', 'Добрый вечер, ', 'Доброй ночи, '];
        $index = 0;
        if ($now->hour >= 12 && $now->hour < 18) $index = 1;
        else if ($now->hour >= 18 && $now->hour < 24) $index = 2;
        else if ($now->hour >= 0 && $now->hour < 6) $index = 3;
        return view('patient.profile', ['appointments' => $appointments, 'greeting' => $greetings[$index]]);
    }

    public function settings()
    {
        return view('patient.settings', ['user' => Auth::getUser()]);
    }

    /**
     * Update the user's profile information.
     */
    public function update(ProfileUpdateRequest $request): RedirectResponse
    {
        $request->user()->fill($request->validated());

        if ($request->user()->isDirty('email')) {
            $request->user()->email_verified_at = null;
        }

        $request->user()->save();
        if (Auth::getUser()->email != $request->user()->email) {
            $request->user()->sendEmailVerificationNotification();
        }
        return Redirect::route('profile.settings')->with('status', 'profile-updated');
    }

    /**
     * Delete the user's account.
     */
    public function destroy(Request $request): RedirectResponse
    {
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current_password'],
        ]);

        $apps = Appointment::where('user_id', $request->user()->id)->get();
        foreach ($apps as $app) {
            $app->user_id = null;
            $app->save();
        }

        $user = $request->user();

        Auth::logout();

        $user->delete();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }
}
