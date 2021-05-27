<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\User\API\LogInController;
use App\Http\Controllers\User\API\InfoController;
use App\Http\Controllers\employeeListController;

use App\Http\Controllers\User\API\LogoutController;
use App\Http\Controllers\User\API\IntimeController;
use App\Http\Controllers\User\API\AttendanceController;
use App\Http\Controllers\User\API\OuttimeController;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\updateAttendanceInfoController;

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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

// szdfsdgsdfhdfhdfhdfh dfh dfh
//Route::view('login','pages.home');
//Route::get('login',[LogInController::class,'index'])->name('index');
Route::group(['middleware' => 'auth:sanctum'], function () {

    Route::post('logout', [logoutController::class, 'logOut'])->name('logOut');
    //Route::post('outtime',[OuttimeController::class,'outTime'])->name('outTime');

    Route::post('intime', [IntimeController::class, 'inTime'])->name('inTime');


    //Info Controller
    Route::get('employee/{emp_id?}', [InfoController::class, 'getInfo']);//get specific employee data
    Route::post('employee/update/{emp_id?}', [InfoController::class, 'updateInfo']);//update specific employee data

    //Attendance Controller
    //Get all Information
    //Route::post('attendance',[AttendanceController::class,'HistoryLogAPI']);
    //getCurrentAttendance
    //Route::post('current_attendance',[AttendanceController::class,'GetMonthLogAPI']);


    Route::post('current_attendance', [AttendanceController::class, 'GetMonthLogAPI']);

    Route::post('attendance', [AttendanceController::class, 'HistoryLogAPI']);
    Route::post('monthly_attendance', [AttendanceController::class, 'MonthEachDayAPI']);

    Route::post('outtime', [OuttimeController::class, 'outTime'])->name('outTime');
   // Route::post('updateAttendance',[updateAttendanceInfoController::class,'updateAttendanceInfo'])->name('updateAttendanceInfo');


});
//Route::post('current_attendance',[AttendanceController::class,'GetMonthLogAPI']);

Route::post('login',[LogInController::class,'logIn'])->name('logIn');
Route::post('signup',[LogInController::class,'signUp'])->name('signUp');
Route::post('updateAttendance',[updateAttendanceInfoController::class,'updateAttendanceInfo'])->name('updateAttendanceInfo');

Route::post('emp_create',[AdminController::class,'EmployeeCreate'])->name('EmployeeCreate');
Route::post('emp_update',[AdminController::class,'EmployeeUpdate'])->name('EmployeeUpdate');
Route::post('emp_delete',[AdminController::class,'EmployeeDelete'])->name('EmployeeDelete');

// Route::post('current_attendance',[AttendanceController::class,'GetMonthLogAPI']);
// Route::post('attendance',[AttendanceController::class,'HistoryLogAPI']);
// Route::post('monthly_attendance',[AttendanceController::class,'MonthEachDayAPI']);

/// By paresh in admin

    Route::get('employeeList', [employeeListController::class, 'showList'])->name('showList');
