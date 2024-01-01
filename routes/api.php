<?php

use App\Http\Controllers\API\RoutesController;
use Illuminate\Support\Facades\Route;

Route::get('/listPayments', [RoutesController::class, 'listPayments' ]);

// Define the fetchPayment route (changed to GET)
Route::get('/fetchPayment/{id}', [RoutesController::class, 'fetchPayment' ]);

// Define the refundPayment route (changed to GET)
Route::get('/refundPayment/{id}', [RoutesController::class, 'refundPayment' ]);
Route::get("/merchants",[RoutesController::class, 'merchants']);
Route::get("/identities",[RoutesController::class, 'identities']);
Route::get("/payments",[RoutesController::class, 'payments']);
Route::get("/payment_instraments",[RoutesController::class, 'payment_instraments']);
Route::get("/merchant/{id}",[RoutesController::class, 'merchant']);
Route::get("/identity/{id}",[RoutesController::class, 'identity']);
Route::get("/payment/{id}",[RoutesController::class, 'payments']);
Route::get("/payment_instrament/{id}",[RoutesController::class, 'payment_instrament']);

Route::post('/makePyament', [RoutesController::class,'makePyament' ]);