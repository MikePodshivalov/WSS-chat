<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\RoomsController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MessagesController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
Auth::routes();

Route::group(['middleware' => ['auth']], function () {
    Route::get('/', [HomeController::class, 'index'])->name('home');
    Route::post('/messages/store', [MessagesController::class, 'store'])->name('messages.store');
    Route::post('/messages', [MessagesController::class, 'index'])->name('messages.index');

    Route::delete('/rooms', [RoomsController::class, 'exitUserFromRoom'])->name('rooms.exit');
});

Route::view('/send', 'chat');
Route::post('/send', function(Request $request) {
    $request->validate([
        'message' => 'required',
    ]);
    $message = [
        'message' => $request->message,
    ];
    broadcast(new App\Events\ChatEvent($message));
})->name('send');
