<?php

use App\Http\Controllers\BussinessAssistantController;
use App\Http\Controllers\CooperationController;
use App\Http\Controllers\DistrictController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\VillageController;
use Illuminate\Support\Facades\Route;

// Route::get('/', function () {
//     return view('welcome');
// });

Route::get('/', [HomeController::class, 'index'])->name('welcomet');
Route::get('/map/filter', [HomeController::class, 'filter'])->name('map.filter');


Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::resource('districts', DistrictController::class);
    Route::resource('bussiness-assistants', BussinessAssistantController::class);
    Route::resource('cooperations', CooperationController::class);
    Route::resource('villages', VillageController::class);
});

require __DIR__ . '/auth.php';
