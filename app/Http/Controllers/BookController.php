<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Reservation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BookController extends Controller
{
    // Public: view all books
    public function index()
    {
        $books = Book::orderBy('title')->paginate(20);
        return view('books.index', compact('books'));
    }

    // Public: view only currently unborrowed books (available)
    public function available()
    {
        // compute available copies as copies - active reservations
        $books = Book::withCount(['reservations as active_reservations_count' => function ($q) {
            $q->whereNull('returned_at');
        }])->get()->map(function ($book) {
            $book->available = max(0, $book->copies - $book->active_reservations_count);
            return $book;
        });

        return view('books.available', compact('books'));
    }

    // Librarian: show create form
    public function create()
    {
        $this->authorize('librarian-action'); // optional - alternatively use middleware
        return view('books.create');
    }

    // Librarian: store new book
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'author' => 'nullable|string|max:255',
            'copies' => 'required|integer|min:0',
        ]);

        Book::create($request->only(['title', 'author', 'copies']));

        return redirect()->route('books.index')->with('success', 'Book added.');
    }

    // Librarian: edit book (including copies)
    public function edit(Book $book)
    {
        $this->authorize('librarian-action');
        return view('books.edit', compact('book'));
    }

    public function update(Request $request, Book $book)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'author' => 'nullable|string|max:255',
            'copies' => 'required|integer|min:0',
        ]);

        $book->update($request->only(['title', 'author', 'copies']));

        return redirect()->route('books.index')->with('success', 'Book updated.');
    }

    // Show single book
    public function show(Book $book)
    {
        $activeReservations = $book->reservations()->whereNull('returned_at')->with('user')->get();
        $available = max(0, $book->copies - $activeReservations->count());
        return view('books.show', compact('book', 'available', 'activeReservations'));
    }
}
