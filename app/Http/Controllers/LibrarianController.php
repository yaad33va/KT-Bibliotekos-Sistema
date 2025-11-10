<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\User;
// Assuming you have a Borrow model
// use App\Models\Borrow;
use Illuminate\Http\Request;
use Illuminate\View\View;

class LibrarianController extends Controller
{
    /**
     * Display the librarian dashboard with statistics.
     */
    public function dashboard(): View
    {
        $totalBooks = Book::count();
        $borrowedBooks = Book::where('is_borrowed', true)->count();
        $totalUsers = User::count();

        return view('librarian.dashboard', [
            'totalBooks' => $totalBooks,
            'borrowedBooks' => $borrowedBooks,
            'totalUsers' => $totalUsers,
        ]);
    }
}
