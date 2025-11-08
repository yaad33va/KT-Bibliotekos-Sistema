<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Reservation;
use App\Enums\BookStatus;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class BorrowingController extends Controller
{
    public function index(): View
    {
        $reservations = auth()->user()->reservations()
            ->where('book_status', 'taken')
            ->with('book')
            ->get();

        return view('borrowing.index', compact('reservations'));
    }

    public function borrow(Book $book): RedirectResponse
    {
        if ($book->available_copies <= 0) {
            return back()->with('error', 'No copies available.');
        }

        Reservation::create([
            'user_id' => auth()->id(),
            'book_id' => $book->id,
            'reservation_date' => now(),
            'return_date' => now()->addDays(14),
            'book_status' => BookStatus::Taken,
        ]);

        return redirect()->route('borrowing.index')->with('success', 'Book borrowed successfully.');
    }
}
