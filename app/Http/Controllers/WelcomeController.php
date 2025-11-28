<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Reservation;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Schema;
use Illuminate\View\View;

class WelcomeController extends Controller
{
    /**
     * Show the welcome page with books info and (for regular users) upcoming-return reminders.
     */
    public function index(Request $request): View
    {
        // Basic books data (kept from your original WelcomeController)
        $books = Book::all();
        $booksCount = $books->count();

        // Reminder data for logged-in regular users
        $user = $request->user();
        $daysWindow = 7; // per kiek dienų laikome "artimu laiku"
        $dueReservations = collect();

        if ($user && $user->hasRole('user')) {
            $soon = Carbon::now()->addDays($daysWindow);

            $query = Reservation::with('book')
                ->where('user_id', $user->id)
                ->where('return_date', '<=', $soon->endOfDay());

            // Jei lentelėje yra žymėjimas, ar grąžinta, atmesame jau grąžintas
            if (Schema::hasColumn('reservations', 'returned_at')) {
                $query->whereNull('returned_at');
            } elseif (Schema::hasColumn('reservations', 'is_returned')) {
                $query->where('is_returned', false);
            }

            $dueReservations = $query->orderBy('return_date')->get();
        }

        return view('welcome', [
            'books' => $books,
            'booksCount' => $booksCount,
            'dueReservations' => $dueReservations,
            'daysWindow' => $daysWindow,
        ]);
    }
}
