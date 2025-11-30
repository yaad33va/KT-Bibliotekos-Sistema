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

class RegistrationController extends Controller
{
    public function create(): View
    {
        return view('auth.register');
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'surname' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ], [
            // LIETUVIŠKI PRANEŠIMAI
            'name.required' => 'Vardo laukas yra privalomas.',
            'surname.required' => 'Pavardės laukas yra privalomas.',
            'email.required' => 'El. pašto adresas yra privalomas.',
            'email.email' => 'Įveskite galiojantį el. pašto adresą.',
            'email.unique' => 'Toks el. paštas jau registruotas sistemoje.',
            'password.required' => 'Slaptažodis yra privalomas.',
            'password.confirmed' => 'Slaptažodžiai nesutampa.',
            'password.min' => 'Slaptažodis turi būti bent :min simbolių ilgio.',
        ]);

        $validated['password'] = Hash::make($validated['password']);
        event(new Registered(($user = User::create($validated))));
        $user->assignRole('user');

        Auth::login($user);

        return redirect('/');
    }
}
