<?php

use App\Http\Controllers\API\RoutesController;
use Illuminate\Support\Facades\Route;

// Define the listPayments route
Route::post('/listPayments', [RoutesController::class,'listPayments' ]);

// Define the fetchPayment route
Route::post('/fetchPayment', [RoutesController::class,'fetchPayment' ]);

Route::post('/refundPayment', [RoutesController::class,'refundPayment' ]);