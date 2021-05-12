<?php

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

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::prefix('occurrences')->group(function(){
    Route::get('/',[\App\Http\Controllers\OccurrenceController::class,'index'])->name('occurrence.index');
    Route::post('/store',[\App\Http\Controllers\OccurrenceController::class, 'store'])->name('occurrence.store');
});

Route::prefix('groups')->group(function(){
    Route::get('/',[\App\Http\Controllers\GroupController::class,'index'])->name('group.index');
    Route::post('/store',[\App\Http\Controllers\GroupController::class, 'store'])->name('group.store');
});

Route::prefix('status')->group(function(){
    Route::get('/',[\App\Http\Controllers\StatusController::class,'index'])->name('status.index');
    Route::post('/store',[\App\Http\Controllers\StatusController::class, 'store'])->name('status.store');
});
