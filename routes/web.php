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
use App\Http\Controllers\Admin\UserAccessController;
use App\Http\Controllers\Admin\CourseTypeController;
use App\Http\Controllers\ResetPasswordController;
use App\Http\Controllers\ce\AwardController as CeAwardController;
use App\Http\Controllers\ce\FinalGazetteController;
use App\Http\Controllers\ce\GazetteController as CeGazetteController;
use App\Http\Controllers\ce\NotifiedGazetteController;
use App\Http\Controllers\ce\StudentController as CeStudentController;
use App\Http\Controllers\ce\TranscriptController;
use App\Http\Controllers\hod\AttemptPermissionController;
use App\Http\Controllers\hod\AwardController;
use App\Http\Controllers\hod\ChangeSectionController;
use App\Http\Controllers\hod\ProgramController;
use App\Http\Controllers\hod\CourseController;
use App\Http\Controllers\hod\TeacherController;
use App\Http\Controllers\hod\SchemeController;
use App\Http\Controllers\hod\StudentController;
use App\Http\Controllers\hod\GazetteController;
use App\Http\Controllers\hod\SchemeDetailController;
use App\Http\Controllers\hod\ClasController;
use App\Http\Controllers\hod\CourseAllocationController;
use App\Http\Controllers\hod\ReappearController;
use App\Http\Controllers\hod\CoursePlanController;
use App\Http\Controllers\hod\CumulativeController;
use App\Http\Controllers\hod\EnrollmentController;
use App\Http\Controllers\hod\FirstAttemptController as HodFirstAttemptController;
use App\Http\Controllers\hod\HodController;
use App\Http\Controllers\hod\InternalController;
use App\Http\Controllers\hod\SectionController;
use App\Http\Controllers\hod\SemesterPlanController;
use App\Http\Controllers\hod\SlotController;
use App\Http\Controllers\hod\SlotOptionController;
use App\Http\Controllers\hod\StruckOffController;
use App\Http\Controllers\hod\StudentStatusController;
use App\Http\Controllers\MyExceptionController;
use App\Http\Controllers\PdfController;
use App\Http\Controllers\teacher\AssessmentController;
use App\Http\Controllers\teacher\AwardController as TeacherAwardController;
use App\Http\Controllers\teacher\FirstAttemptController;
use App\Http\Controllers\teacher\FormativeController;
use App\Http\Controllers\teacher\FreshFormativeController;
use App\Http\Controllers\teacher\FreshSummativeController;
use App\Http\Controllers\teacher\MyCoursesController;

use App\Http\Controllers\teacher\ReappearFormativeController;
use App\Http\Controllers\teacher\ReappearSummativeController;
use App\Http\Controllers\teacher\SummativeController;

use App\Http\Controllers\teacher\TeacherController as TeacherTeacherController;
use App\Models\Semester;
use App\Models\StudentStatus;

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
        //if authenticated, attach semesters

        if (!Auth::user()->is_active) {
            Auth::logout();
            session()->flush();
            return redirect()->route('exception.show', 0);
        } else {
            $semesters = Semester::active()->get();
            return view('index', compact('semesters'));
        }
    } else
        return view('index');
})->where('url', ('login|signin|index'));

Route::view('changepw', 'changepw');
Route::patch('changepw/{id}', [AuthController::class, 'update']);
Route::view('two/fa', 'two_fa');
Route::view('forgot/password', 'forgot_password');
Route::resource('resetpassword', ResetPasswordController::class);
Route::post('resetpassword/sendcode', [ResetPasswordController::class, 'sendCode'])->name('resetpassword.sendcode');

Route::post('login', [AuthController::class, 'login']);
Route::post('two/fa', [AuthController::class, 'twoFA']);

Route::post('login/as', [AuthController::class, 'loginAs'])->name('login.as');
Route::post('fetchDepttByRole', [AjaxController::class, 'fetchDepttByRole'])->name('fetchDepttByRole');; //for ajax call
Route::post('searchReappearer', [AjaxController::class, 'searchReappearer'])->name('searchReappearer');; //for ajax call
Route::post('switch/semester', [AuthController::class, 'switchSemester'])->name('switch.semester');; //for ajax call

Route::get('signout', [AuthController::class, 'signout'])->name('signout');
Route::view('exception/r', 'exceptions.missing.role')->name('role_missed_exception');
Route::view('exception/d', 'exceptions.missing.department')->name('department_missed_exception');
Route::view('exception/s', 'exceptions.missing.semester')->name('semester_missed_exception');
Route::view('exception/b', 'exceptions.blocked')->name('user_blocked_exception');

Route::get('exception/{code}', [MyExceptionController::class, 'show'])->name('exception.show');

Route::group(['middleware' => ['role:admin']], function () {
    Route::get('admin', [DashboardController::class, 'admin']);
    Route::resource('user-access', UserAccessController::class);
    Route::resource('roles', RoleController::class);
    Route::resource('semesters', SemesterController::class);
    Route::resource('departments', DepartmentController::class);
    Route::resource('headships', HeadshipController::class);
    Route::resource('coursetypes', CourseTypeController::class);
    //
});

Route::group(['middleware' => ['role:controller']], function () {
    Route::redirect('controller', '/ce/students');
    Route::view('ce/transcripts', 'ce.transcripts.index');
    Route::get('ce/transcripts/pdf/{id}', [TranscriptController::class, 'pdf']);

    Route::post('searchAllByRollNoOrName', [AjaxController::class, 'searchAllByRollNoOrName']);
    Route::post('searchByRollNoOrNameToViewProfile', [AjaxController::class, 'searchByRollNoOrNameToViewProfile']);

    Route::get('ce/students', [CeStudentController::class, 'index'])->name('ce.students.index');
    Route::get('ce/students/profile/{student}', [CeStudentController::class, 'show'])->name('ce.students.show');

    Route::get('ce/award/step1', [CeAwardController::class, 'step1']);
    Route::post('ce/award/step1', [CeAwardController::class, 'store'])->name('ce.award.step1.store');
    Route::get('ce/award/step2', [CeAwardController::class, 'step2'])->name('ce.award.step2');
    Route::get('ce/award/{section}/step3', [CeAwardController::class, 'step3'])->name('ce.award.step3');
    Route::get('ce/award/{allocation}/pdf', [PdfController::class, 'award'])->name('ce.award.pdf');
    Route::get('ce/award/{allocation}/export', [CeAwardController::class, 'export'])->name('ce.award.export');

    Route::get('ce/gazette/step1', [CeGazetteController::class, 'step1']);
    Route::post('ce/gazette/step1', [CeGazetteController::class, 'store'])->name('ce.gazette.step1.store');
    Route::get('ce/gazette/step2', [CeGazetteController::class, 'step2'])->name('ce.gazette.step2');
    Route::get('ce/gazette/{section}/step3', [CeGazetteController::class, 'step3'])->name('ce.gazette.step3');
    Route::get('ce/gazette/{allocation}/pdf', [PdfController::class, 'gazette'])->name('ce.gazette.pdf');
});

Route::group(['middleware' => ['role:super|hod', 'my_exception_handler']], function () {
    Route::get('hod', [HodController::class, 'index']);
    Route::get('super', [HodController::class, 'index']);
    Route::view('hod/change/pw', 'hod.changepw')->name('hod.changepw');
    Route::resource('programs', ProgramController::class);

    Route::resource('teachers', TeacherController::class);
    Route::resource('internals', InternalController::class)->only('edit', 'update');

    Route::resource('schemes', SchemeController::class);
    Route::get('schemes/append/{id}', [SchemeController::class, 'append'])->name('schemes.append');

    Route::get('schemes/slot/create/{scheme}/{semester}', [SlotController::class, 'create'])->name('slots.create');

    Route::resource('slots', SlotController::class)->except('create');
    Route::resource('slot-options', SlotOptionController::class)->except('index', 'create');
    Route::get('showCoursesForSlotOption/{slotoption}', [SlotOptionController::class, 'showCourses'])->name('showCoursesForSlotOption');




    //?? to verify the reason of presence
    // Route::resource('enrollments', EnrollmentController::class);

    Route::view('hod/printable', 'hod.printable.index');
    Route::get('hod/gazette/step1', [GazetteController::class, 'step1']);
    Route::get('hod/gazette/{section}/preview', [GazetteController::class, 'preview'])->name('hod.gazette.preview');
    Route::get('hod/gazette/{section}/pdf', [PdfController::class, 'gazette'])->name('hod.gazette.pdf');

    Route::get('hod/award/step1', [AwardController::class, 'step1']);
    Route::get('hod/award/{section}/step2', [AwardController::class, 'step2'])->name('hod.award.step2');
    Route::get('hod/award/{allocation}/pdf', [PdfController::class, 'award'])->name('hod.award.pdf');
    Route::get('hod/award/{allocation}/export', [AwardController::class, 'export'])->name('hod.award.export');

    Route::get('hod/cum/step1', [CumulativeController::class, 'step1']);
    Route::get('hod/cum/{section}/step2', [CumulativeController::class, 'step2'])->name('hod.cum.step2');
    Route::get('hod/cum/{section}/{semester}/preview', [CumulativeController::class, 'preview'])->name('hod.cum.preview');
});

Route::group(['prefix' => 'hod', 'as' => 'hod.', 'middleware' => ['role:super|hod', 'my_exception_handler']], function () {
    Route::resource('courses', CourseController::class);
    Route::resource('clases', ClasController::class);
    Route::resource('sections', SectionController::class);
    Route::get('clases/append/{pid}', [ClasController::class, 'append'])->name('clases.append');

    Route::resource('courseplan', CoursePlanController::class);
    Route::resource('semester-plan', SemesterPlanController::class);
    Route::resource('course-allocations', CourseAllocationController::class);
    Route::get('course-allocations/{allocation}/assign/courses', [CourseAllocationController::class, 'courses'])->name('course-allocations.courses');
    Route::get('course-allocations/{allocation}/assign/teachers', [CourseAllocationController::class, 'teachers'])->name('course-allocations.teachers');


    Route::resource('allow-deny-attempt', AttemptPermissionController::class)->only('update');

    Route::get('students/{id}/move', [StudentStatusController::class, 'move'])->name('students.move');
    Route::patch('students/{student}/swap', [StudentStatusController::class, 'swap'])->name('students.swap');

    Route::get('students/{id}/struckoff', [StudentStatusController::class, 'struckoff'])->name('students.struckoff');
    Route::get('students/{id}/freeze', [StudentStatusController::class, 'freeze'])->name('students.freeze');
    // radmit deal both resume after struckoff or unfreeze
    Route::get('students/{id}/readmit', [StudentStatusController::class, 'readmit'])->name('students.readmit');

    Route::post('students/deactivate', [StudentStatusController::class, 'deactivate'])->name('students.deactivate');
    Route::post('students/activate', [StudentStatusController::class, 'activate'])->name('students.activate');

    Route::get('enroll-fresh/{allocation}', [EnrollmentController::class, 'fresh'])->name('enroll.fresh');
    Route::get('enroll-reappear/{allocation}', [EnrollmentController::class, 'reappear'])->name('enroll.reappear');
    Route::resource('first-attempts', HodFirstAttemptController::class);
    Route::resource('reappears', ReappearController::class);

    Route::post('enroll-fresh', [EnrollmentController::class, 'enrollFresh'])->name('enroll.fresh.post');
    Route::post('search-reappear-data', [EnrollmentController::class, 'searchReappearData'])->name('search.reappear.data');


    Route::resource('students', StudentController::class);
    Route::post('searchByRollNoOrName', [AjaxController::class, 'searchByRollNoOrName']);

    Route::get('students/{section}/add', [StudentController::class, 'add'])->name('students.add');
    Route::get('students/{section}/excel', [StudentController::class, 'excel'])->name('students.excel');
    Route::post('students/import', [StudentController::class, 'import'])->name('students.import');


    Route::get('cumulative', [CumulativeController::class, 'index']);
    Route::get('cumulative/{section}/preview', [CumulativeController::class, 'preview'])->name('cumulative.preview');
});

Route::group(['middleware' => ['role:teacher', 'my_exception_handler']], function () {

    Route::get('teacher', [TeacherTeacherController::class, 'index']);
    Route::view('teacher/change/pw', 'teacher.changepw')->name('teacher.changepw');
    Route::resource('mycourses', MyCoursesController::class);
    Route::resource('formative', FormativeController::class);
    Route::resource('summative', SummativeController::class);

    Route::resource('fresh_formative', FreshFormativeController::class);
    Route::resource('fresh_summative', FreshSummativeController::class);
    Route::resource('reappear_formative', ReappearFormativeController::class);
    Route::resource('reappear_summative', ReappearSummativeController::class);

    Route::resource('first_attempts', FirstAttemptController::class);

    Route::get('enroll/f/{id}', [EnrollmentController::class, 'fresh'])->name('enroll.fa');
    Route::get('enroll/r/{id}', [EnrollmentController::class, 'reappear'])->name('enroll.ra');

    Route::resource('assessment', AssessmentController::class);
    Route::get('assessment/pdf/{id}', [AssessmentController::class, 'pdf']);

    Route::get('teacher/award', [TeacherAwardController::class, 'index']);
    Route::get('teacher/award/{course}/pdf', [PdfController::class, 'award'])->name('teacher.award');
});
