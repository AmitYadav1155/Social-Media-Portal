<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\FriendRequestController;
use App\Http\Controllers\FriendController;

Route::get('/', function () {
    return redirect('/dashboard');
});

// Route::get('/dashboard', function () {
//     return view('dashboard');
// })->middleware(['auth', 'verified'])->name('dashboard');

Route::get('/dashboard', [DashboardController::class, 'index'])
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::post('/friend-request/{id}/accept', [FriendRequestController::class, 'accept'])->name('friend.accept');
    Route::post('/friend-request/{id}/reject', [FriendRequestController::class, 'reject'])->name('friend.reject');

    Route::get('/friends', [FriendController::class, 'index'])->name('friends.index');
    Route::post('/friend-request/send/{receiverId}', [FriendController::class, 'sendRequest'])->name('friend.send');
    Route::delete('/friends/{id}', [FriendController::class, 'destroy'])->name('friend.delete');

});




require __DIR__.'/auth.php';
