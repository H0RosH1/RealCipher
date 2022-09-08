<?php

use App\Http\Controllers\RealCipherController;
use Illuminate\Support\Facades\Route;

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

Route::get('/', function () {
    return view('welcome');
});

Route::get('/realcipher', [RealCipherController::class, 'index']);

Route::get('/realcipher/home', [RealCipherController::class, 'home'])->name('home');

Route::post('/realcipher/saveplayer', [RealCipherController::class, 'saveplayer'])->name('saveplayer');

Route::middleware('checkplayer')->group(function () {

    Route::get('/realcipher/ingame', [RealCipherController::class, 'ingame'])->name('ingame');

    Route::post('/realcipher/ingame/checkAnswer', [RealCipherController::class, 'CheckAnswer'])->name('checkAnswer');
    Route::post('/realcipher/ingame/nextWord', [RealCipherController::class, 'nextWord'])->name('nextWord');

    Route::post('/realcipher/ingame/getRank', [RealCipherController::class, 'getRank'])->name('getRank');

    Route::get('/realcipher/endgame', [RealCipherController::class, 'endgame'])->name('endgame');

    Route::get('/realcipher/logout', [RealCipherController::class, 'logout'])->name('logout');


});

