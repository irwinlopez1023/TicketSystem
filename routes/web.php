<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Tickets\Users\UserTicketController;
use Illuminate\Support\Facades\Route;

Route::Resource('tickets', UserTicketController::class)->middleware('auth')->names('user.tickets');
Route::post('tickets/{ticket}/reply', [UserTicketController::class, 'reply'])->middleware('auth')->name('user.tickets.reply');
Route::put('tickets/{ticket}/close', [UserTicketController::class, 'close'])->middleware('auth')->name('user.tickets.close');



Route::get('/test', function () {
    return view('test');
});

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
