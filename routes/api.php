<?php

use Illuminate\Http\Request;
use App\Technician;
use App\Http\Controllers\JobController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\CityController;
use App\Http\Controllers\MessageController;
use App\Http\Controllers\AddressController;
use App\Http\Controllers\RankingController;
use App\Http\Controllers\TechnicianController;
use App\Http\Controllers\ProfessionController;
use App\Http\Controllers\Technician_professionController;


/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

// Route::middleware('auth:api')->get('/user', function (Request $request) {
//     return $request->user();
// });

// Route::get('/index', function() {
//     return Technician::all()->where('available', 1);
// });

//Technican routes
Route::get('index', [TechnicianController::class, 'index'])->middleware('auth:sanctum')->name('index');
Route::post('technician', [TechnicianController::class, 'store'])->name('technician.store');
Route::get('technician/{id}', [TechnicianController::class, 'show'])->middleware('auth:sanctum')->name('technician.show');
Route::put('technician/{id}',[TechnicianController::class, 'update'])->name('technician.update');
Route::delete('technician/{id}',[TechnicianController::class, 'destroy'])->name('technician.destroy');

//User routes
Route::post('user', [UserController::class, 'store'])->name('user.store');
Route::get('user/{email}',[UserController::class, 'show'])->middleware('auth:sanctum')->name('user.show');
Route::put('user/{id}', [UserController::class, 'update'])->name('user.update');
Route::delete('user/{id}', [UserController::class, 'destroy'])->name('user.destroy');

//Address routes
Route::post('address', [AddressController::class, 'store'])->name('address.store');
Route::get('address/{id}', [AddressController::class, 'show'])->name('address.show');
Route::put('address/{id}', [AddressController::class, 'update'])->name('address.update');
Route::delete('address/{id}', [AddressController::class, 'destroy'])->name('address.destroy');

//Job routes
Route::post('job', [JobController::class, 'store'])->name('job.store');
Route::get('job/{id}', [JobController::class, 'show'])->middleware('auth:sanctum')->name('job.show');
Route::put('job/{id}', [JobController::class, 'update'])->name('job.update');
Route::delete('job/{id}', [JobController::class, 'destroy'])->name('job.destroy');
Route::post('job/rank',[JobController::class, 'rankCommentJob'])->name('job.rankJob');

//Tech_professions routes
Route::get('tp/{id}', [Technician_professionController::class, 'show'])->middleware('auth:sanctum')->name('tech_prof.show');
Route::post('tp', [Technician_professionController::class, 'store'])->name('tech_prof.store');
Route::delete('tp/{id}', [Technician_professionController::class, 'destroy'])->name('tech_prof.destroy');


//Ranking routes
Route::post('ranking', [RankingController::class,'store'])->name('ranking.store');
Route::get('rankings',[RankingController::class,'index'])->name('ranking.index');
Route::get('ranking/{id}', [RankingController::class,'show'])->middleware('auth:sanctum')->name('ranking.show');
Route::delete('ranking/{id}',[RankingController::class, 'destroy'])->name('ranking.destroy');

//City routes
Route::get('cities', [CityController::class, 'index'])->name('city.index');

//professions routes
Route::get('professions', [ProfessionController::class, 'index'])->name('professions.index');

