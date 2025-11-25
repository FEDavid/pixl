<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UploadController;
use App\Http\Controllers\LikesController;
use App\Http\Controllers\MailController;

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application.
|
*/

// Standard pages with no verification
Route::get('/', [UploadController::class, 'index'])->name('uploads.index');

// Upload routes [No auth]
Route::get('/uploads', [UploadController::class, 'index'])->name('uploads.index');

// FIX: Place create BEFORE /uploads/{hostedImage}
Route::middleware('auth')->group(function () {
    // Dashboard route - adjusted to include UploadController
    Route::get('/dashboard', [UploadController::class, 'dashboard'])->name('dashboard');

    // Profile routes
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Upload routes [Auth]
    Route::get('/uploads/create', [UploadController::class, 'create'])->name('uploads.create');
    Route::post('/uploads', [UploadController::class, 'store'])->name('uploads.store');
    Route::put('/uploads/{hostedImage}', [UploadController::class, 'update'])->name('uploads.update');
    Route::delete('/uploads/{hostedImage}', [UploadController::class, 'destroy'])->name('uploads.destroy');

    // Show routes [For applying likes and disliking)
    Route::post('/uploads/{hostedImage}/like', [LikesController::class, 'add_like'])->name('uploads.like');
    Route::post('/uploads/{hostedImage}/dislike', [LikesController::class, 'remove_like'])->name('uploads.dislike');
});

// Public wildcard route placed *after* the protected routes
Route::get('/uploads/{hostedImage}', [UploadController::class, 'show'])->name('uploads.show');

// TESTING
// For testing upload limits have increased correctly
// Route::get('/phpinfo-test', function () {
//     return [
//         'upload_max_filesize' => ini_get('upload_max_filesize'),
//         'post_max_size' => ini_get('post_max_size'),
//     ];
// });

// Testing mail route
Route::get('send-mail', [MailController::class, 'index']);

// Auth middleware
require __DIR__.'/auth.php';
