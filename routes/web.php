<?php

use App\Http\Controllers\LoginController;
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

// Route::get('/', function () {
//     return redirect('/technicians');
// });

// Route::resource('technicians', 'TechnicianController');
// // ->middleware('auth');

// Route::resource('users', 'UserController')
// ->middleware('auth');

// Route::get('login', function () {
//     return 'Sorry you must be logged... This is the login!';
// })->name('login');

Route::post('login', [LoginController::class, 'authenticate'])->name('login');
