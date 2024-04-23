<?php

use App\Http\Controllers\UserController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use Illuminate\Support\Facades\App;
use App\Http\Controllers\ValidityController;
use App\Http\Controllers\EstateIndicatorController;

Route::get('/', function () {
    return redirect('/login');
});


Route::post('logoutUser', function(){
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
        Route::get('listUsers', 'show')->name('listUsers');
        Route::post('newUser', 'store')->name('newUser');
    });

    Route::controller(ValidityController::class)->group(function() {
        Route::get('listValidities', 'index')->name('listValidities');
    });

    Route::controller(EstateIndicatorController::class)->group(function(){
        Route::get('estateIndicators', 'show')->name('estateIndicators');
    });
});
