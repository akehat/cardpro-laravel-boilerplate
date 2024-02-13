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

Route::get('docs', [HomeController::class, 'apiEndpoint'])
    ->name('api.endpoint');


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
    Route::group(['middleware' => 'auth'], function () {

    Route::get('portal', [HomeController::class, 'dashboard'])
    ->name('dashboard');
    Route::get("portal/testSignup",[MerchantSignUpController::class, 'get']);
    Route::get("portal/keys",[MerchantSignUpController::class, 'getKeys']);
    Route::get("portal/testFee",[MerchantSignUpController::class, 'getFeeForm']);
    Route::get("portal/testCheckout",[MerchantSignUpController::class, 'getCheckout']);
    Route::get("portal/testPaylink",[MerchantSignUpController::class, 'getPaylink']);
    Route::get("portal/testPayment",[MerchantSignUpController::class, 'getPayment']);
    Route::get("portal/testHold",[MerchantSignUpController::class, 'getHold']);
    Route::get("portal/liveSignup",[MerchantSignUpController::class, 'getLive']);
    Route::get("portal/liveFee",[MerchantSignUpController::class, 'getLiveFeeForm']);
    Route::get("portal/liveCheckout",[MerchantSignUpController::class, 'getLiveCheckout']);
    Route::get("portal/livePaylink",[MerchantSignUpController::class, 'getLivePaylink']);
    Route::get("portal/livePayment",[MerchantSignUpController::class, 'getLivePayment']);
    Route::get("portal/liveHold",[MerchantSignUpController::class, 'getLiveHold']);
    Route::get("portal/merchants",[MerchantSignUpController::class, 'merchants']);
    Route::get("portal/identities",[MerchantSignUpController::class, 'identities']);
    Route::get("portal/apiusers",[MerchantSignUpController::class, 'apiusers']);
    Route::get("portal/payments",[MerchantSignUpController::class, 'payments']);
    Route::get("portal/balenceTransfers",[MerchantSignUpController::class, 'balenceTransfer']);
    Route::get("portal/settlements",[MerchantSignUpController::class, 'settlements']);
    Route::get("portal/fee_profiles",[MerchantSignUpController::class, 'fee_profiles']);
    Route::get("portal/payment_instraments",[MerchantSignUpController::class, 'payment_instraments']);
    Route::get("portal/merchant/{id}",[MerchantSignUpController::class, 'merchant']);
    Route::get("portal/identity/{id}",[MerchantSignUpController::class, 'identity']);
    Route::get("portal/payment/{id}",[MerchantSignUpController::class, 'payments']);
    Route::get("portal/settlement/{id}",[MerchantSignUpController::class, 'settlement']);
    Route::get("portal/balenceTransfer/{id}",[MerchantSignUpController::class, 'balenceTransfer']);
    Route::get("portal/apiuser/{id}",[MerchantSignUpController::class, 'apiuser']);
    Route::get("portal/payment_instrament/{id}",[MerchantSignUpController::class, 'payment_instrament']);
    Route::get("portal/fee_profile/{id}",[MerchantSignUpController::class, 'fee_profiles']);
    Route::get("portal/dispute/{id}",[MerchantSignUpController::class, 'dispute']);
    Route::get("portal/disputes",[MerchantSignUpController::class, 'disputes']);
    Route::get("portal/live/dispute/{id}",[MerchantSignUpController::class, 'dispute_live']);
    Route::get("portal/live/disputes",[MerchantSignUpController::class, 'disputes_live']);
    Route::get("portal/compliance/{id}",[MerchantSignUpController::class, 'compliance']);
    Route::get("portal/compliances",[MerchantSignUpController::class, 'compliances']);
    Route::get("portal/live/compliance/{id}",[MerchantSignUpController::class, 'compliance_live']);
    Route::get("portal/live/compliances",[MerchantSignUpController::class, 'compliances_live']);
    Route::get("portal/hold/{id}",[MerchantSignUpController::class, 'hold']);
    Route::get("portal/holds",[MerchantSignUpController::class, 'holds']);
    Route::get("portal/live/hold/{id}",[MerchantSignUpController::class, 'hold_live']);
    Route::get("portal/live/holds",[MerchantSignUpController::class, 'holds_live']);
    Route::get("portal/paymentLink/{id}",[MerchantSignUpController::class, 'paymentLink']);
    Route::get("portal/paymentLinks",[MerchantSignUpController::class, 'paymentLinks']);
    Route::get("portal/live/paymentLink/{id}",[MerchantSignUpController::class, 'paymentLink_live']);
    Route::get("portal/live/paymentLinks",[MerchantSignUpController::class, 'paymentLinks_live']);
    Route::get("portal/balanceTransfer/{id}",[MerchantSignUpController::class, 'balanceTransfer']);
    Route::get("portal/balanceTransfers",[MerchantSignUpController::class, 'balanceTransfers']);
    Route::get("portal/live/balanceTransfer/{id}",[MerchantSignUpController::class, 'balanceTransfer_live']);
    Route::get("portal/live/balanceTransfers",[MerchantSignUpController::class, 'balanceTransfers_live']);
    Route::get("portal/verification/{id}",[MerchantSignUpController::class, 'verification']);
    Route::get("portal/verifications",[MerchantSignUpController::class, 'verifications']);
    Route::get("portal/live/verification/{id}",[MerchantSignUpController::class, 'verification_live']);
    Route::get("portal/live/verifications",[MerchantSignUpController::class, 'verifications_live']);
    Route::get("portal/subscriptionSchedule/{id}",[MerchantSignUpController::class, 'subscriptionSchedule']);
    Route::get("portal/subscriptionSchedules",[MerchantSignUpController::class, 'subscriptionSchedules']);
    Route::get("portal/live/subscriptionSchedule/{id}",[MerchantSignUpController::class, 'subscriptionSchedule_live']);
    Route::get("portal/live/subscriptionSchedules",[MerchantSignUpController::class, 'subscriptionSchedules_live']);
    Route::get("portal/subscriptionAmount/{id}",[MerchantSignUpController::class, 'subscriptionAmount']);
    Route::get("portal/subscriptionAmounts",[MerchantSignUpController::class, 'subscriptionAmounts']);
    Route::get("portal/live/subscriptionAmount/{id}",[MerchantSignUpController::class, 'subscriptionAmount_live']);
    Route::get("portal/live/subscriptionAmounts",[MerchantSignUpController::class, 'subscriptionAmounts_live']);
    Route::get("portal/subscriptionEnrollment/{id}",[MerchantSignUpController::class, 'subscriptionEnrollment']);
    Route::get("portal/subscriptionEnrollments",[MerchantSignUpController::class, 'subscriptionEnrollments']);
    Route::get("portal/live/subscriptionEnrollment/{id}",[MerchantSignUpController::class, 'subscriptionEnrollment_live']);
    Route::get("portal/live/subscriptionEnrollments",[MerchantSignUpController::class, 'subscriptionEnrollments_live']);
    Route::get("portal/checkout/{id}",[MerchantSignUpController::class, 'checkout']);
    Route::get("portal/checkouts",[MerchantSignUpController::class, 'checkouts']);
    Route::get("portal/live/checkout/{id}",[MerchantSignUpController::class, 'checkout_live']);
    Route::get("portal/live/checkouts",[MerchantSignUpController::class, 'checkouts_live']);
    Route::get("portal/live/merchants",[MerchantSignUpController::class, 'merchants_live']);
    Route::get("portal/live/identities",[MerchantSignUpController::class, 'identities_live']);
    Route::get("portal/live/apiusers",[MerchantSignUpController::class, 'apiusers_live']);
    Route::get("portal/live/payments",[MerchantSignUpController::class, 'payments_live']);
    Route::get("portal/live/settlements",[MerchantSignUpController::class, 'settlements_live']);
    Route::get("portal/live/payment_instraments",[MerchantSignUpController::class, 'payment_instraments_live']);
    Route::get("portal/live/fee_profiles",[MerchantSignUpController::class, 'fee_profiles']);
    Route::get("portal/live/merchant/{id}",[MerchantSignUpController::class, 'merchant_live']);
    Route::get("portal/live/identity/{id}",[MerchantSignUpController::class, 'identity_live']);
    Route::get("portal/live/payment/{id}",[MerchantSignUpController::class, 'payments_live']);
    Route::get("portal/live/balenceTransfers",[MerchantSignUpController::class, 'balenceTransfer']);
    Route::get("portal/live/balenceTransfer/{id}",[MerchantSignUpController::class, 'balenceTransfer_live']);
    Route::get("portal/live/settlement/{id}",[MerchantSignUpController::class, 'settlement_live']);
    Route::get("portal/live/apiuser/{id}",[MerchantSignUpController::class, 'apiuser_live']);
    Route::get("portal/live/payment_instrament/{id}",[MerchantSignUpController::class, 'payment_instrament_live']);
    Route::get("portal/live/fee_profile/{id}",[MerchantSignUpController::class, 'fee_profiles']);
    Route::post("signup",[MerchantSignUpController::class, 'signup']);
    Route::post("makeReturn",[MerchantSignUpController::class, 'makeReturn']);
    Route::post("paymentTest",[MerchantSignUpController::class, 'paymentTest']);
    Route::post("checkoutTest",[MerchantSignUpController::class, 'checkoutTest']);
    Route::post("paylinkTest",[MerchantSignUpController::class, 'paylinkTest']);
    Route::post("holdTest",[MerchantSignUpController::class, 'holdTest']);
    Route::post("feeTest",[MerchantSignUpController::class, 'feeProfileTest']);
    Route::post("captureHold",[MerchantSignUpController::class, 'captureHold']);
    Route::post("returnHold",[MerchantSignUpController::class, 'returnHold']);
    });
