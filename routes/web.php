<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\OccurrenceController;
use App\Http\Controllers\GroupController;
use App\Http\Controllers\StatusController;
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

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::prefix('occurrences')->group(function(){
    Route::get('/',[OccurrenceController::class,'index'])->name('occurrence.index');
    Route::post('/store',[OccurrenceController::class, 'store'])->name('occurrence.store');
    Route::get('/getAutoMessages/{group?}',[OccurrenceController::class, 'getAutoMessages'])->name('occurence.getAutoMessages');
    Route::get('/show/{occurrence}',[OccurrenceController::class, 'show'])->name('occurrence.show');
});

Route::prefix('groups')->group(function(){
    Route::get('/',[GroupController::class,'index'])->name('group.index');
    Route::post('/store',[GroupController::class, 'store'])->name('group.store');
});

Route::prefix('status')->group(function(){
    Route::get('/',[StatusController::class,'index'])->name('status.index');
    Route::post('/store',[StatusController::class, 'store'])->name('status.store');
});

Route::prefix('messages')->group(function(){
    Route::get('/',[MessageController::class,'index'])->name('message.index');
    Route::post('/store',[MessageController::class, 'store'])->name('message.store');
});
