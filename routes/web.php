<?php

use App\Http\Controllers\Settings;
use App\Http\Controllers\BookController;
use App\Http\Controllers\BorrowingController;
use App\Http\Controllers\LibrarianBookController;
use App\Http\Controllers\LibrarianReturnsController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
})->name('home');

// Public book routes (accessible to everyone)
Route::get('/books', [BookController::class, 'index'])->name('books.index');
Route::get('/books/available', [BookController::class, 'available'])->name('books.available');

// Dashboard - Different for authenticated and guest users
Route::get('/dashboard', function () {
    if (auth()->check()) {
        return view('dashboard');
    }
    // Redirect guests to available books
    return redirect()->route('books.available');
})->name('dashboard');

Route::middleware(['auth', 'verified'])->group(function () {
    Route::view('dashboard', 'dashboard')->name('dashboard');
});

Route::middleware(['auth'])->group(function () {
    Route::redirect('settings', 'settings/profile');

    Route::get('settings/profile', [Settings\ProfileController::class, 'edit'])->name('settings.profile.edit');
    Route::put('settings/profile', [Settings\ProfileController::class, 'update'])->name('settings.profile.update');
    Route::delete('settings/profile', [Settings\ProfileController::class, 'destroy'])->name('settings.profile.destroy');
    Route::get('settings/password', [Settings\PasswordController::class, 'edit'])->name('settings.password.edit');
    Route::put('settings/password', [Settings\PasswordController::class, 'update'])->name('settings.password.update');
    Route::get('settings/appearance', [Settings\AppearanceController::class, 'edit'])->name('settings.appearance.edit');
});

// Registered user borrowing routes
Route::middleware(['auth', 'role:registered'])->group(function () {
    Route::get('/borrowing', [BorrowingController::class, 'index'])->name('borrowing.index');
    Route::post('/borrowing/{book}', [BorrowingController::class, 'borrow'])->name('borrowing.borrow');
});

// Librarian routes
Route::middleware(['auth', 'role:librarian'])->group(function () {
    Route::resource('librarian/books', LibrarianBookController::class, ['names' => 'librarian.books']);
    Route::get('librarian/returns', [LibrarianReturnsController::class, 'index'])->name('librarian.returns.index');
    Route::post('librarian/returns/{reservation}/mark-returned', [LibrarianReturnsController::class, 'markReturned'])->name('librarian.returns.mark-returned');
});

require __DIR__.'/auth.php';
