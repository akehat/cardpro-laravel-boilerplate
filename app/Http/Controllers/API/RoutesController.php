<?php

namespace App\Http\Controllers\API;
use App\Http\Controllers\API\merchantsController;
use App\Models\ApiKey;

use Illuminate\Http\Request;

class RoutesController extends Controller
{
     function handlePaymentRequest($apiKey, $live, $paymentId = null)
    {
        // Check if API key exists in the database
        $api = ApiKey::where('api_key', $apiKey)->first();
    
        if ($api) {
            // Set endpoint based on the "live" parameter
            $endpoint = $live ? 'https://finix.live-payments-api.com' : 'https://finix.sandbox-payments-api.com';
    
            // Call the appropriate function based on the presence of $paymentId
            if ($paymentId) {
                $result = merchantsController::fetchPayment(config("app.api_username"), config("app.api_password"), $paymentId, $endpoint);
            } else {
                $result = merchantsController::listPayments(config("app.api_username"), config("app.api_password"), config(), $endpoint, ['filter' => json_encode(['tags.api' => $apiKey])]);
            }
    
            return response()->json($result);
        } else {
            // API key not found
            return response()->json(['error' => 'Invalid API key'], 401);
        }
    }
    function listPayments(){
        return $this->handlePaymentRequest(request('api_key'), request('live', false));
    }
    function fetchPayment(){
        return $this->handlePaymentRequest(request('api_key'), request('live', false), request('payment_id'));
    }
}
