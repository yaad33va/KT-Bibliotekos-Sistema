<?php

use App\Http\Controllers\AdminController; // Add this line
use App\Http\Controllers\WelcomeController;
use App\Http\Controllers\Settings;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BookController;

Route::get('/', [WelcomeController::class, 'index'])->name('home');

Route::get('books', [BookController::class, 'index'])->name('books.index'); // Added this line

// Admin Routes - Grouped and protected by 'auth' and role middleware
Route::middleware(['auth', 'role:admin'])->group(function () {
    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');
    Route::get('/librarians/create', [AdminController::class, 'createLibrarian'])->name('admin.librarian.create');
    Route::post('/librarians', [AdminController::class, 'storeLibrarian'])->name('admin.librarian.store');
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

require __DIR__.'/auth.php';
