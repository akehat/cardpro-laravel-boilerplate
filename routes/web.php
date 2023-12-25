<?php

use App\Http\Controllers\LocaleController;
use app\Domains\Auth\Http\Controllers\Frontend\Auth\LoginController;
use app\Domains\Auth\Http\Controllers\Frontend\Auth\RegisterController;
/*
 * Global Routes
 *
 * Routes that are used between both frontend and backend.
 */

// Switch between the included languages
Route::get('lang/{lang}', [LocaleController::class, 'change'])->name('locale.change');

/*
 * Frontend Routes
 */
Route::group(['as' => 'frontend.'], function () {
    includeRouteFiles(__DIR__.'/frontend/');
});

/*
 * Backend Routes
 *
 * These routes can only be accessed by users with type `admin`
 */
Route::group(['prefix' => 'admin', 'as' => 'admin.', 'middleware' => 'admin'], function () {
    includeRouteFiles(__DIR__.'/backend/');
});

Route::get("/faq", function(){
    return view("FAQ");
});

Route::get("/privacy", function(){
    return view("privacy");
});

Route::get("/termsOfUsage", function(){
    return view("termsOfUsage");
});

Route::get("/prices", function(){
    return view("prices");
});

Route::group(['middleware' => 'guest'], function () {
    Route::get('login', [LoginController::class, 'showLoginForm'])->name('login');
    Route::post('login', [LoginController::class, 'login']);




Route::get('register', [RegisterController::class, 'showRegistrationForm'])->name('register');
Route::post('register', [RegisterController::class, 'register']);

});


