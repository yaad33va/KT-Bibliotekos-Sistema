<?php

namespace App\Http\Controllers;

use App\Models\Book;
use Illuminate\View\View;

class WelcomeController extends Controller
{
    public function index(): View
    {
        $books = Book::all();
        $booksCount = $books->count();

        return view('welcome', [
            'books' => $books,
            'booksCount' => $booksCount,
        ]);
    }
}
