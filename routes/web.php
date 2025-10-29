<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\InternalBulletinController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\LoginImageController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SubTrainingProgramController;
use App\Http\Controllers\SystemUserController;
use App\Http\Controllers\TrainingCalendarMonthlyController;
use App\Http\Controllers\TrainingCalendarYearlyController;
use App\Http\Controllers\TrainingFormController;
use App\Http\Controllers\TrainingNeedsIdentification\TniCompetencyController;
use App\Http\Controllers\TrainingNeedsIdentification\TniCourseController;
use App\Http\Controllers\TrainingNeedsIdentification\TniProgramController;
use App\Http\Controllers\TrainingNeedsIdentificationController;
use App\Http\Controllers\TrainingPolicyGuidelineController;
use App\Http\Controllers\TrainingProgramController;
use App\Http\Controllers\TransferOfKnowledgeController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('auth.login');
});

Route::middleware('auth')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    Route::get('settings/login-image', [LoginImageController::class, 'index'])->name('settings.login-image.index');
    Route::post('settings/login-image/create', [LoginImageController::class, 'store'])->name('settings.login-image.store');
    Route::delete('settings/login-image/{id}/delete', [LoginImageController::class, 'delete'])->name('settings.login-image.delete');

    Route::get('/profile', [ProfileController::class, 'edit'])->name('settings.profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('settings.profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('settings.profile.destroy');

    Route::get('training-program', [TrainingProgramController::class, 'index'])->name('training-program.index');
    Route::post('training-program/create', [TrainingProgramController::class, 'store'])->name('training-program.store');
    Route::post('training-program/{id}/edit', [TrainingProgramController::class, 'update'])->name('training-program.update');
    Route::delete('training-program/{id}/delete', [TrainingProgramController::class, 'delete'])->name('training-program.delete');

    Route::get('training-program/{programId}/program', [SubTrainingProgramController::class, 'index'])->name('sub-training-program.index');
    Route::post('training-program/{programId}/program/create', [SubTrainingProgramController::class, 'store'])->name('sub-training-program.store');
    Route::post('training-program/{programId}/program/{id}/edit', [SubTrainingProgramController::class, 'update'])->name('sub-training-program.update');
    Route::delete('training-program/{programId}/program/{id}/delete', [SubTrainingProgramController::class, 'delete'])->name('sub-training-program.delete');

    Route::get('training-calendar/monthly', [TrainingCalendarMonthlyController::class, 'index'])->name('training-calendar.monthly.index');
    Route::get('training-calendar/monthly/list', [TrainingCalendarMonthlyController::class, 'list'])->name('training-calendar.monthly.list');
    Route::post('training-calendar/monthly/create', [TrainingCalendarMonthlyController::class, 'store'])->name('training-calendar.monthly.store');
    Route::post('training-calendar/monthly/{id}/edit', [TrainingCalendarMonthlyController::class, 'update'])->name('training-calendar.monthly.update');
    Route::delete('training-calendar/monthly/{id}/delete', [TrainingCalendarMonthlyController::class, 'delete'])->name('training-calendar.monthly.delete');

    Route::get('training-calendar/yearly', [TrainingCalendarYearlyController::class, 'index'])->name('training-calendar.yearly.index');
    Route::get('training-calendar/yearly/list', [TrainingCalendarYearlyController::class, 'list'])->name('training-calendar.yearly.list');
    Route::post('training-calendar/yearly/create', [TrainingCalendarYearlyController::class, 'store'])->name('training-calendar.yearly.store');
    Route::post('training-calendar/yearly/{id}/edit', [TrainingCalendarYearlyController::class, 'update'])->name('training-calendar.yearly.update');
    Route::delete('training-calendar/yearly/{id}/delete', [TrainingCalendarYearlyController::class, 'delete'])->name('training-calendar.yearly.delete');

    Route::get('training-policy', [TrainingPolicyGuidelineController::class, 'index'])->name('training-policy.index');
    Route::post('training-policy/create', [TrainingPolicyGuidelineController::class, 'store'])->name('training-policy.store');
    Route::post('training-policy/{id}/edit', [TrainingPolicyGuidelineController::class, 'update'])->name('training-policy.update');
    Route::delete('training-policy/{id}/delete', [TrainingPolicyGuidelineController::class, 'delete'])->name('training-policy.delete');

    Route::get('training-form', [TrainingFormController::class, 'index'])->name('training-form.index');
    Route::post('training-form/create', [TrainingFormController::class, 'store'])->name('training-form.store');
    Route::post('training-form/{id}/edit', [TrainingFormController::class, 'update'])->name('training-form.update');
    Route::delete('training-form/{id}/delete', [TrainingFormController::class, 'delete'])->name('training-form.delete');

    Route::get('transfer-of-knowledge', [TransferOfKnowledgeController::class, 'index'])->name('transfer-of-knowledge.index');
    Route::post('transfer-of-knowledge/create', [TransferOfKnowledgeController::class, 'store'])->name('transfer-of-knowledge.store');
    Route::post('transfer-of-knowledge/{id}/edit', [TransferOfKnowledgeController::class, 'update'])->name('transfer-of-knowledge.update');
    Route::delete('transfer-of-knowledge/{id}/delete', [TransferOfKnowledgeController::class, 'delete'])->name('transfer-of-knowledge.delete');
    Route::post('transfer-of-knowledge/{id}/set-as-top-learner', [TransferOfKnowledgeController::class, 'setAsTopLearner'])->name('transfer-of-knowledge.set-as-top-leaner');
    Route::post('transfer-of-knowledge/{id}/remove-as-top-learner', [TransferOfKnowledgeController::class, 'removeAsTopLearner'])->name('transfer-of-knowledge.remove-as-top-leaner');
    Route::post('transfer-of-knowledge/{knowledge_id}/document/upload', [TransferOfKnowledgeController::class, 'uploadDocument'])->name('transfer-of-knowledge.upload.document');
    Route::delete('transfer-of-knowledge/{knowledge_id}/document/{id}/delete', [TransferOfKnowledgeController::class, 'deleteDocument'])->name('transfer-of-knowledge.delete.document');

    Route::get('training-needs/program', [TniProgramController::class, 'index'])->name('training-needs.program.index');
    Route::post('training-needs/program/create', [TniProgramController::class, 'store'])->name('training-needs.program.store');
    Route::post('training-needs/program/{id}/edit', [TniProgramController::class, 'update'])->name('training-needs.program.update');
    Route::delete('training-needs/program/{id}/delete', [TniProgramController::class, 'delete'])->name('training-needs.program.delete');
    Route::post('training-needs/program/report', [TniProgramController::class, 'report'])->name('training-needs.program.report');

    Route::get('training-needs/program/{program_id}/competency', [TniCompetencyController::class, 'index'])->name('training-needs.competency.index');
    Route::post('training-needs/program/{program_id}/competency/create', [TniCompetencyController::class, 'store'])->name('training-needs.competency.store');
    Route::post('training-needs/program/{program_id}/competency/{id}/edit', [TniCompetencyController::class, 'update'])->name('training-needs.competency.update');
    Route::delete('training-needs/program/{program_id}/competency/{id}/delete', [TniCompetencyController::class, 'delete'])->name('training-needs.competency.delete');

    Route::get('training-needs/program/{program_id}/competency/{competency_id}/course', [TniCourseController::class, 'index'])->name('training-needs.course.index');
    Route::post('training-needs/program/{program_id}/competency/{competency_id}/course/create', [TniCourseController::class, 'store'])->name('training-needs.course.store');
    Route::post('training-needs/program/{program_id}/competency/{competency_id}/course/{id}/edit', [TniCourseController::class, 'update'])->name('training-needs.course.update');
    Route::delete('training-needs/program/{program_id}/competency/{competency_id}/course/{id}/delete', [TniCourseController::class, 'delete'])->name('training-needs.course.delete');
    Route::post('training-needs/program/{program_id}/competency/{competency_id}/course/{id}/apply', [TniCourseController::class, 'apply'])->name('training-needs.course.apply');
    Route::post('training-needs/program/{program_id}/competency/{competency_id}/course/{id}/withdraw', [TniCourseController::class, 'withdraw'])->name('training-needs.course.withdraw');

    Route::get('internal-bulletin', [InternalBulletinController::class, 'index'])->name('internal-bulletin.index');
    Route::post('internal-bulletin/create', [InternalBulletinController::class, 'store'])->name('internal-bulletin.store');
    Route::post('internal-bulletin/{id}/edit', [InternalBulletinController::class, 'update'])->name('internal-bulletin.update');
    Route::delete('internal-bulletin/{id}/delete', [InternalBulletinController::class, 'delete'])->name('internal-bulletin.delete');
    Route::post('internal-bulletin/{bulletin_id}/document/upload', [InternalBulletinController::class, 'uploadDocument'])->name('internal-bulletin.upload.document');
    Route::delete('internal-bulletin/{bulletin_id}/document/{id}/delete', [InternalBulletinController::class, 'deleteDocument'])->name('internal-bulletin.delete.document');

    Route::get('system-user', [SystemUserController::class, 'index'])->name('system-user.index');
    Route::post('system-user/create', [SystemUserController::class, 'store'])->name('system-user.store');
    Route::post('system-user/{id}/edit', [SystemUserController::class, 'update'])->name('system-user.update');
    Route::delete('system-user/{id}/delete', [SystemUserController::class, 'delete'])->name('system-user.delete');
    Route::post('system-user/import', [SystemUserController::class, 'import'])->name('system-user.import');
});

require __DIR__.'/auth.php';
