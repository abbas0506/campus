<?php

use App\Http\Controllers\Admin\CourseTypeController;
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
use App\Http\Controllers\ce\AwardController as CeAwardController;
use App\Http\Controllers\ce\FinalGazetteController;
use App\Http\Controllers\ce\GazetteController as CeGazetteController;
use App\Http\Controllers\ce\NotifiedGazetteController;
use App\Http\Controllers\ce\TranscriptController;
use App\Http\Controllers\hod\AwardController;
use App\Http\Controllers\hod\ProgramController;
use App\Http\Controllers\hod\CourseController;
use App\Http\Controllers\hod\TeacherController;
use App\Http\Controllers\hod\SchemeController;
use App\Http\Controllers\hod\StudentController;
use App\Http\Controllers\hod\GazetteController;
use App\Http\Controllers\hod\SchemeDetailController;
use App\Http\Controllers\hod\ClasController;
use App\Http\Controllers\hod\ClassPromotionController;
use App\Http\Controllers\hod\ClassReversionController;
use App\Http\Controllers\hod\CoursePlanController;
use App\Http\Controllers\hod\CumulativeController;
use App\Http\Controllers\hod\InternalController;
use App\Http\Controllers\hod\SchemeMetaController;
use App\Http\Controllers\hod\SectionController;
use App\Http\Controllers\PdfController;
use App\Http\Controllers\teacher\AssessmentController;
use App\Http\Controllers\teacher\AwardController as TeacherAwardController;
use App\Http\Controllers\teacher\FirstAttemptController;
use App\Http\Controllers\teacher\FormativeController;
use App\Http\Controllers\teacher\FreshFormativeController;
use App\Http\Controllers\teacher\FreshSummativeController;
use App\Http\Controllers\teacher\MyCoursesController;
use App\Http\Controllers\teacher\ReappearController;
use App\Http\Controllers\teacher\ReappearFormativeController;
use App\Http\Controllers\teacher\ReappearSummativeController;
use App\Http\Controllers\teacher\SummativeController;
use App\Http\Controllers\teacher\EnrollmentController;


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
        // if (Auth::user()->hasRole('super')) {
        // } else if (Auth::user()->hasRole('admin'))
        //     return redirect('admin');
        // else if (Auth::user()->hasRole('controller'))
        //     return redirect('controller');
        // else //for hod or teacher
        return redirect()->route('login-options.index');
    } else
        return view('index');
})->where('url', ('login|signin|index'));

Route::view('changepw', 'changepw');
Route::post('changepw', [UserController::class, 'changepw']);

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
    Route::resource('coursetypes', CourseTypeController::class);
    //
});

Route::group(['middleware' => ['role:controller']], function () {
    // Route::view('controller', 'ce.index');
    Route::redirect('controller', '/ce/transcripts');
    Route::view('ce/transcripts', 'ce.transcripts.index');
    Route::get('ce/transcripts/pdf/{id}', [TranscriptController::class, 'pdf']);

    Route::post('searchAllByRollNoOrName', [AjaxController::class, 'searchAllByRollNoOrName']);

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

Route::group([' middleware' => ['role:hod']], function () {
    Route::get('hod', [DashboardController::class, 'hod']);
    Route::resource('programs', ProgramController::class);
    Route::resource('clases', ClasController::class);
    Route::get('clases/append/{pid}', [ClasController::class, 'append'])->name('clases.append');

    Route::resource('promotions', ClassPromotionController::class)->only('index', 'store');
    Route::resource('reversions', ClassReversionController::class)->only('index', 'store');

    Route::resource('sections', SectionController::class);
    Route::resource('courses', CourseController::class);
    Route::resource('teachers', TeacherController::class);
    Route::resource('internals', InternalController::class)->only('edit', 'update');



    Route::resource('schemes', SchemeController::class);
    Route::get('schemes/append/{id}', [SchemeController::class, 'append'])->name('schemes.append');

    Route::get('schemes/meta/create/{scheme}/{semester}', [SchemeMetaController::class, 'create'])->name('schemes.meta.create');

    Route::resource('scheme-meta', SchemeMetaController::class)->except('create');

    // Route::post('schemes/meta/store', [SchemeMetaController::class, 'store'])->name('schemes.meta.store');
    // Route::delete('schemes/meta/destroy', [SchemeMetaController::class, 'destroy'])->name('schemes.meta.destroy');

    Route::resource('scheme-details', SchemeDetailController::class);
    Route::resource('courseplan', CoursePlanController::class);

    Route::get('courseplan/{section}/courses', [CoursePlanController::class, 'courses'])->name('courseplan.courses');
    Route::get('courseplan/{courseallocation}/teachers', [CoursePlanController::class, 'teachers'])->name('courseplan.teachers');
    Route::get('courseplan/{section}/optional/{schemedetail}', [CoursePlanController::class, 'optional'])->name('courseplan.optional');
    Route::get('courseplan/{courseallocation}/replace', [CoursePlanController::class, 'replace'])->name('courseplan.replace');
    Route::post('courseplan/replace', [CoursePlanController::class, 'replaceTeacher'])->name('courseplan.replace.teacher');

    Route::resource('students', StudentController::class);
    Route::post('searchByRollNoOrName', [AjaxController::class, 'searchByRollNoOrName']);

    Route::get('students/{section}/add', [StudentController::class, 'add'])->name('students.add');
    Route::get('students/{section}/excel', [StudentController::class, 'excel'])->name('students.excel');
    Route::post('students/import', [StudentController::class, 'import'])->name('students.import');

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

    // Route::resource('gazette', gazetteController::class);
    // Route::resource('hod-award', HodAwardController::class);
    // Route::resource('hod-cumulative', HodCumulativeController::class);
});

Route::group([' middleware' => ['role:admin|controller|hod']], function () {
    Route::get('gazette/pdf/{id}', [GazetteController::class, 'pdf']);
    Route::get('pdf/award/{id}', [PdfController::class, 'award']);
    Route::get('preview/cumulative/{section}/{semester}', [PdfController::class, 'previewCumulative']);
});

Route::group(['middleware' => ['role:teacher']], function () {
    Route::get('teacher', [MyCoursesController::class, 'index']);
    Route::resource('mycourses', MyCoursesController::class);
    Route::resource('formative', FormativeController::class);
    Route::resource('summative', SummativeController::class);

    Route::resource('fresh_formative', FreshFormativeController::class);
    Route::resource('fresh_summative', FreshSummativeController::class);
    Route::resource('reappear_formative', ReappearFormativeController::class);
    Route::resource('reappear_summative', ReappearSummativeController::class);

    Route::resource('first_attempts', FirstAttemptController::class);
    Route::resource('reappears', ReappearController::class);

    Route::get('enroll/f/{id}', [EnrollmentController::class, 'fresh'])->name('enroll.fa');
    Route::get('enroll/r/{id}', [EnrollmentController::class, 'reappear'])->name('enroll.ra');

    Route::resource('assessment', AssessmentController::class);
    Route::get('assessment/pdf/{id}', [AssessmentController::class, 'pdf']);

    Route::get('teacher/award', [TeacherAwardController::class, 'index']);
    Route::get('teacher/award/{course}/pdf', [PdfController::class, 'award'])->name('teacher.award');
});
