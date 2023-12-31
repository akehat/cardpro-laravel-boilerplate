<?php

use App\Http\Controllers\Frontend\HomeController;
use App\Http\Controllers\Frontend\TermsController;
use App\Http\Controllers\MerchantSignUpController;
use Tabuna\Breadcrumbs\Trail;

/*
 * Frontend Controllers
 * All route names are prefixed with 'frontend.'.
 */
Route::get('/', [HomeController::class, 'index'])
    ->name('index')
    ->breadcrumbs(function (Trail $trail) {
        $trail->push(__('Home'), route('frontend.index'));
    });

Route::get('terms', [TermsController::class, 'index'])
    ->name('pages.terms')
    ->breadcrumbs(function (Trail $trail) {
        $trail->parent('frontend.index')
            ->push(__('Terms & Conditions'), route('frontend.pages.terms'));
    });
Route::get("testSignup",[MerchantSignUpController::class, 'get']);
Route::get("merchants",[MerchantSignUpController::class, 'merchants']);
Route::get("identities",[MerchantSignUpController::class, 'identities']);
Route::get("payments",[MerchantSignUpController::class, 'payments']);
Route::get("payment_instraments",[MerchantSignUpController::class, 'payment_instraments']);
Route::get("merchant/{id}",[MerchantSignUpController::class, 'merchant']);
Route::get("identity/{id}",[MerchantSignUpController::class, 'identity']);
Route::get("payment/{id}",[MerchantSignUpController::class, 'payments']);
Route::get("payment_instrament/{id}",[MerchantSignUpController::class, 'payment_instrament']);
Route::get("live/merchants",[MerchantSignUpController::class, 'merchants_live']);
Route::get("live/identities",[MerchantSignUpController::class, 'identities_live']);
Route::get("live/payments",[MerchantSignUpController::class, 'payments_live']);
Route::get("live/payment_instraments",[MerchantSignUpController::class, 'payment_instraments_live']);
Route::get("live/merchant/{id}",[MerchantSignUpController::class, 'merchant_live']);
Route::get("live/identity/{id}",[MerchantSignUpController::class, 'identity_live']);
Route::get("live/payment/{id}",[MerchantSignUpController::class, 'payments_live']);
Route::get("live/payment_instrament/{id}",[MerchantSignUpController::class, 'payment_instrament_live']);
Route::post("signup",[MerchantSignUpController::class, 'signup']);