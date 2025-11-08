<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Reservation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Notification;

class ReservationController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth')->only(['store', 'myReservations']);
        // librarian routes will be protected in routes via role middleware
    }

    // Registered user borrows a single copy of a book
    public function store(Request $request, Book $book)
    {
        $user = Auth::user();

        // Prevent borrow if user has overdue books
        $hasOverdue = Reservation::where('user_id', $user->id)
            ->whereNull('returned_at')
            ->where('due_at', '<', now())
            ->exists();

        if ($hasOverdue) {
            return back()->with('error', 'You have overdue books. Return them before borrowing more.');
        }

        // check available copies
        $activeReservations = Reservation::where('book_id', $book->id)->whereNull('returned_at')->count();
        $available = max(0, $book->copies - $activeReservations);

        if ($available < 1) {
            return back()->with('error', 'No copies available to borrow.');
        }

        $reservation = Reservation::create([
            'user_id' => $user->id,
            'book_id' => $book->id,
            'borrowed_at' => now(),
            'due_at' => now()->addDays(14), // fixed period (14 days)
            'returned_at' => null,
        ]);

        // Optionally notify librarian(s)
        // Notification::send($librarians, new SomeNotification($reservation));

        return redirect()->route('reservations.my')->with('success', 'Book borrowed successfully. Due: ' . $reservation->due_at->toDateString());
    }

    // Registered user sees own reservations
    public function myReservations()
    {
        $user = Auth::user();
        $reservations = Reservation::with('book')->where('user_id', $user->id)->orderByDesc('borrowed_at')->get();
        return view('reservations.my', compact('reservations'));
    }

    // Librarian: view active borrowed books and borrowers
    public function indexForLibrarian()
    {
        $this->authorize('librarian-action');

        $reservations = Reservation::with(['book', 'user'])
            ->whereNull('returned_at')
            ->orderBy('due_at')
            ->get();

        return view('reservations.index', compact('reservations'));
    }

    // Librarian: mark return
    public function markReturn(Reservation $reservation)
    {
        $this->authorize('librarian-action');

        if ($reservation->returned_at) {
            return back()->with('info', 'This book is already returned.');
        }

        $reservation->update(['returned_at' => now()]);

        return back()->with('success', 'Marked as returned.');
    }
}
