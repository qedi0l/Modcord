<?php

use App\Http\Controllers\AnnouncementsController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\RequestsController;
use App\Http\Controllers\SeasonController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

Route::get('/', [SeasonController::class, 'homeShow'])->name('/');
Route::get('/test', [SeasonController::class, 'Test']);

Route::middleware('downloadLimiter')->group(function () 
{
    Route::get('/download', [SeasonController::class, 'download'])->name('season.download');
});

Route::get('/announcements', [AnnouncementsController::class, 'index'])->name('announcements.index');

// Requests
Route::get('/request/{UUID}', [RequestsController::class, 'index'])->name('requests');
Route::post('/request/new', [RequestsController::class, 'create'])->name('requests.create');
Route::get('/request/delete/{UUID}', [RequestsController::class, 'delete'])->name('requests.delete');

// Auth required
Route::middleware('auth')->group(function () 
{
    // Account
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Card actions
    Route::post('/profile/admin/new', [SeasonController::class, 'create'])->name('profile.admin.new');
    Route::post('/profile/admin/delete', [SeasonController::class, 'delete'])->name('profile.admin.delete');
    Route::post('/profile/admin/update', [SeasonController::class, 'update'])->name('profile.admin.update');
    
    Route::post('/profile/admin/up', [SeasonController::class, 'moveUp'])->name('profile.admin.up');
    Route::post('/profile/admin/down', [SeasonController::class, 'moveDown'])->name('profile.admin.down');

    // Admin panel
    Route::get('/profile/admin', [SeasonController::class, 'adminShow'])->name('profile.admin');
    
    // Requests panel
    Route::get('/profile/requests', [RequestsController::class, 'show'])->name('profile.requests');
    Route::post('/profile/requests/update', [RequestsController::class, 'update'])->name('profile.requests.update');

});

require __DIR__.'/auth.php';
