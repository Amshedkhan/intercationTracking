<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\InteractionController;
/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/
Route::group([
    
    'prefix' => 'auth'

], function ($router) {

    Route::post('login', [AuthController::class,'login']);
    Route::post('signup', [AuthController::class,'signup']);
    Route::post('logout', [AuthController::class, 'logout']);
   
});
Route::group(['middleware' => 'jwt.auth'], function () {
    Route::resource('/interaction', InteractionController::class);
    Route::get('/interaction-statistics', [InteractionController::class, 'getInteractionStatistics']);

    Route::get('/interaction-statistics/{start_date}/{end_date}', [InteractionController::class, 'searchInteractionStatistics']);
    // ->where(['start_date' => 'date', 'end_date' => 'date|after_or_equal:start_date']);
});

