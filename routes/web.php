<?php

use App\Http\Controllers\AccesspointController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\BackupdatabaseController;
use App\Http\Controllers\ExportFilesController;
use App\Http\Controllers\FirstLoginController;
use App\Http\Controllers\ManageDeviceController;
use App\Http\Controllers\ManageuserController;
use App\Http\Controllers\api\v1\ApPieController;
use App\Http\Controllers\api\v1\ApStatisticController;
use App\Http\Controllers\api\v1\ApStatusController;
use App\Http\Controllers\ReportController;
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
Route::middleware(['auth', 'isLoggedIn'])->group(function () {
    Route::get('/exports/weekly', [ExportFilesController::class, 'export'])->name('weeklyexports');
    Route::get('/exports/weeklypeaks', [ExportFilesController::class, 'exportPeakCapacity'])->name('weeklypeakexports');
    Route::get('exports/peaksdate', [ExportFilesController::class, 'exportPeaksCapacityWithDates'])->name('weeklypeaksexportswithdates');
});
Route::middleware(['preventBackHistory'])->group(function () {
    Route::middleware(['isNotFirstLogin'])->group(function () {
        require __DIR__ . '/auth.php';
        Route::middleware(['auth', 'isLoggedIn'])->group(function () {

            Route::get('/appieinfo',[ApPieController::class,'index']);
            Route::get('/apstatistic',[ApStatisticController::class,'index']);
            Route::get('/apstatus',[ApStatusController::class,'index']);


            Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
            // Route::get('/livetabledata',[DashboardController::class,'livedata'])->name('dashboard.table');
            Route::get('/accesspoints', [AccesspointController::class, 'index'])->name('accesspoint');
            Route::get('/accesspointgraph/device', [AccesspointController::class, 'view'])->name('accesspointgraph');
            Route::get('/reports', [ReportController::class, 'index'])->name('reports');
            Route::get('/reports/range', [ReportController::class, 'export'])->name('export');
            Route::get('/devices', [ManageDeviceController::class, 'index'])->name('devices');
            Route::get('/devices/{id}', [ManageDeviceController::class, 'edit'])->name('devices.edit');
            Route::patch('/devices/{id}/update', [ManageDeviceController::class, 'update'])->name('devices.update');
            Route::prefix('admin')->middleware(['isAdmin'])->group(function () {
                Route::get('backups', [BackupdatabaseController::class, 'index'])->name('backup');
                Route::get('backups/dbdump', [BackupdatabaseController::class, 'forceBackUp'])->name('backup.dbdump');
                Route::get('backups/{file}', [BackupdatabaseController::class, 'download'])->name('backup.download');
                Route::get('manageusers', [ManageuserController::class, 'index'])->name('admin.manageuser');
                Route::get('edituser/{id}/edit', [ManageuserController::class, 'edit'])->name('admin.edituser');
                Route::get('createuser', [ManageuserController::class, 'createUser'])->name('admin.createuser');
                Route::delete('delete/{id}', [ManageuserController::class, 'delete'])->name('admin.deleteuser');
                Route::post('edituser', [ManageuserController::class, 'resetPassword'])->name('admin.resetpass');
                Route::patch('edituser/{id}/update', [ManageuserController::class, 'updateUser'])->name('admin.updateuser');
            });
        });
    });


    Route::middleware('isFirstLogin')->group(function () {
        // Route::get('register', [RegisteredUserController::class, 'create'])
        //     ->name('register');
        Route::get('/setup', [FirstLoginController::class, 'create'])->name('firstlogin');
        Route::post('/store', [FirstLoginController::class, 'store'])->name('firstsignup');
    });
});
