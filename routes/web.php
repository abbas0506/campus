<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

use App\Http\Controllers\AuthController; //my authcontroller
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\Admin\DepartmentController;
use App\Http\Controllers\Admin\HeadshipController;
use App\Http\Controllers\HOD\EnrollmentController;
use App\Http\Controllers\HOD\CourseAllocationController;
use App\Http\Controllers\HOD\ProgramController;
use App\Http\Controllers\HOD\CourseController;
use App\Http\Controllers\HOD\teacherController;
use App\Http\Controllers\HOD\SchemeController;
use App\Http\Controllers\HOD\StudentController;
use App\Http\Controllers\Admin\SemesterController;
use App\Http\Controllers\AjaxController;
use App\Http\Controllers\ce\TranscriptController;
use App\Http\Controllers\HOD\ClasController;
use App\Http\Controllers\HOD\CourseAllocationOptionController;
use App\Http\Controllers\HOD\ElectiveAllocationController;
use App\Http\Controllers\HOD\GazzetteController;
use App\Http\Controllers\HOD\ImportStudentsController;
use App\Http\Controllers\HOD\SchemeDetailController;
use App\Http\Controllers\HOD\SectionController;
use App\Http\Controllers\LoginOptionsController;
use App\Http\Controllers\teacher\AssessmentSheetController;
use App\Http\Controllers\teacher\FirstAttemptController;
use App\Http\Controllers\teacher\FreshFormativeController;
use App\Http\Controllers\teacher\FreshSummativeController;
use App\Http\Controllers\teacher\MyCoursesController;
use App\Http\Controllers\teacher\ReappearController;
use App\Http\Controllers\teacher\ReappearFormativeController;
use App\Http\Controllers\teacher\ReappearSummativeController;

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
        return redirect('login-options');
    } else
        return view('index');
});

// Auth::routes();
Route::post('login', [AuthController::class, 'login']);
Route::post('verify/step2', [AuthController::class, 'verify_step2']);
Route::resource('login-options', LoginOptionsController::class)->only('index', 'store');
Route::post('fetchDepttByRole', [AjaxController::class, 'fetchDepttByRole'])->name('fetchDepttByRole');; //for ajax call
Route::post('searchReappearer', [AjaxController::class, 'searchReappearer'])->name('searchReappearer');; //for ajax call

Route::get('signout', [AuthController::class, 'signout'])->name('signout');


Route::group(['middleware' => ['role:admin']], function () {
    // Route::view('admin', 'admin.index');
    Route::get('admin', function () {
        return redirect('departments');
    });
    Route::resource('users', UserController::class);
    Route::resource('roles', RoleController::class);
    Route::resource('semesters', SemesterController::class);
    Route::resource('departments', DepartmentController::class);
    Route::resource('headship', HeadshipController::class);
});
Route::group(['middleware' => ['role:controller']], function () {
    Route::view('controller', 'ce.index');
    Route::resource('transcripts', TranscriptController::class);
    Route::get('transcripts/pdf/{id}', [TranscriptController::class, 'pdf']);
});

Route::group(['middleware' => ['role:hod']], function () {
    Route::view('hod', 'hod.index');
    Route::resource('programs', ProgramController::class);
    Route::resource('clases', ClasController::class);
    Route::post('clases.promote', [ClasController::class, 'promote'])->name('clases.promote');
    Route::post('clases.demote', [ClasController::class, 'demote'])->name('clases.demote');

    Route::resource('sections', SectionController::class);
    Route::get('sections/append/{pid}/{sid}', [SectionController::class, 'append']);
    Route::post('fetchSectionsByClas', [SectionController::class, 'fetchSectionsByClas'])->name('fetchSectionsByClas'); //for ajax call
    Route::post('fetchSchemesByProgramId', [AjaxController::class, 'fetchSchemesByProgramId'])->name('fetchSchemesByProgramId'); //for ajax call


    Route::resource('courses', CourseController::class);
    Route::resource('teachers', teacherController::class);
    Route::resource('schemes', SchemeController::class);
    Route::resource('scheme-details', SchemeDetailController::class);
    Route::resource('course-allocations', CourseAllocationController::class);

    Route::get('course_allocations/assign/teacher/{id}', [CourseAllocationController::class, 'assignTeacher']);
    Route::patch('course-allocations/assign/teacher', [CourseAllocationController::class, 'postAssignTeacher']);
    Route::get('course_allocations/add/optional/{id}', [CourseAllocationController::class, 'addOptional']);
    Route::patch('course_allocations/add/optional', [CourseAllocationController::class, 'postAddOptional']);

    Route::resource('course-allocation-options', CourseAllocationOptionController::class)->only('index', 'store');
    Route::resource('elective-allocations', ElectiveAllocationController::class)->only('edit');

    Route::resource('students', StudentController::class);
    Route::resource('enrollments', EnrollmentController::class);
    Route::get('import-students/view/{id}', [ImportStudentsController::class, 'view']);
    Route::post('import-students', [ImportStudentsController::class, 'import']);
    Route::resource('gazzette', GazzetteController::class);
    Route::get('gazzette/pdf/{id}', [GazzetteController::class, 'pdf']);
});

Route::group(['middleware' => ['role:teacher']], function () {
    Route::view('teacher', 'teacher.index');
    Route::resource('mycourses', MyCoursesController::class);

    Route::resource('fresh_formative', FreshFormativeController::class);
    Route::resource('fresh_summative', FreshSummativeController::class);
    Route::resource('reappear_formative', ReappearFormativeController::class);
    Route::resource('reappear_summative', ReappearSummativeController::class);

    Route::resource('first_attempts', FirstAttemptController::class);
    Route::resource('reappears', ReappearController::class);
    Route::get('enroll.fa/{id}', [MyCoursesController::class, 'enrollFresh'])->name('enroll.fa');
    Route::get('enroll.ra/{id}', [MyCoursesController::class, 'enrollReappear'])->name('enroll.ra');
    Route::resource('assessment_sheets', AssessmentSheetController::class);
    Route::get('assessment_sheets/pdf/{id}', [AssessmentSheetController::class, 'pdf']);
});
