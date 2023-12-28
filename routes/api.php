<?php

use Illuminate\Http\Request;
use Illuminate\Routing\Route;
use App\Http\Controllers\MerchantsController;
use App\Models\ApiKey;
/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

//Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//    return $request->user();
//});

Route::post('/listPayments', function (Request $request) {
    // Get request parameters
    $apiKey = $request->api_key;
    $live =$request->live?? false;
    // Check if API key exists in the database
    $api = ApiKey::where('api_key', $apiKey)->first();

    if ($api) {
        // Set endpoint based on the "live" parameter
        $endpoint = $live ? 'https://finix.live-payments-api.com' : 'https://finix.sandbox-payments-api.com';

        // Call the listPayments function with the appropriate parameters
        $result = MerchantsController::listPayments(config("app.api_username"),config("app.api_password"), config(), $endpoint, ['filter' => json_encode(['tags.api' => $apiKey])]);

        return response()->json($result[0]);
    } else {
        // API key not found
        return response()->json(['error' => 'Invalid API key'], 401);
    }
});
Route::post('/fetchPayment', function () {
    // Get request parameters
    $apiKey = request('api_key');
    $live = request('live', false);
    $paymentId = request('payment_id');

    // Check if API key exists in the database
    $api = ApiKey::where('api_key', $apiKey)->first();

    if ($api) {
        // Set endpoint based on the "live" parameter
        $endpoint = $live ? 'https://finix.live-payments-api.com' : 'https://finix.sandbox-payments-api.com';

        // Call the fetchPayment function with the appropriate parameters
        $result = MerchantsController::fetchPayment(config("app.api_username"),config("app.api_password"), $paymentId, $endpoint);

        return response()->json($result);
    } else {
        // API key not found
        return response()->json(['error' => 'Invalid API key'], 401);
    }
});

