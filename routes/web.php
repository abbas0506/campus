<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

use App\Http\Controllers\AuthController; //my authcontroller
use App\Http\Controllers\UserController;


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
Route::get('login/secondfactor', [AuthController::class, 'view_second_factor']);

Route::group(['middleware' => 'superadmin'], function () {
    Route::view('superadmin', 'superadmin.index');
    Route::view('departments', 'superadmin.departments.index');
});
