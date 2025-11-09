<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\BookController;
use App\Http\Controllers\LibrarianController;
use App\Http\Controllers\ReservationController;
use App\Http\Controllers\WelcomeController;
use App\Http\Controllers\Settings;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// --- Public Routes ---
// Anyone can access these routes.
Route::get('/', [WelcomeController::class, 'index'])->name('home');

// Handles the PUBLIC parts of book viewing (the list and individual book details).
Route::resource('books', BookController::class)->only(['index', 'show', 'create']);

// --- General Authenticated Routes ---
// Any logged-in user can access these.
Route::view('dashboard', 'dashboard')->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware(['auth'])->group(function () {
    Route::redirect('settings', 'settings/profile');
    Route::get('settings/profile', [Settings\ProfileController::class, 'edit'])->name('settings.profile.edit');
    Route::put('settings/profile', [Settings\ProfileController::class, 'update'])->name('settings.profile.update');
    Route::delete('settings/profile', [Settings\ProfileController::class, 'destroy'])->name('settings.profile.destroy');
    Route::get('settings/password', [Settings\PasswordController::class, 'edit'])->name('settings.password.edit');
    Route::put('settings/password', [Settings\PasswordController::class, 'update'])->name('settings.password.update');
    Route::get('settings/appearance', [Settings\AppearanceController::class, 'edit'])->name('settings.appearance.edit');
});

Route::middleware(['auth', 'role:user|librarian'])->group(function () {
    Route::get('/librarian/reservations', [ReservationController::class, 'index'])->name('reservations.index');


});
Route::middleware(['auth', 'role:user'])->group(function () {
    Route::post('/librarian/reservations', [ReservationController::class, 'store'])->name('reservations.store');
    Route::get('/librarian/reservations/create', [ReservationController::class, 'create'])->name('reservations.create');

});
// --- Protected Routes for Staff ---
// Only Librarians and Admins can access these routes.
Route::middleware(['auth', 'role:librarian'])->group(function () {
    // This handles the PROTECTED parts: create, store, edit, update, destroy.
    // This is the line that makes the `/books/create` route exist for staff.
    Route::get('/books/create', [BookController::class, 'create'])->name('books.create');
    Route::resource('books', BookController::class)->except(['index', 'show']);

    // Routes for managing reservations.

    Route::patch('/librarian/reservations/{reservation}', [ReservationController::class, 'update'])->name('reservations.update');

    // Route for the librarian dashboard.
    Route::get('/librarian/dashboard', [LibrarianController::class, 'dashboard'])->name('librarian.dashboard');
});

// --- Admin-Only Routes ---
// Only Admins can access these routes.
Route::middleware(['auth', 'role:admin'])->group(function () {
    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');
    Route::get('/librarians/create', [AdminController::class, 'createLibrarian'])->name('admin.librarian.create');
    Route::post('/librarians', [AdminController::class, 'storeLibrarian'])->name('admin.librarian.store');
});

// --- Authentication Routes ---
// Handles login, registration, etc.
require __DIR__.'/auth.php';
