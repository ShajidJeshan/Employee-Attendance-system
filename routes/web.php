<?php

use Illuminate\Support\Facades\Route;

//User Controller
use App\Http\Controllers\User\API\LogInController;
use App\Http\Controllers\User\UserDashboardController;
use App\Http\Controllers\User\UserProfileController;
use App\Http\Controllers\User\UserHistoryController;
use App\Http\Controllers\User\UserLoginController;
use App\Http\Controllers\EmployeeManagementController;

//Admin Controller
use App\Http\Controllers\Admin\AdminController;
use App\Mail\WelcomeMail;
use Illuminate\Support\Facades\Mail;
use App\Http\Controllers\Admin\EmployeeManageController;

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

// User Routes
Route::get('/',[LogInController::class,'userLogin'])->name('userLogin');
Route::get('/dashboard',[UserDashboardController::class,'userDashboard'])->name('userDashboard');
Route::get('/history',[UserHistoryController::class,'userHistory'])->name('userHistory');
Route::get('/profile',[UserProfileController::class,'userProfile'])->name('userProfile');
Route::get('/create',[EmployeeManagementController::class,'index'])->name('index');
Route::get('/profile/edit',[UserProfileController::class,'userProfileEdit'])->name('userProfileEdit');
Route::patch('/profile',[UserProfileController::class,'userProfileUpdate'])->name('userProfileUpdate');
Route::post('/loginUser',[UserLoginController::class,'loginUser'])->name('loginUser');
Route::post('/logout',[UserLogoutController::class,'userLogout'])->name('userLogout');

// Admin Routes
Route::get('/admin',[AdminController::class,'adminLogin'])->name('adminLogin');
Route::get('/admin/employees',[EmployeeManageController::class,'index'])->name('index');
// Route::get('/admin/employees/edit',[EmployeeManageController::class,'editEmployee'])->name('editEmployee');
Route::get('/admin/employees/create',[EmployeeManageController::class,'createEmployee'])->name('createEmployee');
Route::get('/admin/employees/profile',[EmployeeManageController::class,'showEmployeeProfile'])->name('showEmployeeProfile');

// Route::get('/email', function(){
//     Mail::to('email@email.com')->send(new WelcomeMail());
//     return new WelcomeMail();
// })
?>
