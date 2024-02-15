<?php

use App\Http\Controllers\API\RoutesController;
use App\Http\Controllers\API\webhooksController;
use Illuminate\Support\Facades\Route;

// Route::get('/listPayments', [RoutesController::class, 'listPayments' ]);

// // Define the fetchPayment route (changed to GET)
// Route::get('/fetchPayment/{id}', [RoutesController::class, 'fetchPayment' ]);

// // Define the refundPayment route (changed to GET)
// Route::get('/refundPayment/{id}', [RoutesController::class, 'refundPayment' ]);
// Route::get("/merchants",[RoutesController::class, 'merchants']);
// Route::get("/identities",[RoutesController::class, 'identities']);
// Route::get("/payments",[RoutesController::class, 'payments']);
// Route::get("/payment_instraments",[RoutesController::class, 'payment_instraments']);
// Route::get("/merchant/{id}",[RoutesController::class, 'merchant']);
// Route::get("/identity/{id}",[RoutesController::class, 'identity']);
// Route::get("/payment/{id}",[RoutesController::class, 'payments']);
// Route::get("/payment_instrament/{id}",[RoutesController::class, 'payment_instrament']);

// Route::post('/makePyament', [RoutesController::class,'makePyament' ]);
// Route::get('/cardwiz/balance', [RoutesController::class,'getBalance' ]);
// Route::get('/cardwiz/balance_transactions/{id}', [RoutesController::class,'balance_transaction' ]);
// Route::get('/cardwiz/balance_transactions', [RoutesController::class,'balance_transactions' ]);

Route::post('/cardwiz/customers', [RoutesController::class,'createCustomer' ]);
Route::post('/cardwiz/customers/{id}', [RoutesController::class,'updateCustomer' ]);
Route::get('/cardwiz/customers/{id}', [RoutesController::class,'getCustomer' ]);
Route::get('/cardwiz/customers', [RoutesController::class,'getCustomers' ]);
Route::get('/cardwiz/customers/search', [RoutesController::class,'customers_search' ]);
Route::get('/cardwiz/merchant/{id}/customers', [RoutesController::class,'getCampaignCustomers' ]);
Route::get('/cardwiz/campaign/{id}/customers', [RoutesController::class,'getCampaignCustomers' ]);
Route::get('/cardwiz/merchant/{id}/balance', [RoutesController::class,'getCampaignBalance' ]);
Route::get('/cardwiz/campaign/{id}/balance', [RoutesController::class,'getCampaignBalance' ]);

Route::post('/cardwiz/charges', [RoutesController::class,'createCharges' ]);
Route::post('/cardwiz/charges/{id}', [RoutesController::class,'updateCharge' ]);
Route::get('/cardwiz/charges/{id}', [RoutesController::class,'getCharge' ]);
Route::get('/cardwiz/charges', [RoutesController::class,'getCharges' ]);
// Route::post('/cardwiz/charges/{id}/capture', [RoutesController::class,'postChargeCapture' ]);
Route::get('/cardwiz/charges/search', [RoutesController::class,'charges_search' ]);


Route::post('/cardwiz/disputes/{id}', [RoutesController::class,'updateDispute' ]);
Route::get('/cardwiz/disputes/{id}', [RoutesController::class,'getDispute' ]);
Route::get('/cardwiz/disputes', [RoutesController::class,'getDisputes' ]);
// Route::post('/cardwiz/disputes/{id}/close', [RoutesController::class,'postDisputeClose' ]);


// Route::get('/cardwiz/events/{id}', [RoutesController::class,'event' ]);
// Route::get('/cardwiz/events', [RoutesController::class,'events' ]);


Route::post('/cardwiz/files', [RoutesController::class,'createFile' ]);
Route::get('/cardwiz/files/{id}', [RoutesController::class,'getfile' ]);
Route::get('/cardwiz/files', [RoutesController::class,'getfiles' ]);

Route::post('/cardwiz/file_links', [RoutesController::class,'createFile_links' ]);
Route::get('/cardwiz/file_links/{id}', [RoutesController::class,'file_link' ]);
Route::get('/cardwiz/file_links', [RoutesController::class,'file_links' ]);


Route::post('/cardwiz/payouts', [RoutesController::class,'createPayout' ]);
Route::post('/cardwiz/payouts/{id}', [RoutesController::class,'updatePayout' ]);
Route::get('/cardwiz/payouts/{id}', [RoutesController::class,'getPayout' ]);
Route::get('/cardwiz/payouts', [RoutesController::class,'getPayouts' ]);
Route::post('/cardwiz/payouts/{id}/cancel', [RoutesController::class,'cancelPayout' ]);
Route::post('/cardwiz/payouts/{id}/reverse', [RoutesController::class,'reversePayout' ]);

Route::post('/cardwiz/refunds', [RoutesController::class,'createRefund' ]);
Route::post('/cardwiz/refunds/{id}', [RoutesController::class,'updateRefund' ]);
Route::get('/cardwiz/refunds/{id}', [RoutesController::class,'getRefund' ]);
Route::get('/cardwiz/refunds', [RoutesController::class,'getRefunds' ]);

Route::post('/cardwiz/balenceTransfers', [RoutesController::class,'createBalenceTransfer' ]);
Route::post('/cardwiz/balenceTransfers/{id}', [RoutesController::class,'updateBalenceTransfer' ]);
Route::get('/cardwiz/balenceTransfers/{id}', [RoutesController::class,'getBalenceTransfer' ]);
Route::get('/cardwiz/balenceTransfers', [RoutesController::class,'createBalenceTransfers' ]);
Route::get('/cardwiz/balenceTransfers/search', [RoutesController::class,'balence_transfers_search' ]);


Route::post('/cardwiz/tokenize', [RoutesController::class,'postTokenize' ]);

Route::post('/cardwiz/payment_ways', [RoutesController::class,'createPaymentWay' ]);
Route::post('/cardwiz/payment_ways/{id}', [RoutesController::class,'updatePaymentWay' ]);
Route::get('/cardwiz/customers/{id}/payment_ways/{payID}', [RoutesController::class,'getCustomerPaymentWay' ]);
Route::get('/cardwiz/customers/{id}/payment_ways', [RoutesController::class,'getCustomerPaymentWays' ]);
Route::get('/cardwiz/payment_ways', [RoutesController::class,'getPaymentWays' ]);
Route::get('/cardwiz/payment_ways', [RoutesController::class,'getPaymentWay' ]);
Route::get('/cardwiz/payment_ways/search', [RoutesController::class,'payment_ways_search' ]);


Route::post('/cardwiz/customers/{id}/cards', [RoutesController::class,'createCustomerCard' ]);
Route::post('/cardwiz/customers/{id}/cards/{cardId}', [RoutesController::class,'updateCustomerCard' ]);
Route::post('/cardwiz/customers/{id}/bank_accounts/{bankID}', [RoutesController::class,'updateCustomerBankAcount' ]);
Route::post('/cardwiz/customers/{id}/bank_accounts', [RoutesController::class,'createCustomerBankAcount' ]);
Route::post('/cardwiz/merchant/{id}/bank_accounts/{bankID}', [RoutesController::class,'updateMerchantBankAcount' ]);
Route::post('/cardwiz/merchant/{id}/bank_accounts', [RoutesController::class,'createMerchantBankAcount' ]);
Route::get('/cardwiz/merchant/{id}/bank_accounts/{bankID}', [RoutesController::class,'getMerchantBankAcount' ]);
Route::get('/cardwiz/merchant/{id}/bank_accounts', [RoutesController::class,'getMerchantBankAcounts' ]);
Route::get('/cardwiz/customers/{id}/cards', [RoutesController::class,'getCustomerCards' ]);
Route::get('/cardwiz/customers/{id}/cards/{CardId}', [RoutesController::class,'getCustomerCard' ]);
Route::get('/cardwiz/customers/{id}/bank_accounts/{bankID}', [RoutesController::class,'getCustomerBankAcount' ]);
Route::get('/cardwiz/customers/{id}/bank_accounts', [RoutesController::class,'getCustomerBankAcounts' ]);


Route::post('/cardwiz/payment_links', [RoutesController::class,'createPaymentLink' ]);
Route::post('/cardwiz/payment_links/{id}', [RoutesController::class,'updatePaymentLink' ]);
Route::get('/cardwiz/payment_links', [RoutesController::class,'getPaymentLinks' ]);
Route::get('/cardwiz/payment_links/{id}', [RoutesController::class,'getPaymentLink' ]);
Route::get('/cardwiz/payment_links/search', [RoutesController::class,'payment_links_search' ]);


Route::post('/cardwiz/checkout', [RoutesController::class,'createCheckout' ]);
Route::post('/cardwiz/checkout/{id}', [RoutesController::class,'updateCheckout' ]);
Route::get('/cardwiz/checkout', [RoutesController::class,'getCheckouts' ]);
Route::get('/cardwiz/checkout/{id}', [RoutesController::class,'getCheckout' ]);
Route::get('/cardwiz/checkout/search', [RoutesController::class,'checkout_search' ]);


Route::post('/cardwiz/holds', [RoutesController::class,'createHold' ]);
Route::post('/cardwiz/holds/{id}', [RoutesController::class,'updateHold' ]);
Route::post('/cardwiz/holds/{id}/capture', [RoutesController::class,'captureHold' ]);
Route::post('/cardwiz/holds/{id}/release', [RoutesController::class,'releaseHold' ]);
Route::get('/cardwiz/holds/{id}', [RoutesController::class,'getHold' ]);
Route::get('/cardwiz/holds', [RoutesController::class,'getHolds' ]);
Route::get('/cardwiz/holds/search', [RoutesController::class,'hold_search' ]);

Route::post('/cardwiz/subscriptions', [RoutesController::class,'createSubscription' ]);
Route::post('/cardwiz/subscriptions/{id}', [RoutesController::class,'updateSubscription' ]);
Route::get('/cardwiz/subscriptions/{id}', [RoutesController::class,'getSubscription' ]);
Route::get('/cardwiz/subscriptions', [RoutesController::class,'getSubscriptions' ]);
Route::get('/cardwiz/subscriptions/search', [RoutesController::class,'subscriptions_search' ]);
Route::post('webhook', [webhooksController::class,'webhookUpdateRoute' ]);
Route::post('webhook/live', [webhooksController::class,'webhookUpdateRouteLive' ]);
