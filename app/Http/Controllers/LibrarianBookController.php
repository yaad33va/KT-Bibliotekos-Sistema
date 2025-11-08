<?php

namespace App\Http\Controllers;

use App\Models\Book;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class LibrarianBookController extends Controller
{
    /**
    public function __construct()
    {
        $this->middleware(['auth', 'role:librarian']);
    }
*/
    public function index(): View
    {
        $books = Book::all();
        return view('librarian.books.index', compact('books'));
    }

    public function create(): View
    {
        return view('librarian.books.create');
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'author' => 'required|string|max:255',
            'genre' => 'required|string|max:255',
            'release_date' => 'required|date',
            'book_description' => 'required|string',
            'page_count' => 'required|integer|min:1',
            'book_count' => 'required|integer|min:1',
        ]);

        Book::create($validated);

        return redirect()->route('librarian.books.index')->with('success', 'Book added successfully.');
    }

    public function edit(Book $book): View
    {
        return view('librarian.books.edit', compact('book'));
    }

    public function update(Request $request, Book $book): RedirectResponse
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'author' => 'required|string|max:255',
            'genre' => 'required|string|max:255',
            'release_date' => 'required|date',
            'book_description' => 'required|string',
            'page_count' => 'required|integer|min:1',
            'book_count' => 'required|integer|min:1',
        ]);

        $book->update($validated);

        return redirect()->route('librarian.books.index')->with('success', 'Book updated successfully.');
    }

    public function destroy(Book $book): RedirectResponse
    {
        $book->delete();
        return redirect()->route('librarian.books.index')->with('success', 'Book deleted successfully.');
    }
}
