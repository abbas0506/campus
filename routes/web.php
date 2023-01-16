<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

use App\Http\Controllers\AjaxController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\LoginOptionsController;
use App\Http\Controllers\AuthController; //my authcontroller
use App\Http\Controllers\ChartController;
use App\Http\Controllers\DashboardController;

use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\SemesterController;
use App\Http\Controllers\Admin\DepartmentController;
use App\Http\Controllers\Admin\HeadshipController;

use App\Http\Controllers\ce\TranscriptController;

use App\Http\Controllers\hod\EnrollmentController;
use App\Http\Controllers\hod\ProgramController;
use App\Http\Controllers\hod\CourseController;
use App\Http\Controllers\hod\TeacherController;
use App\Http\Controllers\hod\SchemeController;
use App\Http\Controllers\hod\StudentController;
use App\Http\Controllers\hod\GazzetteController;
use App\Http\Controllers\hod\SchemeDetailController;
use App\Http\Controllers\hod\ClasController;
use App\Http\Controllers\hod\ClassPromotionController;
use App\Http\Controllers\hod\ClassReversionController;
use App\Http\Controllers\hod\CoursePlanController;
use App\Http\Controllers\hod\SectionController;
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

Route::get('/{url?}', function () {
    if (Auth::check()) {
        return redirect('login-options');
    } else
        return view('index');
})->where('url', ('login|signin|index'));

Route::post('login', [AuthController::class, 'login']);
Route::post('verify/step2', [AuthController::class, 'verify_step2']);
Route::resource('login-options', LoginOptionsController::class)->only('index', 'store');
Route::post('fetchDepttByRole', [AjaxController::class, 'fetchDepttByRole'])->name('fetchDepttByRole');; //for ajax call
Route::post('searchReappearer', [AjaxController::class, 'searchReappearer'])->name('searchReappearer');; //for ajax call

Route::get('signout', [AuthController::class, 'signout'])->name('signout');

Route::group(['middleware' => ['role:admin']], function () {
    Route::get('admin', [DashboardController::class, 'admin']);
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

Route::group([' middleware' => ['role:hod']], function () {
    Route::get('hod', [DashboardController::class, 'hod']);
    Route::resource('programs', ProgramController::class);
    Route::resource('clases', ClasController::class);
    Route::get('clases/append/{pid}/{sid}', [ClasController::class, 'append'])->name('clases.append');

    Route::resource('promotions', ClassPromotionController::class)->only('index', 'store');
    Route::resource('reversions', ClassReversionController::class)->only('index', 'store');

    Route::resource('sections', SectionController::class);
    Route::resource('courses', CourseController::class);
    Route::resource('teachers', TeacherController::class);
    Route::resource('schemes', SchemeController::class);
    Route::get('schemes/append/{id}', [SchemeController::class, 'append'])->name('schemes.append');
    Route::resource('scheme-details', SchemeDetailController::class);
    Route::resource('courseplan', CoursePlanController::class);

    Route::get('courseplan/{section}/courses', [CoursePlanController::class, 'courses'])->name('courseplan.courses');
    Route::get('courseplan/{courseallocation}/teachers', [CoursePlanController::class, 'teachers'])->name('courseplan.teachers');
    Route::get('courseplan/{section}/optional/{schemedetail}', [CoursePlanController::class, 'optional'])->name('courseplan.optional');

    Route::resource('students', StudentController::class);
    Route::get('students/{section}/add', [StudentController::class, 'add'])->name('students.add');
    Route::get('students/{section}/excel', [StudentController::class, 'excel'])->name('students.excel');
    Route::post('students/import', [StudentController::class, 'import'])->name('students.import');

    //?? to verify the reason of presence
    Route::resource('enrollments', EnrollmentController::class);

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
