<?php

namespace App\Http\Controllers;

use App\Models\Book;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;

class BookController extends Controller
{
    public function index(): View
    {
        $books = Book::latest()->paginate(10);
        return view('books.index', compact('books'));
    }

    public function create(): View
    {
        return view('books.create');
    }

    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'author' => 'required|string|max:255',
            'genre' => 'required|string|max:255',
            'release_date' => 'required|date',
            'book_description' => 'required|string|max:2000',
            'page_count' => 'required|integer|min:1',
            'book_count' => 'required|integer|min:0',
        ]);

        Book::create($request->all());
        return redirect()->route('books.index')->with('success', 'Knyga sėkmingai pridėta.');
    }

    public function show(Book $book): View
    {
        return view('books.show', compact('book'));
    }

    public function edit(Book $book): View
    {
        return view('books.edit', compact('book'));
    }

    public function update(Request $request, Book $book): RedirectResponse
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'author' => 'required|string|max:255',
            'genre' => 'required|string|max:255',
            'release_date' => 'required|date',
            'book_description' => 'required|string|max:2000',
            'page_count' => 'required|integer|min:1',
            'book_count' => 'required|integer|min:0',
        ]);

        $book->update($request->all());
        return redirect()->route('books.index')->with('success', 'Knygos informacija atnaujinta.');
    }

    public function destroy(Book $book): RedirectResponse
    {
        if ($book->reservations()->whereNull('returned_at')->exists()) {
            return back()->withErrors(['error' => 'Negalima ištrinti knygos, kuri yra rezervuota.']);
        }

        $book->delete();
        return redirect()->route('books.index')->with('success', 'Knyga ištrinta.');
    }
}
