<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

class LibrarianController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'role:administrator']);
    }

    public function index()
    {
        $librarians = User::role('librarian')->get();
        return view('admin.librarians.index', compact('librarians'));
    }

    public function create()
    {
        return view('admin.librarians.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:8|confirmed',
        ]);

        $user = User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
            'email_verified_at' => now(),
        ]);

        $user->assignRole('librarian');

        return redirect()->route('admin.librarians.index')->with('success', 'Librarian created.');
    }

    public function destroy(User $user)
    {
        if ($user->hasRole('librarian')) {
            $user->removeRole('librarian');
            // Optionally delete user: $user->delete();
            return redirect()->route('admin.librarians.index')->with('success', 'Librarian removed.');
        }

        return redirect()->route('admin.librarians.index')->with('error', 'User is not a librarian.');
    }
}
