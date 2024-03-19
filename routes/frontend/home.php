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
    Route::get("portal/testSignup",[MerchantSignUpController::class, 'get'])->name('portal.testSignup');
    Route::get("portal/keys",[MerchantSignUpController::class, 'getKeys'])->name('portal.keys');
    Route::get("portal/testFee",[MerchantSignUpController::class, 'getFeeForm'])->name('portal.testFee');
    Route::get("portal/testCheckout",[MerchantSignUpController::class, 'getCheckout'])->name('portal.testCheckout');
    Route::get("portal/testPaylink",[MerchantSignUpController::class, 'getPaylink'])->name('portal.testPaylink');
    Route::get("portal/testPayment",[MerchantSignUpController::class, 'getPayment'])->name('portal.testPayment');
    Route::get("portal/testHold",[MerchantSignUpController::class, 'getHold'])->name('portal.testHold');
    Route::get("portal/liveSignup",[MerchantSignUpController::class, 'getLive'])->name('portal.liveSignup');
    Route::get("portal/liveFee",[MerchantSignUpController::class, 'getFeeFormLive'])->name('portal.liveFee');
    Route::get("portal/liveCheckout",[MerchantSignUpController::class, 'getCheckoutLive'])->name('portal.liveCheckout');
    Route::get("portal/livePaylink",[MerchantSignUpController::class, 'getLivePaylink'])->name('portal.livePaylink');
    Route::get("portal/livePayment",[MerchantSignUpController::class, 'getPaymentLive'])->name('portal.livePayment');
    Route::get("portal/liveHold",[MerchantSignUpController::class, 'getHoldLive'])->name('portal.liveHold');
    Route::get("portal/merchants",[MerchantSignUpController::class, 'merchants'])->name('portal.merchants');
    Route::get("portal/identities",[MerchantSignUpController::class, 'identities'])->name('portal.identities');
    Route::get("portal/apiusers",[MerchantSignUpController::class, 'apiusers'])->name('portal.apiusers');
    Route::get("portal/payments",[MerchantSignUpController::class, 'payments'])->name('portal.payments');
    Route::get("portal/balanceTransfers",[MerchantSignUpController::class, 'balanceTransfers'])->name('portal.balanceTransfers');
    Route::get("portal/settlements",[MerchantSignUpController::class, 'settlements'])->name('portal.settlements');
    Route::get("portal/fee_profiles",[MerchantSignUpController::class, 'fee_profiles'])->name('portal.fee_profiles');
    Route::get("portal/payment_instraments",[MerchantSignUpController::class, 'payment_instraments'])->name('portal.payment_instraments');
    Route::get("portal/merchant/{id}",[MerchantSignUpController::class, 'merchant'])->name('portal.merchant');
    Route::get("portal/identity/{id}",[MerchantSignUpController::class, 'identity'])->name('portal.identity');
    Route::get("portal/payment/{id}",[MerchantSignUpController::class, 'payments'])->name('portal.payment');
    Route::get("portal/settlement/{id}",[MerchantSignUpController::class, 'settlement'])->name('portal.settlement');
    Route::get("portal/balanceTransfer/{id}",[MerchantSignUpController::class, 'balanceTransfer'])->name('portal.balanceTransfer');
    Route::get("portal/apiuser/{id}",[MerchantSignUpController::class, 'apiuser'])->name('portal.apiuser');
    Route::get("portal/payment_instrament/{id}",[MerchantSignUpController::class, 'payment_instrament'])->name('portal.payment_instrament');
    Route::get("portal/fee_profile/{id}",[MerchantSignUpController::class, 'fee_profiles'])->name('portal.fee_profile');
    Route::get("portal/dispute/{id}",[MerchantSignUpController::class, 'dispute'])->name('portal.dispute');
    Route::get("portal/disputes",[MerchantSignUpController::class, 'disputes'])->name('portal.disputes');
    Route::get("portal/live/dispute/{id}",[MerchantSignUpController::class, 'dispute_live'])->name('portal.live.dispute');
    Route::get("portal/live/disputes",[MerchantSignUpController::class, 'disputes_live'])->name('portal.live.disputes');
    Route::get("portal/file/{id}",[MerchantSignUpController::class, 'file'])->name('portal.file');
    Route::get("portal/files",[MerchantSignUpController::class, 'files'])->name('portal.files');
    Route::get("portal/live/file/{id}",[MerchantSignUpController::class, 'file_live'])->name('portal.live.file');
    Route::get("portal/live/files",[MerchantSignUpController::class, 'files_live'])->name('portal.live.files');
    Route::get("portal/externalfile/{id}",[MerchantSignUpController::class, 'externalfile'])->name('portal.externalfile');
    Route::get("portal/externalfiles",[MerchantSignUpController::class, 'externalfiles'])->name('portal.externalfiles');
    Route::get("portal/live/externalfile/{id}",[MerchantSignUpController::class, 'externalfile_live'])->name('portal.live.externalfile');
    Route::get("portal/live/externalfiles",[MerchantSignUpController::class, 'externalfiles_live'])->name('portal.live.externalfiles');
    Route::get("portal/compliance/{id}",[MerchantSignUpController::class, 'compliance'])->name('portal.compliance');
    Route::get("portal/compliances",[MerchantSignUpController::class, 'compliances'])->name('portal.compliances');
    Route::get("portal/live/compliance/{id}",[MerchantSignUpController::class, 'compliance_live'])->name('portal.live.compliance');
    Route::get("portal/live/compliances",[MerchantSignUpController::class, 'compliances_live'])->name('portal.live.compliances');
    Route::get("portal/hold/{id}",[MerchantSignUpController::class, 'hold'])->name('portal.hold');
    Route::get("portal/holds",[MerchantSignUpController::class, 'holds'])->name('portal.holds');
    Route::get("portal/live/hold/{id}",[MerchantSignUpController::class, 'hold_live'])->name('portal.live.hold');
    Route::get("portal/live/holds",[MerchantSignUpController::class, 'holds_live'])->name('portal.live.holds');
    Route::get("portal/paymentLink/{id}",[MerchantSignUpController::class, 'paymentLink'])->name('portal.paymentLink');
    Route::get("portal/paymentLinks",[MerchantSignUpController::class, 'paymentLinks'])->name('portal.paymentLinks');
    Route::get("portal/live/paymentLink/{id}",[MerchantSignUpController::class, 'paymentLink_live'])->name('portal.live.paymentLink');
    Route::get("portal/live/paymentLinks",[MerchantSignUpController::class, 'paymentLinks_live'])->name('portal.live.paymentLinks');
    Route::get("portal/balanceTransfer/{id}",[MerchantSignUpController::class, 'balanceTransfer'])->name('portal.balanceTransfer');
    Route::get("portal/balanceTransfers",[MerchantSignUpController::class, 'balanceTransfers'])->name('portal.balanceTransfers');
    Route::get("portal/live/balanceTransfer/{id}",[MerchantSignUpController::class, 'balanceTransfer_live'])->name('portal.live.balanceTransfer');
    Route::get("portal/live/balanceTransfers",[MerchantSignUpController::class, 'balanceTransfers_live'])->name('portal.live.balanceTransfers');
    Route::get("portal/verification/{id}",[MerchantSignUpController::class, 'verification'])->name('portal.verification');
    Route::get("portal/verifications",[MerchantSignUpController::class, 'verifications'])->name('portal.verifications');
    Route::get("portal/live/verification/{id}",[MerchantSignUpController::class, 'verification_live'])->name('portal.live.verification');
    Route::get("portal/live/verifications",[MerchantSignUpController::class, 'verifications_live'])->name('portal.live.verifications');
    Route::get("portal/subscriptionSchedule/{id}",[MerchantSignUpController::class, 'subscriptionSchedule'])->name('portal.subscriptionSchedule');
    Route::get("portal/subscriptionSchedules",[MerchantSignUpController::class, 'subscriptionSchedules'])->name('portal.subscriptionSchedules');
    Route::get("portal/live/subscriptionSchedule/{id}",[MerchantSignUpController::class, 'subscriptionSchedule_live'])->name('portal.live.subscriptionSchedule');
    Route::get("portal/live/subscriptionSchedules",[MerchantSignUpController::class, 'subscriptionSchedules_live'])->name('portal.live.subscriptionSchedules');
    Route::get("portal/subscriptionAmount/{id}",[MerchantSignUpController::class, 'subscriptionAmount'])->name('portal.subscriptionAmount');
    Route::get("portal/subscriptionAmounts",[MerchantSignUpController::class, 'subscriptionAmounts'])->name('portal.subscriptionAmounts');
    Route::get("portal/live/subscriptionAmount/{id}",[MerchantSignUpController::class, 'subscriptionAmount_live'])->name('portal.live.subscriptionAmount');
    Route::get("portal/live/subscriptionAmounts",[MerchantSignUpController::class, 'subscriptionAmounts_live'])->name('portal.live.subscriptionAmounts');
    Route::get("portal/subscriptionEnrollment/{id}",[MerchantSignUpController::class, 'subscriptionEnrollment'])->name('portal.subscriptionEnrollment');
    Route::get("portal/subscriptionEnrollments",[MerchantSignUpController::class, 'subscriptionEnrollments'])->name('portal.subscriptionEnrollments');
    Route::get("portal/live/subscriptionEnrollment/{id}",[MerchantSignUpController::class, 'subscriptionEnrollment_live'])->name('portal.live.subscriptionEnrollment');
    Route::get("portal/live/subscriptionEnrollments",[MerchantSignUpController::class, 'subscriptionEnrollments_live'])->name('portal.live.subscriptionEnrollments');
    Route::get("portal/checkout/{id}",[MerchantSignUpController::class, 'checkout'])->name('portal.checkout');
    Route::get("portal/checkouts",[MerchantSignUpController::class, 'checkouts'])->name('portal.checkouts');
    Route::get("portal/live/checkout/{id}",[MerchantSignUpController::class, 'checkout_live'])->name('portal.live.checkout');
    Route::get("portal/live/checkouts",[MerchantSignUpController::class, 'checkouts_live'])->name('portal.live.checkouts');
    Route::get("portal/live/merchants",[MerchantSignUpController::class, 'merchants_live'])->name('portal.live.merchants');
    Route::get("portal/live/identities",[MerchantSignUpController::class, 'identities_live'])->name('portal.live.identities');
    Route::get("portal/live/apiusers",[MerchantSignUpController::class, 'apiusers_live'])->name('portal.live.apiusers');
    Route::get("portal/live/payments",[MerchantSignUpController::class, 'payments_live'])->name('portal.live.payments');
    Route::get("portal/live/settlements",[MerchantSignUpController::class, 'settlements_live'])->name('portal.live.settlements');
    Route::get("portal/live/payment_instraments",[MerchantSignUpController::class, 'payment_instraments_live'])->name('portal.live.payment_instraments');
    Route::get("portal/live/fee_profiles",[MerchantSignUpController::class, 'fee_profiles'])->name('portal.live.fee_profiles');
    Route::get("portal/live/merchant/{id}",[MerchantSignUpController::class, 'merchant_live'])->name('portal.live.merchant');
    Route::get("portal/live/identity/{id}",[MerchantSignUpController::class, 'identity_live'])->name('portal.live.identity');
    Route::get("portal/live/payment/{id}",[MerchantSignUpController::class, 'payments_live'])->name('portal.live.payment');
    Route::get("portal/live/balanceTransfers",[MerchantSignUpController::class, 'balanceTransfer'])->name('portal.live.balanceTransfers');
    Route::get("portal/live/balanceTransfer/{id}",[MerchantSignUpController::class, 'balanceTransfer_live'])->name('portal.live.balanceTransfer');
    Route::get("portal/live/settlement/{id}",[MerchantSignUpController::class, 'settlement_live'])->name('portal.live.settlement');
    Route::get("portal/live/apiuser/{id}",[MerchantSignUpController::class, 'apiuser_live'])->name('portal.live.apiuser');
    Route::get("portal/live/payment_instrament/{id}",[MerchantSignUpController::class, 'payment_instrament_live'])->name('portal.live.payment_instrament');
    Route::get("portal/live/fee_profile/{id}",[MerchantSignUpController::class, 'fee_profiles'])->name('portal.live.fee_profile');
    Route::post("signup",[MerchantSignUpController::class, 'signup']);
    Route::post("makeReturn",[MerchantSignUpController::class, 'makeReturn']);
    Route::post("paymentTest",[MerchantSignUpController::class, 'paymentTest']);
    Route::post("checkoutTest",[MerchantSignUpController::class, 'checkoutTest']);
    Route::post("paylinkTest",[MerchantSignUpController::class, 'paylinkTest']);
    Route::post("holdTest",[MerchantSignUpController::class, 'holdTest']);
    Route::post("feeTest",[MerchantSignUpController::class, 'feeProfileTest']);
    Route::post("captureHold",[MerchantSignUpController::class, 'captureHold']);
    Route::post("returnHold",[MerchantSignUpController::class, 'returnHold']);
    Route::post("signupLive",[MerchantSignUpController::class, 'signup']);
    Route::post("makeReturnLive",[MerchantSignUpController::class, 'makeReturn']);
    Route::post("paymentLive",[MerchantSignUpController::class, 'paymentLive']);
    Route::post("checkoutLive",[MerchantSignUpController::class, 'checkoutLive']);
    Route::post("paylinkLive",[MerchantSignUpController::class, 'paylinkLive']);
    Route::post("holdLive",[MerchantSignUpController::class, 'holdLive']);
    Route::post("feeLive",[MerchantSignUpController::class, 'feeProfileLive']);
    Route::post("captureHoldLive",[MerchantSignUpController::class, 'captureHold']);
    Route::post("returnHoldLive",[MerchantSignUpController::class, 'returnHold']);
    Route::post("setUserLiveStatus",[MerchantSignUpController::class, 'setUserLiveStatus']);
    });
