<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\LocationController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\WasteCategoryController;
use App\Http\Controllers\WasteSubmissionController;
use App\Http\Controllers\WeatherController;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Route;
use Livewire\Volt\Volt;

Route::get('/', function () {
    return view('welcome');
})->name('home');

Route::middleware(['auth', 'verified', 'user'])
    ->group(function () {
        Route::get('/dashboard', [UserController::class, 'dashboard'])->name('dashboard');
        Route::post('/dashboard', [UserController::class, 'dashboard']); // untuk form input
        Route::get('/get-city-from-coordinates', [LocationController::class, 'getCityFromCoordinates']);
        Route::get('/waste-submission', [WasteSubmissionController::class,'submission'])->name('submission.form');
        Route::post('/waste-submission', [WasteSubmissionController::class, 'store'])->name('submission.store');
    });
Route::middleware(['auth', 'verified', 'admin'])
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {
        Route::resource('recommendations', WeatherController::class)->except(['show']);
        Route::resource('dashboard', DashboardController::class);
        Route::resource('waste-category', WasteCategoryController::class);
        Route::resource('users', UserController::class);
        Route::resource('waste-submission', WasteSubmissionController::class );
    });


Route::middleware(['auth'])->group(function () {
    Route::redirect('settings', 'settings/profile');

    Volt::route('settings/profile', 'settings.profile')->name('settings.profile');
    Volt::route('settings/password', 'settings.password')->name('settings.password');
    Volt::route('settings/appearance', 'settings.appearance')->name('settings.appearance');
});

require __DIR__.'/auth.php';


// Rute dashboard
// Route::get('/admin/dashboard', [DashboardController::class, 'index'])->name('admin.dashboard');

// // Grup untuk admin - jika kamu punya middleware is_admin, bisa tambahkan juga
// Route::middleware(['auth'])->prefix('admin')->group(function () {

//     // Waste Categories
//     Route::get('/waste-categories', [WasteCategoryController::class, 'index'])->name('admin.waste-categories');

//     // Waste Submissions
//     Route::get('/waste-submissions', [WasteSubmissionController::class, 'index'])->name('admin.waste-submissions');
//     Route::post('/waste-submissions', [WasteSubmissionController::class, 'store'])->name('admin.waste-submissions.store');
//     Route::post('/waste-submissions/{id}/verify', [WasteSubmissionController::class, 'verify'])->name('admin.waste-submissions.verify');
//     Route::post('/waste-submissions/{id}/status', [WasteSubmissionController::class, 'updateStatus'])->name('admin.waste-submissions.updateStatus');

//     // Users
//     Route::get('/users', [UserController::class, 'index'])->name('admin.users');
//     Route::get('/users/{id}', [UserController::class, 'show'])->name('admin.users.show');
//     Route::delete('/users/{id}', [UserController::class, 'destroy'])->name('admin.users.destroy');

//     // Point Redemptions
//     Route::get('/redemptions', [PointRedemptionController::class, 'index'])->name('admin.redemptions');
//     Route::post('/redemptions', [PointRedemptionController::class, 'store'])->name('admin.redemptions.store');
//     Route::post('/redemptions/{id}/approve', [PointRedemptionController::class, 'approve'])->name('admin.redemptions.approve');
//     Route::post('/redemptions/{id}/status', [PointRedemptionController::class, 'updateStatus'])->name('admin.redemptions.updateStatus');
// });
