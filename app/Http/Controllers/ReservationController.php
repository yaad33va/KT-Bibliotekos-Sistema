<?php

namespace App\Http\Controllers;

use App\Models\Reservation;
use App\Enums\BookStatus; // Assuming your enum is here
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class ReservationController extends Controller
{
    /**
     * Display a listing of active reservations for the librarian.
     */
    public function index(): View
    {
        $activeReservations = Reservation::with(['user', 'book'])
            ->whereNull('returned_at') // Active reservations are those not yet returned
            ->latest('reservation_date') // Sort by the correct date column
            ->paginate(15);

        return view('librarian.reservations.index', compact('activeReservations'));
    }

    /**
     * Mark a reservation as returned.
     */
    public function update(Reservation $reservation): RedirectResponse
    {
        // Check if the book has already been marked as returned to prevent errors
        if ($reservation->returned_at) {
            return redirect()->route('reservations.index')->withErrors(['error' => 'Ši rezervacija jau buvo uždaryta.']);
        }

        // Update the reservation record
        $reservation->update([
            'returned_at' => now(),
            'book_status' => BookStatus::Returned, // Assuming 'Laisva' is a valid status in your BookStatus enum
        ]);

        // Increment the available quantity of the book
        $reservation->book->increment('quantity');

        return redirect()->route('reservations.index')->with('success', 'Knyga sėkmingai pažymėta kaip grąžinta.');
    }
}
