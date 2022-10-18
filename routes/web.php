<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

use App\Http\Controllers\AuthController; //my authcontroller
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\Admin\DepartmentController;
use App\Http\Controllers\Admin\DepartmentHodController;
use App\Http\Controllers\hod\EnrollmentController;
use App\Http\Controllers\CE\ExamController;
use App\Http\Controllers\Admin\HodController;
use App\Http\Controllers\hod\CourseAllocationController;
use App\Http\Controllers\hod\examinerController;
use App\Http\Controllers\Hod\ProgramController;
use App\Http\Controllers\Hod\CourseController;
use App\Http\Controllers\hod\DepartmentSessionController;
use App\Http\Controllers\hod\teacherController;
use App\Http\Controllers\hod\ResultController;
use App\Http\Controllers\hod\SchemeController;
use App\Http\Controllers\hod\StudentController;
use App\Http\Controllers\ProgramShiftController;
use App\Http\Controllers\Admin\SemesterController;
use App\Http\Controllers\hod\ElectiveCourseAllocationController;
use App\Http\Controllers\hod\CourseAllocationOptionController;
use App\Http\Controllers\hod\ClassController;
use App\Http\Controllers\hod\ClassOptionsController;
use App\Http\Controllers\hod\SchemeDetailController;
use App\Http\Controllers\hod\SectionController;
use App\Http\Controllers\hod\SectionOptionsController;
use App\Http\Controllers\LoginOptionsController;

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
        if ($user->roles->count() > 1)
            return redirect('login-options');
        else
            return redirect($user->roles->first()->name);
    } else
        return view('index');
});

// Auth::routes();
Route::post('login', [AuthController::class, 'login']);
Route::post('verify/step2', [AuthController::class, 'verify_step2']);
Route::resource('login-options', LoginOptionsController::class)->only('index', 'store');
Route::resource('section-options', SectionOptionsController::class)->only('index', 'store');
Route::get('signout', [AuthController::class, 'signout'])->name('signout');


Route::group(['middleware' => ['role:admin']], function () {
    Route::view('admin', 'admin.index');
    Route::resource('users', UserController::class);
    Route::resource('roles', RoleController::class);
    Route::resource('semesters', SemesterController::class);
    Route::resource('departments', DepartmentController::class);
    Route::resource('departmenthods', DepartmentHodController::class);
});
Route::group(['middleware' => ['role:controller']], function () {
    Route::view('controller', 'controller.index');
    // Route::resource('exams', ExamController::class);
});

Route::group(['middleware' => ['role:hod']], function () {
    Route::view('hod', 'hod.index');
    Route::resource('programs', ProgramController::class);
    Route::resource('classes', ClassController::class);
    Route::resource('class-options', ClassOptionsController::class);
    Route::resource('sections', SectionController::class);
    Route::post('fetchSectionsByProgramId', [SectionController::class, 'fetchSectionsByProgramId'])->name('fetchSectionsByProgramId');
    Route::resource('courses', CourseController::class);
    Route::resource('teachers', teacherController::class);
    // Route::resource('examiners', examinerController::class);
    Route::resource('schemes', SchemeController::class);
    Route::resource('scheme-details', SchemeDetailController::class);
    Route::resource('course-allocations', CourseAllocationController::class);
    Route::resource('course-allocation-options', CourseAllocationOptionController::class)->only('index', 'store');
    Route::resource('elective-course-allocations', ElectiveCourseAllocationController::class);

    Route::resource('students', StudentController::class);
    Route::resource('results', ResultController::class);
    Route::resource('enrollments', EnrollmentController::class);
    Route::resource('department-sessions', DepartmentSessionController::class);
    Route::resource('program-shifts', ProgramShiftController::class)->only('show');
});

Route::group(['middleware' => ['role:examiner']], function () {
    Route::view('examiner', 'examiner.index');
});
