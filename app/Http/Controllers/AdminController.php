<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;

class AdminController extends Controller
{
    /**
     * Display the admin dashboard with a list of librarians.
     */
    public function dashboard()
    {
        // Assuming you have a 'librarian' role
        $librarians = User::whereHas('roles', function ($query) {
            $query->where('name', 'librarian');
        })->get();

        return view('admin.dashboard', compact('librarians'));
    }

    /**
     * Show the form for creating a new librarian.
     */
    public function createLibrarian()
    {
        return view('admin.create-librarian');
    }

    /**
     * Store a newly created librarian in storage.
     */
    public function storeLibrarian(Request $request)
    {
        // Pirmas masyvas - taisyklės
        // Antras masyvas - jūsų lietuviški pranešimai
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
            'password.confirmed' => 'Slaptažodžiai nesutampa.', // Čia dažniausia klaida, kai įveda neteisingai antrą kartą
            'password.min' => 'Slaptažodis turi būti bent :min simbolių ilgio.',
        ]);

        $user = User::create([
            'name' => $request->name,
            'surname' => $request->surname,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        // Assuming you are using a role system (like Spatie's)
        $user->assignRole('librarian');

        return redirect()->route('admin.dashboard')->with('success', 'Bibliotekininkas sėkmingai sukurtas.');
    }
}
