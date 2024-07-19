<?php

use App\Http\Controllers\EstateIndicatorJustifyController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use App\Http\Controllers\ValidityController;
use App\Http\Controllers\EstateIndicatorController;
use App\Http\Middleware\AdminUserRoute;
use App\Http\Controllers\PollController;

Route::get('/', function () {
    return redirect('/login');
});

Route::controller(App\Http\Controllers\LoginController::class)->group(function () {
    Route::get('/login','create')->name('login');
    Route::post('/login', 'store');
    Route::post('/logout', 'destroy')->name('logout');
});


Route::post('logoutUser', function () {
    Auth::logout();
    return redirect('/login');
})->name('logoutUser');

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/dashboard', function () {
        return Inertia::render('Dashboard');
    })->name('dashboard');

    Route::controller(UserController::class)->group(function () {
        Route::get('listUsers', 'show')->name('listUsers')->middleware(AdminUserRoute::class);
        Route::post('editUser', 'edit')->name('editUser');
        Route::post('newUser', 'store')->name('newUser');
        Route::post('updateStatus', 'editStatus')->name('updateStatus')->middleware(AdminUserRoute::class);
    });

    Route::controller(ValidityController::class)->group(function () {
        Route::get('listValidities', 'index')->name('listValidities');
        Route::get('listValiditiesControl', 'indexControl')->name('listValiditiesControl');
        Route::get('getDataAdviser', 'getDataAdviser')->name('getDataAdviser');
        Route::get('getDataAdviserAssesor', 'getDataAdviserAssesor')->name('getDataAdviserAssesor');
    });

    Route::controller(EstateIndicatorController::class)->group(function () {
        Route::get('estateIndicators', 'show')->name('estateIndicators');
        Route::get('estateIndicatorsAdmin', 'showAdmin')->name('estateIndicatorsAdmin');
        Route::get('estateIndicatorsAdviser', 'showControl')->name('estateIndicatorsAdviser');
        Route::post('estateIndicatorsDep', 'estateIndicatorUpdateDep')->name('estateIndicatorsDep');
    });

    Route::controller(EstateIndicatorJustifyController::class)->group(function () {
        Route::get('justify/indicator', 'show')->name('justifyIndicator');
        Route::post('justify/indicator', 'store')->name('savejustifyIndicator');
        Route::post('justify/indicator/control', 'storeControl')->name('savejustifyIndicatorControl');
    });

    Route::controller(\App\Http\Controllers\EstateController::class)->group(function () {
        Route::get('listEstates/{edit?}', 'index')->name('listEstates')->middleware(AdminUserRoute::class);
        Route::post('newEstates', 'create')->name('newEstates');
    });

    Route::controller(\App\Http\Controllers\IndicatorController::class)->group(function(){
        Route::get('listIndicators', 'index')->name('listIndicators')->middleware(AdminUserRoute::class);
        Route::get('listIndicatorsAssoc/{id?}', 'viewAll')->name('listIndicatorsAssoc');
        Route::get('getIndicators', 'getAll')->name('getIndicators');
    });

    Route::controller(\App\Http\Controllers\IndicatorMoneyController::class)->group(function () {
        Route::get('getIndicatorsMoney', 'index')->name('getIndicatorsMoney');
    });

    Route::controller(\App\Http\Controllers\AdvisorOfficesController::class)->group(function(){
        Route::get('gestionAdvisorOffices', 'index')->name('gestionAdvisorOffices');
        Route::post('advisorOffices', 'store')->name('advisorOffices');
        Route::post('updateAdvisorOfficesAssesor', 'updateAdvisorOfficesAssesor')->name('updateAdvisorOfficesAssesor');
        Route::delete('deleteAdvisorOffices', 'deleteAdvisorOffices')->name('deleteAdvisorOffices');
    });

    Route::controller(\App\Http\Controllers\FollowUpController::class)->group(function (){
        Route::get('getFollowUp/{validity?}', 'show')->name('getFollowUp');
        Route::post('setFollowUp', 'store')->name('setFollowUp');
        Route::post('updateFollowUp', 'storeUpdate')->name('updateFollowUp');
        Route::post('updateFollowUpState', 'storeUpdateState')->name('updateFollowUpState');
        Route::post('createFollowUp', 'createFollowUp')->name('createFollowUp')->middleware(AdminUserRoute::class);
        Route::get('showCreateFollowUp', 'showCreateFollowUp')->name('showCreateFollowUp')->middleware(AdminUserRoute::class);
        Route::get('consultFollowUp', 'consultFollowUp')->name('consultFollowUp');
        Route::post('closeFollowUp', 'closeFollowUp')->name('closeFollowUp')->middleware(AdminUserRoute::class);
    });

    Route::controller(\App\Http\Controllers\ExportController::class)->group(function (){
        Route::get('export/prepare', 'getExport')->name('exportPrepare');
        Route::get('exportDownload', 'download')->name('exportDownload');
        Route::get('exportDownloadFollowClose', 'downloadFollowClose')->name('exportDownloadFollowClose');
        Route::get('exportDownloadFollowCloseMoney', 'downloadFollowCloseMoney')->name('exportDownloadFollowCloseMoney');
        Route::get('export/followup/dep', 'downloadFollowDep')->name('export/followup/dep');

        Route::get('exportExcel', 'viewData')->name('exportExcel');//para Visualizar lo que se descarga
        Route::get('export/followup/depv', 'viewDownloadFollowDep')->name('export/followup/depv');



        Route::get('viewReportOpen', 'viewReportOpen')->name('viewReportOpen');//para Visualizar lo que se descarga
        Route::get('downloadReportOpen', 'downloadReportOpen')->name('downloadReportOpen');//para Visualizar lo que se descarga
    });

    Route::controller( \App\Http\Controllers\ImportExcelcontroller::class)->middleware(AdminUserRoute::class)->group(function (){
        Route::post('importExcelIndicator', 'index')->name('importExcelIndicator');
        Route::post('importExcelIndicatorGen', 'indexGen')->name('importExcelIndicatorGen');
        Route::post('importExcelIndicatorMoney', 'indexMoney')->name('importExcelIndicatorMoney');
        Route::post('importExcelUsers', 'importUsers')->name('importExcelUsers');
    });

    Route::controller(\App\Http\Controllers\PollController::class)->group(function () {
        Route::get('showCreatePoll', 'index')->name('showCreatePoll');
    });
    // Mueve la ruta fuera del middleware si no es necesario autenticar para acceder
    Route::get('/new-form', function () {
        return Inertia::render('Forms/NewForm'); // Actualiza el path aquí
    })->name('newForm');

    Route::middleware(['auth:sanctum', 'verified'])->group(function () {
        Route::get('/new-form', function () {
            return Inertia::render('Forms/NewForm'); // Actualiza el path aquí también
        })->name('newForm');
    });

});
