<?php

namespace App\Http\Controllers;

use App\Models\Reservation;
use App\Models\Book; // Add this
use App\Models\User; // Add this
use App\Enums\BookStatus;
use Carbon\Carbon;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request; // Add this
use Illuminate\View\View;

class ReservationController extends Controller
{
    /**
     * Display a listing of active reservations for the librarian.
     */
    public function index(): View
    {
        $activeReservations = Reservation::with(['user', 'book'])
            ->whereNull('returned_at');
        if(auth()->user()->hasRole('user')){
            $activeReservations = $activeReservations
                ->where('user_id', auth()->user()->id);
        }
        $activeReservations = $activeReservations
            ->latest('reservation_date')
            ->paginate(15);

        return view('librarian.reservations.index', compact('activeReservations'));
    }

    /**
     * Show the form for creating a new reservation.
     */
    public function create(): View
    {
        $books = Book::where('book_count', '>', 0)->orderBy('title')->get();
        $users = User::orderBy('name')->get();

        return view('librarian.reservations.create', compact('books', 'users'));
    }

    /**
     * Store a newly created reservation in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'book_id' => 'required|exists:books,id',
            'return_date' => 'required|date|after_or_equal:today',
        ]);

        $book = Book::findOrFail($request->book_id);

        // Check if the book is available
        if ($book->book_count <= 0) {
            return redirect()->back()->withErrors(['book_id' => 'Knyga negalima išdavimui'])->withInput();
        }

        $canMakeReservation = Reservation::where(function($query)use($request){
            $query->where('user_id', $request->user()->id)->whereColumn('returned_at', '<', 'return_date')
                ->orWhere(function($subquery){
                    $subquery->whereNull('returned_at')
                        ->where('return_date', '<', Carbon::today());
                });
        })->count();

        if ($canMakeReservation > 0) {
            return redirect()->back()->withErrors(['return_date' => 'Turite laiku negrąžintų knygų'])->withInput();
        }

        // Create the reservation
        Reservation::create([
            'book_id' => $request->book_id,
            'user_id' => $request->user()->id,
            'reservation_date' => now(),
            'return_date' => $request->return_date,
            'book_status' => BookStatus::Taken, // Assuming 'Paimta' is in your enum
        ]);

        // Decrement the book quantity
        $book->decrement('book_count');

        return redirect()->route('reservations.index')->with('success', 'Reservation created successfully.');
    }

    /**
     * Mark a reservation as returned.
     */
    public function update(Reservation $reservation): RedirectResponse
    {
        // Check if the book has already been marked as returned to prevent errors
        if ($reservation->returned_at) {
            return redirect()->route('reservations.index')->withErrors(['error' => 'This reservation has already been closed.']);
        }

        // Update the reservation record
        $reservation->update([
            'returned_at' => now(),
            'book_status' => BookStatus::Returned, // Assuming 'Laisva' is a valid status
        ]);

        // Increment the available quantity of the book
        $reservation->book->increment('book_count');

        return redirect()->route('reservations.index')->with('success', 'Book successfully marked as returned.');
    }
}
