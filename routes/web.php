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
use App\Http\Controllers\hod\CourseAllocationController;
use App\Http\Controllers\hod\ProgramController;
use App\Http\Controllers\hod\CourseController;
use App\Http\Controllers\hod\TeacherController;
use App\Http\Controllers\hod\SchemeController;
use App\Http\Controllers\hod\StudentController;
use App\Http\Controllers\hod\CourseAllocationOptionController;
use App\Http\Controllers\hod\ElectiveAllocationController;
use App\Http\Controllers\hod\GazzetteController;
use App\Http\Controllers\hod\ImportStudentsController;
use App\Http\Controllers\hod\SchemeDetailController;
use App\Http\Controllers\hod\ClasController;
use App\Http\Controllers\hod\ClassPromotionController;
use App\Http\Controllers\hod\ClassReversionController;
use App\Http\Controllers\hod\CoursePlanController;
use App\Http\Controllers\hod\MorningClasesController;
use App\Http\Controllers\hod\SectionController;
use App\Http\Controllers\hod\SelfsupportClasesController;
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
    // Route::get('sections/append/{pid}/{sid}', [SectionController::class, 'append']);
    Route::post('fetchSectionsByClas', [SectionController::class, 'fetchSectionsByClas'])->name('fetchSectionsByClas'); //for ajax call
    Route::post('fetchSchemesByProgramId', [AjaxController::class, 'fetchSchemesByProgramId'])->name('fetchSchemesByProgramId'); //for ajax call


    Route::resource('courses', CourseController::class);
    Route::resource('teachers', TeacherController::class);
    Route::resource('schemes', SchemeController::class);
    Route::get('schemes/append/{id}', [SchemeController::class, 'append'])->name('schemes.append');
    Route::resource('scheme-details', SchemeDetailController::class);
    // Route::resource('course-allocations', CourseAllocationController::class);
    Route::resource('course_allocations', CourseAllocationController::class);
    Route::resource('courseplan', CoursePlanController::class);

    Route::get('courseplan/{section}/courses', [CoursePlanController::class, 'courses'])->name('courseplan.courses');
    Route::get('courseplan/{courseallocation}/teachers', [CoursePlanController::class, 'teachers'])->name('courseplan.teachers');
    Route::get('courseplan/{section}/optional/{schemedetail}', [CoursePlanController::class, 'optional'])->name('courseplan.optional');

    // Route::get('course_allocations/assign/teacher/{id}', [CourseAllocationController::class, 'assignTeacher']);
    // Route::patch('course-allocations/assign/teacher', [CourseAllocationController::class, 'postAssignTeacher']);
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
