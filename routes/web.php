<?php

use App\Http\Controllers\admin\AdminDashboardController;
use App\Http\Controllers\admin\DepartmentController;
use App\Http\Controllers\admin\FacultyController;
use App\Http\Controllers\admin\SendTaskController;
use App\Http\Controllers\documenttype\DocumentTypeController;
use App\Http\Controllers\FilterDateController;
use App\Http\Controllers\FilteredPagesController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ReleaseController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\studydepartament\DonetaskController;
use App\Http\Controllers\studydepartament\DoneUserDocsController;
use App\Http\Controllers\studydepartament\FinalStepController;
use App\Http\Controllers\studydepartament\RecivedDocumentsController;
use App\Http\Controllers\studydepartament\StudyDepartamentController;
use App\Http\Controllers\studydepartament\UserDashboardController;
use App\Http\Controllers\studydepartament\UserDocumentsController;
use App\Http\Controllers\TasksTableController;
use App\Http\Controllers\UserController;
use App\Models\Release;
use Illuminate\Support\Facades\Route;


Route::group(['middleware' => 'auth'], function () {
    Route::get('/', [HomeController::class, 'index'])->name('index');
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::resource('roles', RoleController::class);
    Route::resource('permissions', PermissionController::class);
    Route::resource('users', UserController::class);
    Route::resource('departments', DepartmentController::class);

    Route::resource('reciveddocuments', RecivedDocumentsController::class);

    Route::get('reciveddocuments/accepted/done', [RecivedDocumentsController::class, 'accepted_done'])->name('reciveddocuments.accepted_done');

    Route::get('reciveddocuments/cancelled/done', [RecivedDocumentsController::class, 'cancelled_done'])->name('reciveddocuments.cancelled_done');


    Route::resource('faculty', FacultyController::class);


    Route::resource('sendtask', SendTaskController::class);
    Route::get('sendtask/read/{id}/', [SendTaskController::class, 'read'])->name('sendtask.read');
    Route::get('/downloadst/{filename}', [SendTaskController::class, 'download'])->name('sendtask.download')->middleware('auth');

    Route::resource('taskstables', TasksTableController::class);
    Route::resource('documenttypes', DocumentTypeController::class);
    Route::get('documenttypes/{documenttype}/mapedit', [DocumentTypeController::class, 'mapedit'])->name('documenttypes.mapedit');
    Route::put('documenttypes/{documenttype}/mapupdate', [DocumentTypeController::class, 'mapupdate'])->name('documenttypes.mapupdate');

    Route::get('admindashboard/status_tasks', [AdminDashboardController::class, 'status_tasks'])->name('admindashboard.status_tasks');

    Route::get('admindashboard/read', [AdminDashboardController::class, 'read'])->name('admindashboard.read');

    Route::get('admindashboard/unread', [AdminDashboardController::class, 'unread'])->name('admindashboard.unread');

    Route::get('admindashboard/expired', [AdminDashboardController::class, 'expired'])->name('admindashboard.expired');

    Route::get('admindashboard/accepted_departments', [AdminDashboardController::class, 'accepted_departments'])->name('admindashboard.accepted_departments');

    Route::get('admindashboard/deadlinelessleft', [AdminDashboardController::class, 'deadlinelessleft'])->name('admindashboard.deadlinelessleft');

    Route::get('admindashboard/accepted_userdocs', [AdminDashboardController::class, 'accepted_userdocs'])->name('admindashboard.accepted_userdocs');

    Route::get('admindashboard/waiting_userdocs', [AdminDashboardController::class, 'waiting_userdocs'])->name('admindashboard.waiting_userdocs');

    Route::get('admindashboard/cancelled_userdocs', [AdminDashboardController::class, 'cancelled_userdocs'])->name('admindashboard.cancelled_userdocs');

    Route::get('admindashboard/mix_userdocs', [AdminDashboardController::class, 'mix_userdocs'])->name('admindashboard.mix_userdocs');

    Route::get('admindashboard/cancelled_done', [AdminDashboardController::class, 'cancelled_done'])->name('admindashboard.cancelled_done');

    Route::get('admindashboard/all_userdocs', [AdminDashboardController::class, 'all_userdocs'])->name('admindashboard.all_userdocs');

    Route::resource('admindashboard', AdminDashboardController::class);

    Route::get('userdashboard/accepted_docs', [UserDashboardController::class, 'accepted_docs'])->name('userdashboard.accepted_docs');
    Route::get('userdashboard/waiting_docs', [UserDashboardController::class, 'waiting_docs'])->name('userdashboard.waiting_docs');
    Route::get('userdashboard/cancelled_docs', [UserDashboardController::class, 'cancelled_docs'])->name('userdashboard.cancelled_docs');

    Route::get('userdashboard/my_accepted_docs', [UserDashboardController::class, 'my_accepted_docs'])->name('userdashboard.my_accepted_docs');
    Route::get('userdashboard/my_waiting_docs', [UserDashboardController::class, 'my_waiting_docs'])->name('userdashboard.my_waiting_docs');
    Route::get('userdashboard/my_cancelled_docs', [UserDashboardController::class, 'my_cancelled_docs'])->name('userdashboard.my_cancelled_docs');

    Route::get('userdashboard/my_accepted_tasks', [UserDashboardController::class, 'my_accepted_tasks'])->name('userdashboard.my_accepted_tasks');
    Route::get('userdashboard/my_waiting_tasks', [UserDashboardController::class, 'my_waiting_tasks'])->name('userdashboard.my_waiting_tasks');

    Route::get('userdashboard/doc_done_list/{ids}', [UserDashboardController::class, 'doc_done_list'])->name('userdashboard.doc_done_list');


    Route::group(['middleware' => ['auth', 'role:user']], function () {

        Route::get('tasktables/expired', [TasksTableController::class, 'expired'])->name('tasktables.expired');
        Route::get('tasktables/waiting', [TasksTableController::class, 'waiting'])->name('tasktables.waiting');
        Route::get('tasktables/done_list', [TasksTableController::class, 'done_list'])->name('tasktables.done_list');
        Route::get('tasktables/no_deadline', [TasksTableController::class, 'no_deadline'])->name('tasktables.no_deadline');

        Route::resource('tasktables', TasksTableController::class);
        Route::resource('userdocuments', UserDocumentsController::class);
        Route::get('/downloadud/{filename}', [UserDocumentsController::class, 'download'])->name('userdocuments.download')->middleware('auth');

//        Route::resource('reciveddocuments', RecivedDocumentsController::class);
        Route::resource('doneuserdocs', DoneUserDocsController::class);
        Route::get('doneuserdocs/list/{id}/', [DoneUserDocsController::class, 'view'])->name('doneuserdocs.view');
        Route::get('/downloaddoneud/{filename}', [DoneUserDocsController::class, 'download'])->name('doneuserdocs.download')->middleware('auth');


        Route::get('reciveddocuments/reject/{id}/', [RecivedDocumentsController::class, 'reject'])->name('reciveddocuments.reject');

        Route::post('reciveddocuments/final_step/{id}/', [RecivedDocumentsController::class, 'final_step'])->name('reciveddocuments.final_step');

        Route::get('reciveddocuments/final_step_view/{id}/', [RecivedDocumentsController::class, 'final_step_view'])->name('reciveddocuments.final_step_view');

        Route::get('reciveddocuments/done/{id}/', [RecivedDocumentsController::class, 'done'])->name('reciveddocuments.done');

        Route::post('reciveddocuments/accept/{id}/', [RecivedDocumentsController::class, 'accept'])->name('reciveddocuments.accept');

        Route::post('reciveddocuments/cancel/{id}/', [RecivedDocumentsController::class, 'cancel'])->name('reciveddocuments.cancel');

        Route::get('reciveddocuments/detail/{id}/', [RecivedDocumentsController::class, 'detail'])->name('reciveddocuments.detail');

        Route::resource('studydepartments', StudyDepartamentController::class);

        Route::resource('final_steps', FinalStepController::class);

        Route::get('/download_final/{filename}', [FinalStepController::class, 'download'])->name('final_steps.download')->middleware('auth');

        //filteredpages

        Route::get('filteredpages/filtered_status_tasks', [FilteredPagesController::class, 'filtered_status_tasks'])->name('filteredpages.filtered_status_tasks');

        Route::get('filteredpages/filtered_read', [FilteredPagesController::class, 'filtered_read'])->name('filteredpages.filtered_read');

        Route::get('filteredpages/filtered_unread', [FilteredPagesController::class, 'filtered_unread'])->name('filteredpages.filtered_unread');

        Route::get('filteredpages/filtered_expired', [FilteredPagesController::class, 'filtered_expired'])->name('filteredpages.filtered_expired');

        Route::get('filteredpages/filtered_accepted_departments', [FilteredPagesController::class, 'filtered_accepted_departments'])->name('filteredpages.filtered_accepted_departments');

        Route::get('filteredpages/filtered_deadlinelessleft', [FilteredPagesController::class, 'filtered_deadlinelessleft'])->name('filteredpages.filtered_deadlinelessleft');

        Route::get('filteredpages/filtered_accepted_userdocs', [FilteredPagesController::class, 'filtered_accepted_userdocs'])->name('filteredpages.filtered_accepted_userdocs');

        Route::get('filteredpages/filtered_waiting_userdocs', [FilteredPagesController::class, 'filtered_waiting_userdocs'])->name('filteredpages.filtered_waiting_userdocs');

        Route::get('filteredpages/filtered_cancelled_userdocs', [FilteredPagesController::class, 'filtered_cancelled_userdocs'])->name('filteredpages.filtered_cancelled_userdocs');

        Route::get('filteredpages/filtered_mix_userdocs', [FilteredPagesController::class, 'filtered_mix_userdocs'])->name('filteredpages.filtered_mix_userdocs');

        Route::get('filteredpages/filtered_all_userdocs', [FilteredPagesController::class, 'filtered_all_userdocs'])->name('filteredpages.filtered_all_userdocs');

        Route::get('filteredpages/filtered_cancelled_done', [FilteredPagesController::class, 'filtered_cancelled_done'])->name('filteredpages.filtered_cancelled_done');

        Route::resource('filteredpages', FilteredPagesController::class);

        //end of filteredpages


        Route::resource('filterdates', FilterDateController::class);

        Route::resource('donetask', DonetaskController::class);
        Route::get('donetask/{donetask}/edits/{pages}', [DonetaskController::class, 'edits'])->name('donetask.edits');
        Route::get('donetask/list/{id}/', [DonetaskController::class, 'view'])->name('donetask.view');
        Route::get('/download/{filename}', [DonetaskController::class, 'download'])->name('donetask.download')->middleware('auth');
        Route::get('process', [DonetaskController::class, 'process'])->name('donetask.process');


    });


});
Route::get('/release/{id}', [ReleaseController::class, 'show'])->name('release.pdf');

Route::get('/releasedownload/{id}', [ReleaseController::class, 'getDownload'])->name('releasedownload');

Route::resource('release', ReleaseController::class);

Route::get('/short/{encodedUrl}', [ReleaseController::class, 'redirectShortUrl']);


require __DIR__ . '/auth.php';
