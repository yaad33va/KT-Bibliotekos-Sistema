<?php

namespace App\Http\Controllers;

use App\Models\Book;
use Illuminate\Http\Request;
use Illuminate\View\View;

class BookController extends Controller
{
    public function index(Request $request): View
    {
        $perPage = $request->get('per_page', 12);
        $search = $request->get('search', '');

        $query = Book::query();

        if ($search) {
            $query->where('title', 'like', "%{$search}%")
                ->orWhere('author', 'like', "%{$search}%")
                ->orWhere('genre', 'like', "%{$search}%");
        }

        $books = $query->paginate($perPage);

        return view('books.index', compact('books', 'search'));
    }

    public function available(Request $request): View
    {
        $perPage = $request->get('per_page', 12);
        $search = $request->get('search', '');
        $genre = $request->get('genre', '');

        $query = Book::query();

        if ($search) {
            $query->where('title', 'like', "%{$search}%")
                ->orWhere('author', 'like', "%{$search}%");
        }

        if ($genre) {
            $query->where('genre', $genre);
        }

        $books = $query->paginate($perPage);

        // Filter books with available copies
        $availableBooks = $books->getCollection()->filter(function ($book) {
            return $book->available_copies > 0;
        })->values();

        $genres = Book::distinct()->pluck('genre')->sort();

        return view('books.available', compact('books', 'availableBooks', 'search', 'genre', 'genres'));
    }
}
