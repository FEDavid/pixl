<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UploadController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

// Standard pages with no verification
Route::get('/', [UploadController::class, 'index'])->name('uploads.index');

// Upload routes [No auth]
Route::get('/uploads', [UploadController::class, 'index'])->name('uploads.index');
Route::get('/uploads/{hostedImage}', [UploadController::class, 'show'])->name('uploads.show');

// Verified logins
// Using group function to apply auth middleware for all required authenticated routes
Route::middleware('auth')->group(function () {
    // Dashboard route
    Route::get('/dashboard', function () {return view('dashboard');})->middleware(['verified'])->name('dashboard');

    // Profile routes
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Upload routes [Auth]
    Route::get('/uploads/create', [UploadController::class, 'create'])->name('uploads.create');
    Route::post('/uploads', [UploadController::class, 'store'])->name('uploads.store');
    Route::get('/uploads/{hostedImage}/edit', [UploadController::class, 'edit'])->name('uploads.edit');
    Route::put('/uploads/{hostedImage}', [UploadController::class, 'update'])->name('uploads.update');
    Route::delete('/uploads/{hostedImage}', [UploadController::class, 'destroy'])->name('uploads.destroy');
});

// Making sure auth.php middleware has been called for usage
require __DIR__.'/auth.php';
