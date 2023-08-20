<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TripController;
use App\Http\Controllers\FlightController;
use App\Http\Controllers\AirlineController;
use App\Http\Controllers\AirportController;

Route::get('flights/{airline}/{number}', [FlightController::class, 'show']);
Route::put('flights/{airline}/{number}', [FlightController::class, 'update']);
Route::delete('flights/{airline}/{number}', [FlightController::class, 'destroy']);


Route::apiResources([
    'airlines' => AirlineController::class,
    'airports' => AirportController::class,
    'flights' => FlightController::class
]);

Route::get('trips', [TripController::class, 'search']);
