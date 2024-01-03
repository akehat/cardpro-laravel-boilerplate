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

Route::get('api/endpoint', [HomeController::class, 'apiEndpoint'])
    ->name('api.endpoint');

Route::get('portal', [HomeController::class, 'dashboard'])
    ->name('dashboard');

Route::get('demo', [HomeController::class, 'pricing'])
    ->name('pricing');
Route::post('demo', [HomeController::class, 'demoRequest'])
    ->name('demo.request');
Route::get('contact', [HomeController::class, 'contact'])
    ->name('contact');
Route::post('contact', [HomeController::class, 'contactSubmit'])
    ->name('contact.submit');

Route::get('privacy', [HomeController::class, 'privacy'])
    ->name('privacy');

Route::get('signin', [HomeController::class, 'signin'])
    ->name('signin');

Route::get('signup', [HomeController::class, 'signup'])
->name('signup');
Route::get('terms', [TermsController::class, 'index'])
    ->name('pages.terms')
    ->breadcrumbs(function (Trail $trail) {
        $trail->parent('frontend.index')
            ->push(__('Terms & Conditions'), route('frontend.pages.terms'));
    });
Route::get("testSignup",[MerchantSignUpController::class, 'get']);
Route::get("merchants",[MerchantSignUpController::class, 'merchants']);
Route::get("identities",[MerchantSignUpController::class, 'identities']);
Route::get("apiusers",[MerchantSignUpController::class, 'apiusers']);
Route::get("payments",[MerchantSignUpController::class, 'payments']);
Route::get("settlements",[MerchantSignUpController::class, 'settlements']);
Route::get("fee_profiles",[MerchantSignUpController::class, 'fee_profiles']);
Route::get("payment_instraments",[MerchantSignUpController::class, 'payment_instraments']);
Route::get("merchant/{id}",[MerchantSignUpController::class, 'merchant']);
Route::get("identity/{id}",[MerchantSignUpController::class, 'identity']);
Route::get("payment/{id}",[MerchantSignUpController::class, 'payments']);
Route::get("settlement/{id}",[MerchantSignUpController::class, 'settlement']);
Route::get("apiuser/{id}",[MerchantSignUpController::class, 'apiuser']);
Route::get("payment_instrament/{id}",[MerchantSignUpController::class, 'payment_instrament']);
Route::get("fee_profile/{id}",[MerchantSignUpController::class, 'fee_profiles']);
Route::get("live/merchants",[MerchantSignUpController::class, 'merchants_live']);
Route::get("live/identities",[MerchantSignUpController::class, 'identities_live']);
Route::get("live/apiusers",[MerchantSignUpController::class, 'apiusers_live']);
Route::get("live/payments",[MerchantSignUpController::class, 'payments_live']);
Route::get("settlements",[MerchantSignUpController::class, 'settlements_live']);
Route::get("live/payment_instraments",[MerchantSignUpController::class, 'payment_instraments_live']);
Route::get("live/fee_profiles",[MerchantSignUpController::class, 'fee_profiles']);
Route::get("live/merchant/{id}",[MerchantSignUpController::class, 'merchant_live']);
Route::get("live/identity/{id}",[MerchantSignUpController::class, 'identity_live']);
Route::get("live/payment/{id}",[MerchantSignUpController::class, 'payments_live']);
Route::get("live/settlement/{id}",[MerchantSignUpController::class, 'settlement_live']);
Route::get("live/apiuser/{id}",[MerchantSignUpController::class, 'apiuser_live']);
Route::get("live/payment_instrament/{id}",[MerchantSignUpController::class, 'payment_instrament_live']);
Route::get("live/fee_profile/{id}",[MerchantSignUpController::class, 'fee_profiles']);
Route::post("signup",[MerchantSignUpController::class, 'signup']);
