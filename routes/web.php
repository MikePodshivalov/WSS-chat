<?php

use App\Events\MyEvent;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\RoomController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MessageController;

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
    Route::post('/message/store', [MessageController::class, 'store'])->name('message.store');
    Route::post('/message', [MessageController::class, 'index'])->name('message.index');

    Route::delete('/room', [RoomController::class, 'exitUserFromRoom'])->name('room.exit');
});

