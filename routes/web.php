<?php

use App\Http\Controllers\AllergeenController;
use App\Http\Controllers\LeveringController;
use App\Http\Controllers\MagazijnController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {

    Route::get('/profile', [ProfileController::class, 'edit'])
        ->name('profile.edit');

    Route::patch('/profile', [ProfileController::class, 'update'])
        ->name('profile.update');

    Route::delete('/profile', [ProfileController::class, 'destroy'])
        ->name('profile.destroy');
});

Route::middleware(['auth', 'magazijnmedewerker'])->group(function () {

    Route::get('/magazijn', [MagazijnController::class, 'index'])
        ->name('magazijn.index');

    Route::get('/levering/{id}', [LeveringController::class, 'show'])
        ->name('levering.show');

    Route::get('/allergeen/{id}', [AllergeenController::class, 'show'])
        ->name('allergeen.show');
});

require __DIR__.'/auth.php';
