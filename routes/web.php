<?php

use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\LeadsController;
use App\Http\Controllers\Admin\PhotosController;
use App\Http\Controllers\Admin\ProfileController;
use App\Http\Controllers\Admin\UsersController;
use App\Http\Controllers\Admin\CalendarController;
use App\Http\Controllers\BookingLeadController;
use App\Http\Controllers\HomeController;
use Illuminate\Support\Facades\Route;

Route::get('/', [HomeController::class, 'index']);
Route::get('/recensioni', [HomeController::class, 'allReviews'])->name('reviews.all');

Route::get('/lang/{locale}', function (string $locale) {
    if (in_array($locale, ['it', 'en', 'fr', 'es', 'de'])) {
        session(['locale' => $locale]);
    }
    return back();
})->name('lang.switch');

// Public booking lead capture
Route::post('/booking-lead', [BookingLeadController::class, 'store'])->name('booking.lead');

// Public: blocked dates for booking form validation
Route::get('/blocked-dates', function () {
    return response()->json(
        \App\Models\BlockedDate::orderBy('date')->pluck('date')
            ->map(fn($d) => \Carbon\Carbon::parse($d)->format('Y-m-d'))
    );
})->name('blocked.dates');

// Admin routes
Route::middleware(['auth', 'approved'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

    // Password change (accessible even if must_change_password)
    Route::get('/password/change', [ProfileController::class, 'showChangePassword'])->name('password.change');
    Route::post('/password/change', [ProfileController::class, 'changePassword'])->name('password.update');

    // Routes that require password already changed
    Route::middleware(['password.changed'])->group(function () {
        Route::get('/leads', [LeadsController::class, 'index'])->name('leads');
        Route::patch('/leads/{lead}/status', [LeadsController::class, 'updateStatus'])->name('leads.status');
        Route::delete('/leads/{lead}', [LeadsController::class, 'destroy'])->name('leads.destroy');

        Route::get('/photos', [PhotosController::class, 'index'])->name('photos');
        Route::post('/photos', [PhotosController::class, 'store'])->name('photos.store');
        Route::delete('/photos/{photo}', [PhotosController::class, 'destroy'])->name('photos.destroy');
        Route::post('/photos/reorder', [PhotosController::class, 'reorder'])->name('photos.reorder');
        Route::patch('/photos/{photo}/toggle', [PhotosController::class, 'toggle'])->name('photos.toggle');
        Route::patch('/photos/{photo}/alt', [PhotosController::class, 'updateAlt'])->name('photos.alt');

        Route::get('/visitors', [DashboardController::class, 'visitors'])->name('visitors');

        Route::get('/calendar', [CalendarController::class, 'index'])->name('calendar');
        Route::post('/calendar/block', [CalendarController::class, 'block'])->name('calendar.block');
        Route::post('/calendar/unblock-range', [CalendarController::class, 'unblockRange'])->name('calendar.unblock-range');
        Route::delete('/calendar/{blockedDate}', [CalendarController::class, 'unblock'])->name('calendar.unblock');

        Route::get('/users', [UsersController::class, 'index'])->name('users');
        Route::post('/users', [UsersController::class, 'store'])->name('users.store');
        Route::patch('/users/{user}', [UsersController::class, 'update'])->name('users.update');
        Route::patch('/users/{user}/approve', [UsersController::class, 'approve'])->name('users.approve');
        Route::delete('/users/{user}', [UsersController::class, 'destroy'])->name('users.destroy');
        Route::patch('/users/{user}/super', [UsersController::class, 'toggleSuperAdmin'])->name('users.super');
        Route::patch('/users/{user}/reset-password', [UsersController::class, 'resetPassword'])->name('users.reset-password');
    });
});
