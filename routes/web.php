<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\MainController;

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
Route::get('/', [MainController::class, 'index'])->name('magic');

Route::group(['prefix' => 'magic', 'as' => 'magic.'], function () {
    Route::get('/', [MainController::class, 'index'])->name('home');
    Route::post('search', [MainController::class, 'search'])->name('search');
    Route::get('card/{id}', [MainController::class, 'details'])->name('card');
    Route::get('include/{id}', [MainController::class, 'include'])->name('include');
    Route::get('exclude/{id}', [MainController::class, 'exclude'])->name('exclude');
});
