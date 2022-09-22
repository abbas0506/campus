<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

use App\Http\Controllers\AuthController; //my authcontroller
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\Admin\DepartmentController;
use App\Http\Controllers\CE\ExamController;
use App\Http\Controllers\Admin\HodController;
use App\Http\Controllers\HodAssignmentController;

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

Route::get('/', function () {
    if (Auth::check()) {
        $user = Auth::user();
        if ($user->hasRole('admin')) return redirect('admin');
        else if ($user->hasRole('ce')) return redirect('ce');
        else if ($user->hasRole('hod')) return redirect('hod');
        else if ($user->hasRole('instructor')) return redirect('instructor');
        else return redirect('student');
    } else
        return view('index');
});

Auth::routes();
Route::post('login', [AuthController::class, 'login']);
Route::post('verify/step2', [AuthController::class, 'verify_step2']);

Route::group(['middleware' => 'admin'], function () {
    Route::view('admin', 'admin.index');
    Route::resource('users', UserController::class);
    Route::resource('departments', DepartmentController::class);
    Route::resource('hods', HodController::class);
    // Route::resource('hodassignment', HodAssignmentController::class);

    Route::get('assign/hod/{id}', [HodController::class, 'assign']);
    Route::post('post/assign/hod', [HodController::class, 'post_assign']);
});
Route::group(['middleware' => 'controller'], function () {
    Route::view('controller', 'ce.index');
    Route::resource('exams', ExamController::class);
});
