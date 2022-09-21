<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

use App\Http\Controllers\AuthController; //my authcontroller
use App\Http\Controllers\UserController;
use App\Http\Middleware\SuperAdmin;
use App\Http\Controllers\CE\DepartmentController;
use App\Http\Controllers\CE\ExamController;
use App\Http\Controllers\CE\HodController;

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
        if ($user->hasRole('superadmin')) return redirect('superadmin');
        else if ($user->hasRole('controller')) return redirect('controller');
        else if ($user->hasRole('hod')) return redirect('hod');
        else if ($user->hasRole('instructor')) return redirect('instructor');
        else return redirect('student');
    } else
        return view('index');
});

Auth::routes();
Route::post('login', [AuthController::class, 'login']);
Route::post('verify/step2', [AuthController::class, 'verify_step2']);

Route::group(['middleware' => 'controller'], function () {
    Route::view('controller', 'CE.index');
    Route::resource('departments', DepartmentController::class);
    Route::resource('hods', HodController::class);
    Route::resource('exams', ExamController::class);
});
