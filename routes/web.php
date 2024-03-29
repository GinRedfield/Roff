<?php

use App\Http\Controllers\ProfileController;
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

Route::resource('stocks', 'App\Http\Controllers\StockController')->middleware(['auth', 'verified']);

Route::post('forums/indexView', 'App\Http\Controllers\ForumController@indexView')->middleware(['auth', 'verified'])->name('forums.indexView');
Route::resource('forums','App\Http\Controllers\ForumController')->middleware(['auth', 'verified']);

Route::get('/dashboard', 'App\Http\Controllers\StockController@dashboard')->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
