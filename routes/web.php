<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\OccurrenceController;
use App\Http\Controllers\GroupController;
use App\Http\Controllers\StatusController;
use App\Http\Controllers\MessageController;
use App\Http\Controllers\BombeiroController;
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
    Route::get('/getUserLocations/{user?}/{occurrence?}', [OccurrenceController::class, 'getUserLocations'])->name('occurrence.getUserLocations');
});

Route::prefix('groups')->group(function(){
    Route::get('/',[GroupController::class,'index'])->name('group.index');
    Route::post('/store',[GroupController::class, 'store'])->name('group.store');
    Route::get('/create',[GroupController::class,'create'])->name('group.create');
    Route::get('/edit/{group}',[GroupController::class,'show'])->name('group.edit');
    Route::post('/storeEdit/{group}',[GroupController::class,'edit'])->name('group.storeEdit');
    Route::post('/delete',[GroupController::class,'delete'])->name('group.delete');
});

Route::prefix('status')->group(function(){
    Route::get('/',[StatusController::class,'index'])->name('status.index');
    Route::post('/store',[StatusController::class, 'store'])->name('status.store');
});

Route::prefix('messages')->group(function(){
    Route::get('/',[MessageController::class,'index'])->name('message.index');
    Route::post('/store',[MessageController::class, 'store'])->name('message.store');
});

Route::prefix('bombeiros')->group(function (){
    Route::get('/',[BombeiroController::class,'index'])->name('bombeiro.index');
    Route::get('/create',[BombeiroController::class,'create'])->name('bombeiro.create');
    Route::post('/store',[BombeiroController::class,'store'])->name('bombeiro.store');
    Route::post('/delete',[BombeiroController::class,'delete'])->name('bombeiro.delete');
    Route::get('/edit/{user}',[BombeiroController::class,'edit'])->name('bombeiro.edit');
    Route::post('/save',[BombeiroController::class,'save'])->name('bombeiro.save');

});
