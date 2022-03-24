<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\api\v1\LiveAccessPointsStatistic;
use App\Http\Controllers\api\v1\AccessPointGraphData;
use App\Http\Controllers\api\v1\ApPieController;
use App\Http\Controllers\api\v1\ApStatisticController;
use App\Http\Controllers\api\v1\ApStatusController;

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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('/apstatistic',[ApStatisticController::class,'index']);
Route::get('/apstatus',[ApStatusController::class,'index']);
Route::get('/appieinfo',[ApPieController::class,'index']);

