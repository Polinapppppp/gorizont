<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ApartmentController;

Route::get('/', function () {
    return view('welcome');
});

use App\Http\Controllers\AuthController;

Route::middleware('guest')->group(function () {
    Route::get('/register', [AuthController::class, 'showRegister'])->name('register.show');
    Route::post('/register', [AuthController::class, 'register'])->name('register.store');
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login.show');
    Route::post('/login', [AuthController::class, 'login'])->name('login.store');
});

Route::middleware('auth')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
    Route::post('/applications', [\App\Http\Controllers\ApplicationController::class, 'store'])->name('applications.store');
});
Route::middleware(\App\Http\Middleware\isAdmin::class)->group(function () {
    Route::get('/apartments/create', [\App\Http\Controllers\ApartmentController::class, 'create'])->name('apartments.create');

    Route::post('/apartments/store', [ApartmentController::class, 'store'])->name('apartments.store');


    Route::get('/apartments/{apartment}/edit', [ApartmentController::class, 'edit'])->name('apartments.edit');

    Route::put('/apartments/{apartment}/update', [ApartmentController::class, 'update'])->name('apartments.update');

    Route::delete('/apartments/{apartment}/destroy', [ApartmentController::class, 'destroy'])->name('apartments.destroy');

    Route::get('/admin/dashboard', [\App\Http\Controllers\AdminController::class, 'index'])->name('admin.dashboard');
    Route::post('/applications/{application}/assign', [\App\Http\Controllers\AdminController::class, 'assignRealtor'])->name('admin.assign-realtor');
    Route::post('/apartments/{apartment}/status', [\App\Http\Controllers\AdminController::class, 'updateApartmentStatus'])->name('admin.update-status');
});
Route::middleware(\App\Http\Middleware\IsRealtor::class)->group(function () {
    Route::get('/dashboard', [\App\Http\Controllers\RealtorController::class, 'index'])->name('realtor.dashboard');
    Route::post('/applications/{application}/status', [\App\Http\Controllers\RealtorController::class, 'updateStatus'])->name('realtor.update-status');
});
Route::get('/api/building/{building}/floor/{floor}', function ($buildingId, $floor) {
    $apartments = \App\Models\Apartment::where('building_id', $buildingId)
        ->where('floor', $floor)
        ->orderBy('zone_number')
        ->get(['id', 'zone_number', 'title', 'area', 'rooms', 'price', 'status', 'image']);

    return response()->json($apartments);
});

Route::get('/apartment/{id}', function ($id) {
    $apartment = \App\Models\Apartment::findOrFail($id);
    return view('apartments.show', compact('apartment'));
})->name('apartment.show');
Route::get('/apartments', [\App\Http\Controllers\ApartmentController::class, 'index'])->name('apartments.index');
Route::get('/apartments/{apartment}', [ApartmentController::class, 'show'])->name('apartments.show');
