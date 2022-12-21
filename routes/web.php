<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LendingController;

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

Route::get('/', [LendingController::class, 'index'])->name('/');
Route::post('/store', [LendingController::class, 'store'])->name('/store');
Route::delete('/destroy/{id}', [LendingController::class, 'destroy'])->name('/store');
Route::patch('/update/{id}', [LendingController::class, 'update'])->name('/store');

// Route::get('/lending', function () {
//     return view('laptop.lending');
// });
