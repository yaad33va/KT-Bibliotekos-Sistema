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
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'surname' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
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
