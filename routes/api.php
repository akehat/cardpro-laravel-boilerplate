<?php

use App\Http\Controllers\MerchantsController;
use App\Models\ApiKey;
use Illuminate\Support\Facades\Route;

// Define a function to handle common logic for both routes
function handlePaymentRequest($apiKey, $live, $paymentId = null)
{
    // Check if API key exists in the database
    $api = ApiKey::where('api_key', $apiKey)->first();

    if ($api) {
        // Set endpoint based on the "live" parameter
        $endpoint = $live ? 'https://finix.live-payments-api.com' : 'https://finix.sandbox-payments-api.com';

        // Call the appropriate function based on the presence of $paymentId
        if ($paymentId) {
            $result = MerchantsController::fetchPayment(config("app.api_username"), config("app.api_password"), $paymentId, $endpoint);
        } else {
            $result = MerchantsController::listPayments(config("app.api_username"), config("app.api_password"), config(), $endpoint, ['filter' => json_encode(['tags.api' => $apiKey])]);
        }

        return response()->json($result);
    } else {
        // API key not found
        return response()->json(['error' => 'Invalid API key'], 401);
    }
}

// Define the listPayments route
Route::post('/listPayments', function () {
    return handlePaymentRequest(request('api_key'), request('live', false));
});

// Define the fetchPayment route
Route::post('/fetchPayment', function () {
    return handlePaymentRequest(request('api_key'), request('live', false), request('payment_id'));
});
