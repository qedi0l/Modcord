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
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', [SeasonController::class, 'homeIndex'])->name('/');

Route::middleware('downloadLimiter')->group(function () 
{
    Route::get('/download', [SeasonController::class, 'download'])->name('season.download');
});

Route::get('/announcements', [AnnouncementsController::class, 'index'])->name('announcements.index');

Route::get('/request/{UUID}', [RequestsController::class, 'index'])->name('requests');
Route::post('/request/new', [RequestsController::class, 'create'])->name('requests.create');
Route::get('/request/delete/{UUID}', [RequestsController::class, 'delete'])->name('requests.delete');

Route::middleware('auth')->group(function () 
{
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::post('/profile/admin/new', [SeasonController::class, 'create'])->name('profile.admin.new');
    Route::get('/profile/admin/delete', [SeasonController::class, 'delete'])->name('season.delete');
    Route::post('/profile/admin/update', [SeasonController::class, 'update'])->name('profile.admin.update');

    Route::get('/profile/admin', [SeasonController::class, 'index'])->name('profile.admin');
    Route::get('/profile/admin/up', [SeasonController::class, 'MoveUp'])->name('profile.admin.up');
    Route::get('/profile/admin/down', [SeasonController::class, 'MoveDown'])->name('profile.admin.down');

    Route::get('/profile/requests', [RequestsController::class, 'show'])->name('profile.requests');
    Route::post('/profile/requests/update', [RequestsController::class, 'update'])->name('profile.requests.update');
});

require __DIR__.'/auth.php';
