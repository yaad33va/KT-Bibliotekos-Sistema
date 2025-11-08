<?php

namespace App\Http\Controllers;

use App\Models\Reservation;
use App\Enums\BookStatus;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class LibrarianReturnsController extends Controller
{
    /**
    public function __construct()
    {
        $this->middleware(['auth', 'role:librarian']);
    }
*/
    public function index(): View
    {
        $borrowed = Reservation::where('book_status', 'taken')
            ->with('user', 'book')
            ->get();

        return view('librarian.returns.index', compact('borrowed'));
    }

    public function markReturned(Reservation $reservation): RedirectResponse
    {
        $reservation->update([
            'book_status' => BookStatus::Returned,
            'returned_at' => now(),
        ]);

        return redirect()->route('librarian.returns.index')->with('success', 'Book marked as returned.');
    }
}
