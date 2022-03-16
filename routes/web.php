<?php

use App\Http\Controllers\AccesspointController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\FirstLoginController;
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

   Route::middleware(['isNotFirstLogin'])->group(function(){
    Route::middleware(['auth','isLoggedIn'])->group(function(){
        Route::get('/',[DashboardController::class,'index'])->name('dashboard');
        // Route::get('/livetabledata',[DashboardController::class,'livedata'])->name('dashboard.table');

        Route::get('/accesspoints',[AccesspointController::class,'index'])->name('accesspoint');

        Route::middleware(['isAdmin'])->group(function(){
            Route::get('/admin/manageusers',[ManageuserController::class,'index'])->name('admin.manageuser');
            Route::get('/admin/edituser/{id}/edit',[ManageuserController::class,'edit'])->name('admin.edituser');
            Route::get('/admin/createuser',[ManageuserController::class,'createUser'])->name('admin.createuser');
            Route::delete('/admin/delete/{id}',[ManageuserController::class,'delete'])->name('admin.deleteuser');
            Route::post('/admin/edituser',[ManageuserController::class,'resetPassword'])->name('admin.resetpass');
            Route::patch('/admin/edituser/{id}/update',[ManageuserController::class,'updateUser'])->name('admin.updateuser');
        });
    

    });
});    

Route::middleware('isFirstLogin')->group(function(){

        // Route::get('register', [RegisteredUserController::class, 'create'])
        //     ->name('register');
            Route::get('/setup',[FirstLoginController::class,'create'])->name('firstlogin');
            Route::post('/store',[FirstLoginController::class,'store'])->name('firstsignup');
        });
        
        
    

});




