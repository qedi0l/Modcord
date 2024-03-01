<?php

use App\Http\Controllers\ProfileController;
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

Route::get('/', [SeasonController::class, 'homeIndex']);

Route::get('/download', [SeasonController::class, 'download'])->name('season.download');
Route::get('/announcements', [SeasonController::class, 'announcements'])->name('season.announcement');


Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    
    Route::post('/profile/admin/new', [SeasonController::class, 'create'])->name('profile.admin.new');
    Route::get('/profile/admin/delete', [SeasonController::class, 'delete'])->name('season.delete');
    Route::post('/profile/admin/update', [SeasonController::class, 'update'])->name('profile.admin.update');
    Route::get('/profile/admin', [SeasonController::class, 'index'])->name('profile.admin');
    Route::get('/profile/admin/up', [SeasonController::class, 'MoveUp'])->name('profile.admin.up');
    Route::get('/profile/admin/down', [SeasonController::class, 'MoveDown'])->name('profile.admin.down');
    
});

require __DIR__.'/auth.php';
