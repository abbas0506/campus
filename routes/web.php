<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

use App\Http\Controllers\AjaxController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\AuthController; //my authcontroller
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ResetPasswordController;
use App\Http\Controllers\MyExceptionController;

use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\SemesterController;
use App\Http\Controllers\Admin\DepartmentController;
use App\Http\Controllers\Admin\HeadshipController;
use App\Http\Controllers\Admin\UserAccessController;
use App\Http\Controllers\Admin\CourseTypeController;
use App\Http\Controllers\Admin\NotificationController;
use App\Http\Controllers\ce\AwardController as CeAwardController;
use App\Http\Controllers\ce\GazetteController as CeGazetteController;
use App\Http\Controllers\ce\NotificationController as CeNotificationController;
use App\Http\Controllers\ce\StudentController as CeStudentController;
use App\Http\Controllers\ce\TranscriptController;

use App\Http\Controllers\coordinator\AssessmentController as CoordinatorAssessmentController;
use App\Http\Controllers\coordinator\ClasController as CoordinatorClasController;
use App\Http\Controllers\coordinator\CoordinatorController;
use App\Http\Controllers\coordinator\CourseAllocationController as CoordinatorCourseAllocationController;
use App\Http\Controllers\coordinator\EnrollmentController as CoordinatorEnrollmentController;
use App\Http\Controllers\coordinator\MovementController as CoordinatorMovementController;
use App\Http\Controllers\coordinator\NotificationCotroller as CoordinatorNotificationCotroller;
use App\Http\Controllers\coordinator\ResumptionController as CoordinatorResumptionController;
use App\Http\Controllers\coordinator\SectionController as CoordinatorSectionController;
use App\Http\Controllers\coordinator\SemesterPlanController as CoordinatorSemesterPlanController;
use App\Http\Controllers\coordinator\StudentController as CoordinatorStudentController;
use App\Http\Controllers\coordinator\SuspensionController as CoordinatorSuspensionController;

use App\Http\Controllers\hod\AssessmentController as HodAssessmentController;
use App\Http\Controllers\hod\AttemptPermissionController;
use App\Http\Controllers\hod\AwardController;
use App\Http\Controllers\hod\ProgramController;
use App\Http\Controllers\hod\CourseController;
use App\Http\Controllers\hod\TeacherController;
use App\Http\Controllers\hod\SchemeController;
use App\Http\Controllers\hod\StudentController;
use App\Http\Controllers\hod\GazetteController;
use App\Http\Controllers\hod\ClasController;
use App\Http\Controllers\hod\CourseAllocationController;
use App\Http\Controllers\hod\CumulativeController;
use App\Http\Controllers\hod\EnrollmentController;

use App\Http\Controllers\hod\HodController;
use App\Http\Controllers\hod\NotificationCotroller;
use App\Http\Controllers\hod\SectionController;
use App\Http\Controllers\hod\SemesterPlanController;
use App\Http\Controllers\hod\SlotController;
use App\Http\Controllers\hod\SlotOptionController;
use App\Http\Controllers\hod\MovementController;
use App\Http\Controllers\hod\ResumptionController;
use App\Http\Controllers\hod\SuspensionController;

use App\Http\Controllers\internal\InternalController as InternalInternalController;
use App\Http\Controllers\internal\AssessmentController as InternalAssessmentController;
use App\Http\Controllers\internal\NotificationCotroller as InternalNotificationCotroller;

use App\Http\Controllers\teacher\TeacherController as TeacherTeacherController;
use App\Http\Controllers\teacher\AssessmentController;
use App\Http\Controllers\teacher\AttendanceController;
use App\Http\Controllers\teacher\AwardController as TeacherAwardController;
use App\Http\Controllers\teacher\FormativeController;
use App\Http\Controllers\teacher\MyCoursesController;
use App\Http\Controllers\teacher\NotificationCotroller as TeacherNotificationCotroller;
use App\Http\Controllers\teacher\SummativeController;


use App\Http\Controllers\PdfController;
use App\Models\Semester;


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

Route::post('login', [AuthController::class, 'login']);
Route::view('auth/verification', 'auth.passwords.verification');
Route::post('auth/verify', [AuthController::class, 'verify'])->name('auth.verify');
Route::view('signout/me', 'signout');

Route::view('auth/passwords/forgot', 'auth.passwords.forgot')->name('passwords.forgot');
Route::resource('resetpassword', ResetPasswordController::class);
Route::post('resetpassword/sendcode', [ResetPasswordController::class, 'sendCode'])->name('resetpassword.sendcode');

Route::view('auth/passwords/edit', 'auth.passwords.edit')->name('passwords.edit');
Route::view('auth/passwords/edit/confirm', 'auth.passwords.confirm')->name('passwords.confirm');
Route::patch('auth/passwords/change/{id}', [AuthController::class, 'changePassword'])->name('passwords.change');

Route::post('login/as', [AuthController::class, 'loginAs'])->name('login.as');
Route::post('fetchDepttByRole', [AjaxController::class, 'fetchDepttByRole'])->name('fetchDepttByRole');; //for ajax call
Route::post('searchReappearer', [AjaxController::class, 'searchReappearer'])->name('searchReappearer');; //for ajax call
Route::get('switch/me', [AuthController::class, 'viewSwitch'])->name('switch.me.view');
Route::post('switch/me', [AuthController::class, 'switch'])->name('switch.me');; //for ajax call

Route::get('signout', [AuthController::class, 'signout'])->name('signout');
Route::view('exception/r', 'exceptions.missing.role')->name('role_missed_exception');
Route::view('exception/d', 'exceptions.missing.department')->name('department_missed_exception');
Route::view('exception/s', 'exceptions.missing.semester')->name('semester_missed_exception');
Route::view('exception/b', 'exceptions.blocked')->name('user_blocked_exception');

Route::get('exception/{code}', [MyExceptionController::class, 'show'])->name('exception.show');

Route::group(['prefix' => 'admin', 'as' => 'admin.', 'middleware' => ['role:admin']], function () {
    Route::get('/', [DashboardController::class, 'admin']);
    Route::resource('user-access', UserAccessController::class);
    Route::resource('roles', RoleController::class);
    Route::resource('semesters', SemesterController::class);
    Route::resource('departments', DepartmentController::class);
    Route::resource('headships', HeadshipController::class);
    Route::resource('coursetypes', CourseTypeController::class);
    Route::resource('notifications', NotificationController::class);
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
    Route::resource('notifications', CeNotificationController::class);
});

Route::get('super', [HodController::class, 'index']);
Route::group(['prefix' => 'hod', 'as' => 'hod.', 'middleware' => ['role:super|hod', 'my_exception_handler']], function () {
    Route::get('/', [HodController::class, 'index']);
    Route::resource('programs', ProgramController::class);
    Route::resource('courses', CourseController::class);
    Route::resource('schemes', SchemeController::class);
    Route::resource('teachers', TeacherController::class);

    Route::get('programs/{program}/schemes/add', [ProgramController::class, 'scheme'])->name('programs.schemes.add');
    Route::post('programs/schemes/add', [ProgramController::class, 'addScheme'])->name('programs.schemes.store');
    Route::get('programs/{program}/internal', [ProgramController::class, 'internal'])->name('programs.internal');
    Route::patch('programs/{program}/internal/update', [ProgramController::class, 'updateInternal'])->name('programs.internal.update');
    Route::get('programs/{program}/coordinator', [ProgramController::class, 'coordinator'])->name('programs.coordinator');
    Route::patch('programs/{program}/coordinator/update', [ProgramController::class, 'updateCoordinator'])->name('programs.coordinator.update');

    Route::get('schemes//{id}/append', [SchemeController::class, 'append'])->name('schemes.append');
    Route::get('schemes/{scheme}/pdf', [SchemeController::class, 'pdf'])->name('schemes.pdf');
    Route::get('schemes/slot/create/{scheme}/{semester}', [SlotController::class, 'create'])->name('slots.create');

    Route::resource('slots', SlotController::class)->except('create');
    Route::resource('slot-options', SlotOptionController::class)->except('index', 'create');
    Route::get('showCoursesForSlotOption/{slotoption}', [SlotOptionController::class, 'showCourses'])->name('showCoursesForSlotOption');

    Route::resource('clases', ClasController::class);
    Route::resource('sections', SectionController::class);
    Route::get('clases/{program}/add', [ClasController::class, 'add'])->name('clases.add');

    Route::resource('semester-plan', SemesterPlanController::class);
    Route::get('semester-plan/{semester}/pdf', [SemesterPlanController::class, 'pdf'])->name('semester-plan.pdf');

    Route::resource('course-allocations', CourseAllocationController::class);
    Route::get('course-allocations/{allocation}/assign/courses', [CourseAllocationController::class, 'courses'])->name('course-allocations.courses');
    Route::get('course-allocations/{allocation}/assign/teachers', [CourseAllocationController::class, 'teachers'])->name('course-allocations.teachers');

    Route::resource('assessment', HodAssessmentController::class);
    Route::post('assessment/missing/notify', [HodAssessmentController::class, 'notifyMissing'])->name('assessment.missing.notify');
    Route::post('assessment/missing/notify/single', [HodAssessmentController::class, 'notifySingle'])->name('assessment.missing.notify.single');
    Route::patch('assessment/{allocation}/unlock', [HodAssessmentController::class, 'unlock'])->name('assessment.unlock');
    Route::get('assessment/view/pending', [HodAssessmentController::class, 'pending'])->name('assessment.pending');
    Route::get('assessment/view/submitted', [HodAssessmentController::class, 'submitted'])->name('assessment.submitted');
    Route::get('assessment/{allocation}/pdf', [PdfController::class, 'award'])->name('assessment.pdf');
    Route::resource('notifications', NotificationCotroller::class);
    Route::post('notifications/mark/as/read', [NotificationCotroller::class, 'markAsRead'])->name('notifications.mark');

    Route::get('course-allocations/{allocation}/fresh', [EnrollmentController::class, 'fresh'])->name('course-allocations.enrollment.fresh');
    Route::get('course-allocations/{allocation}/reappear', [EnrollmentController::class, 'reappear'])->name('course-allocations.enrollment.reappear');
    Route::post('course-allocations/fresh/post', [EnrollmentController::class, 'enrollFresh'])->name('course-allocations.enrollment.fresh.post');
    Route::post('course-allocations/reappear/post', [EnrollmentController::class, 'enrollReappear'])->name('course-allocations.enrollment.reappear.post');
    Route::delete('course-allocations/fresh/destroy/{attempt}', [EnrollmentController::class, 'destroyFresh'])->name('course-allocations.enrollment.fresh.destroy');
    Route::delete('course-allocations/reappear/destory/{attempt}', [EnrollmentController::class, 'destroyReappear'])->name('course-allocations.enrollment.reappear.destroy');

    Route::resource('students', StudentController::class);
    Route::resource('students/movement', MovementController::class);
    Route::resource('students/suspension', SuspensionController::class);
    Route::resource('students/resumption', ResumptionController::class);
    Route::post('searchByRollNoOrName', [AjaxController::class, 'searchByRollNoOrName']);
    Route::post('search-reappear-data', [EnrollmentController::class, 'searchReappearData'])->name('search.reappear.data');

    Route::get('sections/{section}/students/feed', [StudentController::class, 'feed'])->name('students.feed');
    Route::get('sections/{section}/students/excel', [StudentController::class, 'excel'])->name('students.excel');
    Route::post('students/import', [StudentController::class, 'import'])->name('students.import');

    Route::view('printable', 'hod.printable.index');
    Route::get('award/index', [AwardController::class, 'index'])->name('award.index');
    Route::get('award/{section}/courses', [AwardController::class, 'courses'])->name('award.courses');
    Route::get('award/{allocation}/pdf', [PdfController::class, 'award'])->name('award.pdf');
    Route::get('award/{allocation}/export', [AwardController::class, 'export'])->name('award.export');

    Route::get('gazette/index', [GazetteController::class, 'index'])->name('gazette.index');
    Route::get('gazette/{section}/preview', [GazetteController::class, 'preview'])->name('gazette.preview');
    Route::get('gazette/{section}/pdf', [PdfController::class, 'gazette'])->name('gazette.pdf');

    Route::get('cumulative/index', [CumulativeController::class, 'index'])->name('cumulative.index');
    Route::get('cumulative/{section}/preview', [CumulativeController::class, 'preview'])->name('cumulative.preview');
});

Route::group(['prefix' => 'teacher', 'as' => 'teacher.', 'middleware' => ['role:teacher', 'my_exception_handler']], function () {

    Route::get('/', [TeacherTeacherController::class, 'index']);
    Route::view('change/pw', 'teacher.changepw')->name('changepw');
    Route::resource('mycourses', MyCoursesController::class);
    Route::resource('attendance', AttendanceController::class);
    Route::resource('assessment', AssessmentController::class);
    Route::get('assessment/{allocation}/preview', [AssessmentController::class, 'preview'])->name('assessment.preview');
    Route::resource('notifications', TeacherNotificationCotroller::class);
    Route::resource('formative', FormativeController::class);
    Route::resource('summative', SummativeController::class);

    Route::get('award', [TeacherAwardController::class, 'index'])->name('award');
    Route::get('award/{allocation}/pdf', [PdfController::class, 'award'])->name('award.pdf');
});

Route::group(['prefix' => 'internal', 'as' => 'internal.', 'middleware' => ['role:super|internal', 'my_exception_handler']], function () {
    Route::get('/', [InternalInternalController::class, 'index']);
    Route::resource('notifications', InternalNotificationCotroller::class);
    Route::post('notifications/mark/as/read', [InternalNotificationCotroller::class, 'markAsRead'])->name('notifications.mark');

    Route::resource('assessment', InternalAssessmentController::class);
    Route::get('assessment/view/pending', [InternalAssessmentController::class, 'pending'])->name('assessment.pending');
    Route::get('assessment/view/submitted', [InternalAssessmentController::class, 'submitted'])->name('assessment.submitted');
    Route::post('assessment/missing/notify/all', [InternalAssessmentController::class, 'notifyMissing'])->name('assessment.missing.notify');
    Route::post('assessment/missing/notify/single', [InternalAssessmentController::class, 'notifySingle'])->name('assessment.missing.notify.single');
    Route::get('assessment/{allocation}/pdf', [InternalAssessmentController::class, 'pdf'])->name('assessment.pdf');


    Route::post('search-reappear-data', [EnrollmentController::class, 'searchReappearData'])->name('search.reappear.data');

    Route::resource('students', StudentController::class);
    Route::post('searchByRollNoOrName', [AjaxController::class, 'searchByRollNoOrName']);

    Route::view('printable', 'hod.printable.index');
    Route::get('award/index', [AwardController::class, 'index'])->name('award.index');
    Route::get('award/{section}/courses', [AwardController::class, 'courses'])->name('award.courses');
    Route::get('award/{allocation}/pdf', [PdfController::class, 'award'])->name('award.pdf');
    Route::get('award/{allocation}/export', [AwardController::class, 'export'])->name('award.export');

    Route::get('gazette/index', [GazetteController::class, 'index'])->name('gazette.index');
    Route::get('gazette/{section}/preview', [GazetteController::class, 'preview'])->name('gazette.preview');
    Route::get('gazette/{section}/pdf', [PdfController::class, 'gazette'])->name('gazette.pdf');

    Route::get('cumulative/index', [CumulativeController::class, 'index'])->name('cumulative.index');
    Route::get('cumulative/{section}/preview', [CumulativeController::class, 'preview'])->name('cumulative.preview');
});

Route::group(['prefix' => 'coordinator', 'as' => 'coordinator.', 'middleware' => ['role:coordinator', 'my_exception_handler']], function () {
    Route::get('/', [CoordinatorController::class, 'index']);

    Route::resource('clases', CoordinatorClasController::class);
    Route::get('clases/{program}/add', [CoordinatorClasController::class, 'add'])->name('clases.add');
    Route::resource('sections', CoordinatorSectionController::class);

    Route::resource('students', CoordinatorStudentController::class);
    Route::post('searchByRollNoOrName', [AjaxController::class, 'searchByRollNoOrName']);

    Route::get('sections/{section}/students/feed', [CoordinatorStudentController::class, 'feed'])->name('students.feed');
    Route::get('sections/{section}/students/excel', [CoordinatorStudentController::class, 'excel'])->name('students.excel');
    Route::post('students/import', [CoordinatorStudentController::class, 'import'])->name('students.import');

    Route::resource('students/movement', CoordinatorMovementController::class);
    Route::resource('students/suspension', CoordinatorSuspensionController::class);
    Route::resource('students/resumption', CoordinatorResumptionController::class);

    Route::resource('semester-plan', CoordinatorSemesterPlanController::class);
    Route::get('semester-plan/{semester}/pdf', [CoordinatorSemesterPlanController::class, 'pdf'])->name('semester-plan.pdf');

    Route::resource('course-allocations', CoordinatorCourseAllocationController::class);
    Route::get('course-allocations/{allocation}/assign/courses', [CoordinatorCourseAllocationController::class, 'courses'])->name('course-allocations.courses');
    Route::get('course-allocations/{allocation}/assign/teachers', [CoordinatorCourseAllocationController::class, 'teachers'])->name('course-allocations.teachers');

    Route::get('course-allocations/{allocation}/fresh', [CoordinatorEnrollmentController::class, 'fresh'])->name('course-allocations.enrollment.fresh');
    Route::get('course-allocations/{allocation}/reappear', [CoordinatorEnrollmentController::class, 'reappear'])->name('course-allocations.enrollment.reappear');
    Route::post('course-allocations/fresh/post', [CoordinatorEnrollmentController::class, 'enrollFresh'])->name('course-allocations.enrollment.fresh.post');
    Route::post('course-allocations/reappear/post', [CoordinatorEnrollmentController::class, 'enrollReappear'])->name('course-allocations.enrollment.reappear.post');
    Route::delete('course-allocations/fresh/destroy/{attempt}', [CoordinatorEnrollmentController::class, 'destroyFresh'])->name('course-allocations.enrollment.fresh.destroy');
    Route::delete('course-allocations/reappear/destory/{attempt}', [CoordinatorEnrollmentController::class, 'destroyReappear'])->name('course-allocations.enrollment.reappear.destroy');

    Route::resource('notifications', CoordinatorNotificationCotroller::class);
    Route::post('notifications/mark/as/read', [CoordinatorNotificationCotroller::class, 'markAsRead'])->name('notifications.mark');

    Route::resource('assessment', CoordinatorAssessmentController::class);
    Route::post('assessment/missing/notify', [CoordinatorAssessmentController::class, 'notifyMissing'])->name('assessment.missing.notify');
    Route::post('assessment/missing/notify/single', [CoordinatorAssessmentController::class, 'notifySingle'])->name('assessment.missing.notify.single');
    Route::patch('assessment/{allocation}/unlock', [CoordinatorAssessmentController::class, 'unlock'])->name('assessment.unlock');

    Route::get('assessment/view/pending', [CoordinatorAssessmentController::class, 'pending'])->name('assessment.pending');
    Route::get('assessment/view/submitted', [CoordinatorAssessmentController::class, 'submitted'])->name('assessment.submitted');
    Route::get('assessment/{allocation}/pdf', [PdfController::class, 'award'])->name('assessment.pdf');
});
