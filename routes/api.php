<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});


Route::post('login',[\App\Http\Controllers\API\AuthController::class,'login']);
Route::post('attachPlayerIDtoLoggedUser', [\App\Http\Controllers\API\AuthController::class, 'attachPlayerIDtoLoggedUser'])->middleware('auth:api');
Route::post('getUserInfo', [\App\Http\Controllers\API\OccurrenceController::class, 'getUserInfo'])->middleware('auth:api');
Route::post('getAverageArriveTime', [\App\Http\Controllers\API\OccurrenceController::class, 'getAverageArriveTime'])->middleware('auth:api');


Route::post('getOccurrences',[\App\Http\Controllers\API\OccurrenceController::class, 'getOcurrences'])->middleware('auth:api');
Route::post('saveLastPosition',[\App\Http\Controllers\API\AuthController::class,'saveLastPosition'])->middleware('auth:api');
Route::post('occurrenceOpened',[\App\Http\Controllers\API\OccurrenceController::class,'occurrenceOpened'])->middleware('auth:api');
Route::post('updateOccurrenceUserLocation',[\App\Http\Controllers\API\OccurrenceController::class,'updateOccurrenceUserLocation'])->middleware('auth:api');


//ACCEPT AND REJECT OCCURRENCES
Route::post('acceptOccurrence',[\App\Http\Controllers\API\OccurrenceController::class,'acceptOccurrence'])->middleware('auth:api');
Route::post('rejectOccurrence',[\App\Http\Controllers\API\OccurrenceController::class,'rejectOccurrence'])->middleware('auth:api');



//DASHBOARD
Route::get('countAcceptedOccurrences',[\App\Http\Controllers\API\OccurrenceController::class,'countAcceptedOccurrences'])->middleware('auth:api');
Route::get('countRefusedOccurrences',[\App\Http\Controllers\API\OccurrenceController::class,'countRefusedOccurrences'])->middleware('auth:api');
Route::get('occurrencesAcceptedByMonth',[\App\Http\Controllers\API\OccurrenceController::class,'occurrencesAcceptedByMonth'])->middleware('auth:api');
