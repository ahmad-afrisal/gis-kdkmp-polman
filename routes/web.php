<?php

use App\Http\Controllers\BussinessAssistantController;
use App\Http\Controllers\ContactManagementController;
use App\Http\Controllers\CooperationController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DistrictController;
use App\Http\Controllers\DocumentationPmoController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\LandStatisticController;
use App\Http\Controllers\PolygonController;
use App\Http\Controllers\ProblemController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\VillageController;
use App\Http\Controllers\WeeklyReportController;
use Illuminate\Support\Facades\Route;

// Route::get('/', function () {
//     return view('welcome');
// });

Route::get('/', [HomeController::class, 'index'])->name('welcome');
Route::get('/galleries', [HomeController::class, 'gallery'])->name('galleries');
Route::get('/contacts', [HomeController::class, 'contact'])->name('contacts');
Route::get('/performance/{id}', [HomeController::class, 'performance'])->name('performance');
Route::get('/map/filter', [HomeController::class, 'filter'])->name('map.filter');




Route::middleware('auth')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::resource('districts', DistrictController::class);

    Route::get('bussiness-assistants/{bussinessAssistant}/form-1', [BussinessAssistantController::class, 'form1'])
        ->name('bussiness-assistants.form-1');
    Route::post(
        'bussiness-assistants/{bussinessAssistant}/form-1',
        [BussinessAssistantController::class, 'storeOrUpdateFormOne']
    )->name('bussiness-assistants.form-1.store');

    Route::get('bussiness-assistants/{bussinessAssistant}/form-2', [BussinessAssistantController::class, 'form2'])
        ->name('bussiness-assistants.form-2');

    Route::post(
        'bussiness-assistants/{bussinessAssistant}/form-2',
        [BussinessAssistantController::class, 'storeOrUpdateFormTwo']
    )->name('bussiness-assistants.form-2.store');

    Route::get('bussiness-assistants/{bussinessAssistant}/form-3', [BussinessAssistantController::class, 'form3'])
        ->name('bussiness-assistants.form-3');
    Route::post(
        'bussiness-assistants/{bussinessAssistant}/form-3',
        [BussinessAssistantController::class, 'storeOrUpdateFormThree']
    )->name('bussiness-assistants.form-3.store');


    Route::get('bussiness-assistants/{bussinessAssistant}/form-4', [BussinessAssistantController::class, 'form4'])
        ->name('bussiness-assistants.form-4');
    Route::post(
        'bussiness-assistants/{bussinessAssistant}/form-4',
        [BussinessAssistantController::class, 'storeOrUpdateFormFour']
    )->name('bussiness-assistants.form-4.store');

    Route::get('bussiness-assistants/{bussinessAssistant}/form-5', [BussinessAssistantController::class, 'form5'])
        ->name('bussiness-assistants.form-5');
    Route::post(
        'bussiness-assistants/{bussinessAssistant}/form-5',
        [BussinessAssistantController::class, 'storeOrUpdateFormFive']
    )->name('bussiness-assistants.form-5.store');



    Route::get('bussiness-assistants/{bussinessAssistant}/form-6', [BussinessAssistantController::class, 'form6'])
        ->name('bussiness-assistants.form-6');
    Route::post(
        'bussiness-assistants/{bussinessAssistant}/form-6',
        [BussinessAssistantController::class, 'storeOrUpdateFormSix']
    )->name('bussiness-assistants.form-6.store');

    Route::get('bussiness-assistants/{bussinessAssistant}/form-7', [BussinessAssistantController::class, 'form7'])
        ->name('bussiness-assistants.form-7');
    Route::post(
        'bussiness-assistants/{bussinessAssistant}/form-7',
        [BussinessAssistantController::class, 'storeOrUpdateFormSeven']
    )->name('bussiness-assistants.form-7.store');

    Route::get('bussiness-assistants/{bussinessAssistant}/report', [BussinessAssistantController::class, 'generateReport'])
        ->name('bussiness-assistants.report');


    Route::get('land-statistics/export', [LandStatisticController::class, 'export'])->name('land-statistic.export');
    Route::resource('land-statistics', LandStatisticController::class);
    Route::resource('polygons', PolygonController::class);
    Route::get('bussiness-assistants/performance/{id}', [BussinessAssistantController::class, 'performance'])->name('bussiness-assistants.performance');
    Route::resource('bussiness-assistants', BussinessAssistantController::class);
    Route::resource('cooperations', CooperationController::class);
    Route::resource('villages', VillageController::class);
    Route::resource('pmo-documentations', DocumentationPmoController::class);
    Route::resource('problems', ProblemController::class);
    Route::resource('contact-managements', ContactManagementController::class);
    Route::resource('weekly-reports', WeeklyReportController::class);
});

require __DIR__ . '/auth.php';
