<?php

use App\Http\Controllers\AccesspointController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\ManageuserController;
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

Route::middleware(['preventBackHistory'])->group(function(){

    require __DIR__.'/auth.php';
    Route::middleware(['auth'])->group(function(){
        Route::get('/',[DashboardController::class,'index'])->name('dashboard');
        Route::get('/accesspoints',[AccesspointController::class,'index'])->name('accesspoint');
        Route::get('/manageusers',[ManageuserController::class,'index'])->name('manageuser');

    });



});




