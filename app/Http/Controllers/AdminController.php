<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;

class AdminController extends Controller
{
    public function dashboard()
    {
        $librarians = User::whereHas('roles', function ($query) {
            $query->where('name', 'librarian');
        })->get();

        return view('admin.dashboard', compact('librarians'));
    }

    public function createLibrarian()
    {
        return view('admin.create-librarian');
    }

    public function storeLibrarian(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'surname' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ], [
            'name.required' => 'Vardo laukas yra privalomas.',
            'surname.required' => 'Pavardės laukas yra privalomas.',
            'email.required' => 'El. pašto adresas yra privalomas.',
            'email.email' => 'Įveskite galiojantį el. pašto adresą.',
            'email.unique' => 'Toks el. paštas jau registruotas sistemoje.',
            'password.required' => 'Slaptažodis yra privalomas.',
            'password.confirmed' => 'Slaptažodžiai nesutampa.',
            'password.min' => 'Slaptažodis turi būti bent :min simbolių ilgio.',
        ]);

        $user = User::create([
            'name' => $request->name,
            'surname' => $request->surname,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        $user->assignRole('librarian');

        return redirect()->route('admin.dashboard')->with('success', 'Bibliotekininkas sėkmingai sukurtas.');
    }

    // NAUJA FUNKCIJA TRINIMUI
    public function destroyLibrarian(User $user)
    {
        // Apsauga: leidžiame trinti tik bibliotekininkus
        if (!$user->hasRole('librarian')) {
            return back()->with('error', 'Negalima ištrinti šio vartotojo.');
        }

        $user->delete();

        return redirect()->route('admin.dashboard')->with('success', 'Bibliotekininkas sėkmingai pašalintas.');
    }
}
