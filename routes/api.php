<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\api\v1\LiveAccessPointsStatistic;
use App\Http\Controllers\api\v1\AccessPointGraphData;
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



Route::get('/liveapdata',[LiveAccessPointsStatistic::class,'livedata']);
Route::get('/apstatus',[AccessPointGraphData::class,'index']);
Route::get('/appieinfo',[AccessPointGraphData::class,'pieChart']);

