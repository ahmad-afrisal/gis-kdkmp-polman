<?php

use App\Http\Controllers\AnnouncementController;
use App\Http\Controllers\ArticleController;
use App\Http\Controllers\BussinessAssistantController;
use App\Http\Controllers\CommodityController;
use App\Http\Controllers\ContactManagementController;
use App\Http\Controllers\CooperationController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DistrictController;
use App\Http\Controllers\DocumentationPmoController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\LandStatisticController;
use App\Http\Controllers\LinkDriveController;
use App\Http\Controllers\PolygonController;
use App\Http\Controllers\ProblemController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\RecordFormSevenController;
use App\Http\Controllers\VillageController;
use App\Http\Controllers\WeeklyReportController;
use Illuminate\Support\Facades\Route;

// Route::get('/', function () {
//     return view('welcome');
// });

Route::get('/', [HomeController::class, 'index'])->name('welcome');
Route::get('/home/articles', [HomeController::class, 'articles'])->name('home-articles');
Route::get('/home/announcements', [HomeController::class, 'announcements'])->name('home-announcements');
Route::get('/galleries', [HomeController::class, 'gallery'])->name('galleries');
Route::get('/contacts', [HomeController::class, 'contact'])->name('contacts');
Route::get('/performance/{id}', [HomeController::class, 'performance'])->name('performance');
Route::get('/map/filter', [HomeController::class, 'filter'])->name('map.filter');




Route::middleware('auth')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/dashboard/2026', [DashboardController::class, 'dashboard2026'])->name('dashboard.2026');
    Route::get('/dashboard/2026/form-eight', [DashboardController::class, 'formEight'])->name('dashboard.form-eight');
    Route::get('/dashboard/2026/form-nine', [DashboardController::class, 'formNine'])->name('dashboard.form-nine');
    Route::get('/dashboard/2026/form-ten', [DashboardController::class, 'formTen'])->name('dashboard.form-ten');
    Route::get('/dashboard/2026/form-eleven', [DashboardController::class, 'formEleven'])->name('dashboard.form-eleven');

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

    Route::get('bussiness-assistants/{bussinessAssistant}/form-8', [BussinessAssistantController::class, 'form8'])
        ->name('bussiness-assistants.form-8');
    Route::post(
        'bussiness-assistants/{bussinessAssistant}/form-8',
        [BussinessAssistantController::class, 'storeOrUpdateFormEight']
    )->name('bussiness-assistants.form-8.store');

    Route::get('bussiness-assistants/{bussinessAssistant}/form-9', [BussinessAssistantController::class, 'form9'])
        ->name('bussiness-assistants.form-9');
    Route::post(
        'bussiness-assistants/{bussinessAssistant}/form-9',
        [BussinessAssistantController::class, 'storeOrUpdateFormNine']
    )->name('bussiness-assistants.form-9.store');

    Route::get('bussiness-assistants/{bussinessAssistant}/form-10', [BussinessAssistantController::class, 'form10'])
        ->name('bussiness-assistants.form-10');
    Route::post(
        'bussiness-assistants/{bussinessAssistant}/form-10',
        [BussinessAssistantController::class, 'storeOrUpdateFormTen']
    )->name('bussiness-assistants.form-10.store');

    Route::get('bussiness-assistants/{bussinessAssistant}/form-eleven', [BussinessAssistantController::class, 'form11'])
        ->name('bussiness-assistants.form-11');
    Route::post(
        'bussiness-assistants/{bussinessAssistant}/form-11',
        [BussinessAssistantController::class, 'storeOrUpdateFormEleven']
    )->name('bussiness-assistants.form-11.store');



    Route::get('bussiness-assistants/{bussinessAssistant}/report', [BussinessAssistantController::class, 'generateReport'])
        ->name('bussiness-assistants.report');

    Route::get('bussiness-assistants/{bussinessAssistant}/simkopdes-completeness', [BussinessAssistantController::class, 'simkopdesCompletenes'])
        ->name('bussiness-assistants.simkopdes-completeness');

    Route::post(
        'bussiness-assistants/{bussinessAssistant}/simkopdes-completeness',
        [BussinessAssistantController::class, 'storeOrUpdateSimkopdesComplete']
    )->name('bussiness-assistants.simkopdes-completeness.store');



    Route::get('form-two/export', [BussinessAssistantController::class, 'formTwoExport'])->name('bussiness-assistants.form-two.export');

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
    Route::resource('link-drives', LinkDriveController::class);
    Route::resource('articles', ArticleController::class);
    Route::resource('announcements', AnnouncementController::class);
    Route::resource('commodities', CommodityController::class);
    Route::post(
        '/form-seven/record-all',
        [RecordFormSevenController::class, 'storeAllRecord']
    )->name('form-seven.record.all');
});

require __DIR__ . '/auth.php';
