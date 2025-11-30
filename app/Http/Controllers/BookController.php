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
        ], [
            // LIETUVIŠKI PRANEŠIMAI
            'title.required' => 'Pavadinimas yra privalomas.',
            'author.required' => 'Autorius yra privalomas.',
            'genre.required' => 'Žanras yra privalomas.',
            'release_date.required' => 'Leidimo data yra privaloma.',
            'book_description.required' => 'Aprašymas yra privalomas.',
            'page_count.required' => 'Puslapių skaičius yra privalomas.',
            'page_count.min' => 'Puslapių skaičius turi būti bent 1.',
            'book_count.required' => 'Knygų kiekis yra privalomas.',
            'book_count.min' => 'Kiekis negali būti neigiamas.',
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

    public function update(Request $request, Book $book)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'author' => 'required|string|max:255',
            'genre' => 'required|string|max:255',
            'release_date' => 'required|date',
            'page_count' => 'required|integer|min:1',
            'book_count' => 'required|integer|min:0',
            'book_description' => 'required|string',
        ], [
            'title.required' => 'Pavadinimas yra privalomas.',
            'author.required' => 'Autorius yra privalomas.',
            'genre.required' => 'Žanras yra privalomas.',
            'release_date.required' => 'Leidimo data yra privaloma.',
            'page_count.required' => 'Puslapių skaičius yra privalomas.',
            'page_count.min' => 'Puslapių skaičius turi būti bent 1.',
            'book_count.required' => 'Knygų kiekis yra privalomas.',
            'book_count.min' => 'Kiekis negali būti neigiamas.',
            'book_description.required' => 'Aprašymas yra privalomas.',
        ]);

        $book->update($validated);

        return redirect()->route('books.index')->with('success', 'Knyga atnaujinta sėkmingai.');
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
