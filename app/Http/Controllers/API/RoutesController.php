<?php

namespace App\Http\Controllers\API;
use App\Http\Controllers\API\merchantsController;
use App\Models\ApiKey;
use App\Models\ApiUser;

use Illuminate\Http\Request;

class RoutesController extends Controller
{
     function handlePaymentRequest($apiKey, $paymentId = null)
    {
        // Check if API key exists in the database
        $api = ApiKey::where('api_key', $apiKey)->first();
    
        if ($api) {
            // Set endpoint based on the "live" parameter
            $endpoint = $api->live ? 'https://finix.live-payments-api.com' : 'https://finix.sandbox-payments-api.com';
    
            // Call the appropriate function based on the presence of $paymentId
            if ($paymentId) {
                $result = merchantsController::fetchPayment(config("app.api_username"), config("app.api_password"), $paymentId, $endpoint);
            } else {
                $result = merchantsController::listPayments(config("app.api_username"), config("app.api_password"), config(), $endpoint, ['filter' => json_encode(['tags.api' => $apiKey])]);
            }
    
            return $result[0];
        } else {
            // API key not found
            return response()->json(['error' => 'Invalid API key'], 401);
        }
    }
    function handleMakePaymentRequest($apiKey, $live, $email, $exp_month, $exp_year, $name, $cardNumber, $cvv, $amount, $currency)
    {
        // Check if API key exists in the database
        $api = ApiKey::where('api_key', $apiKey)->first();
        $merchant = ApiUser::where('api_key',$apiKey)->first();
        if ($api) {
            // Set endpoint based on the "live" parameter
            $endpoint = $live ? 'https://finix.live-payments-api.com' : 'https://finix.sandbox-payments-api.com';
            $id=merchantsController::createIdentityBuyerMinReq(config("app.api_username"),config("app.api_password"),"byersolomon@mail.com",$endpoint);
            $id=json_decode($id[0],true)['id'];
            $card=merchantsController::createPaymentInstramentMinReq(config("app.api_username"),config("app.api_password"),
            $exp_month,$exp_year,$id,$name,$cardNumber,$cvv,"PAYMENT_CARD",$endpoint,[],["tags"=>["api"=>$api,"merchant"=>$merchant->id]]); 
            $card=json_decode($card[0],true)['id'];
            $result=merchantsController::makePaymentMinReq(config("app.api_username"),config("app.api_password"),$api->merchant,$currency,$amount,$card, $endpoint,[],["tags"=>["api"=>$api,"merchant"=>$merchant->id]]);
            return $result[0];
        } else {
            // API key not found
            return response()->json(['error' => 'Invalid API key'], 401);
        }
    }
    function handlePaymentMethodsRequest($apiKey, $live, $paymentMethodId = null)
    {
        // Check if API key exists in the database
        $api = ApiKey::where('api_key', $apiKey)->first();
    
        if ($api) {
            // Set endpoint based on the "live" parameter
            $endpoint = $live ? 'https://finix.live-payments-api.com' : 'https://finix.sandbox-payments-api.com';
    
            // Call the appropriate function based on the presence of $paymentId
            if ($paymentMethodId) {
                $result = merchantsController::fetchPayment(config("app.api_username"), config("app.api_password"), $paymentMethodId, $endpoint);
            } else {
                $result = merchantsController::listPaymentInstraments(config("app.api_username"), config("app.api_password"), config(), $endpoint, ['filter' => json_encode(['tags.api' => $apiKey])]);
            }
    
            return $result[0];
        } else {
            // API key not found
            return response()->json(['error' => 'Invalid API key'], 401);
        }
    }
    function handleRefundRequest($apiKey, $live, $paymentId, $refundAmount)
    {
        // Check if API key exists in the database
        $api = ApiKey::where('api_key', $apiKey)->first();
    
        if ($api) {
            // Set endpoint based on the "live" parameter
            $endpoint = $live ? 'https://finix.live-payments-api.com' : 'https://finix.sandbox-payments-api.com';
    
            // Call the appropriate function based on the presence of $paymentId
            if ($paymentId) {
                $result = merchantsController::createRefund(config("app.api_username"), config("app.api_password"), $paymentId, $refundAmount ,$endpoint);
            } 
    
            return $result[0];
        } else {
            // API key not found
            return response()->json(['error' => 'Invalid API key'], 401);
        }
    }
    function makePyament(){
        return $this->handleMakePaymentRequest(request('api_key'), request('live', false), request('email'),request('$exp_month'),request('$exp_year'),request('$name'),request('$cardNumber'),request('$cvv'),request('$amount'),request('currency'),);
    }
    function listPayments(){
        return $this->handlePaymentRequest(request('api_key'), request('live', false), null);
    }
    function fetchPayment(){
        return $this->handlePaymentRequest(request('api_key'), request('live', false), request('payment_id'));
    }
    function refundPayment(){
        return $this->handlePaymentRequest(request('api_key'), request('live', false), request('payment_id'),request('refund_amount'));
    }public function identities(){
        $apiKey = request()->header('Authorization');
        $api = ApiKey::where('api_key', $apiKey)->first();
        if ($api) {
        $endpoint = $api->live ? 'https://finix.live-payments-api.com' : 'https://finix.sandbox-payments-api.com';
        return merchantsController::listIdentities(config("app.api_username"),config("app.api_password"), $endpoint,array_merge(request()->query(),['filter' => json_encode(['tags.api' => $apiKey])]))[0];
        }
        return response()->json(['error' => 'Invalid API key'], 401);
    }
    public function identity($id){
        $apiKey = request()->header('Authorization');
        $api = ApiKey::where('api_key', $apiKey)->first();
        if ($api) {
        $endpoint = $api->live ? 'https://finix.live-payments-api.com' : 'https://finix.sandbox-payments-api.com';
        return merchantsController::fetchIDIdentity(config("app.api_username"),config("app.api_password"),$id, $endpoint,request()->query())[0];
        }
        return response()->json(['error' => 'Invalid API key'], 401);
    }
    public function payments(){
        $apiKey = request()->header('Authorization');
        $api = ApiKey::where('api_key', $apiKey)->first();
        if ($api) {
        $endpoint = $api->live ? 'https://finix.live-payments-api.com' : 'https://finix.sandbox-payments-api.com';
        return merchantsController::listPayments(config("app.api_username"),config("app.api_password"),$endpoint,request()->query())[0];
        }
        return response()->json(['error' => 'Invalid API key'], 401);
    }
    public function payment($id){
        $apiKey = request()->header('Authorization');
        $api = ApiKey::where('api_key', $apiKey)->first();
        if ($api) {
        $endpoint = $api->live ? 'https://finix.live-payments-api.com' : 'https://finix.sandbox-payments-api.com';
        return merchantsController::fetchPayment(config("app.api_username"),config("app.api_password"),$id,$endpoint,request()->query())[0];
        }
        return response()->json(['error' => 'Invalid API key'], 401);
    }
    public function payment_instraments(){
        $apiKey = request()->header('Authorization');
        $api = ApiKey::where('api_key', $apiKey)->first();
        if ($api) {
        $endpoint = $api->live ? 'https://finix.live-payments-api.com' : 'https://finix.sandbox-payments-api.com';
        return merchantsController::listPaymentInstraments(config("app.api_username"),config("app.api_password"),$endpoint,request()->query())[0];
        }
        return response()->json(['error' => 'Invalid API key'], 401);
    }
    public function payment_instrament($id){
        $apiKey = request()->header('Authorization');
        $api = ApiKey::where('api_key', $apiKey)->first();
        if ($api) {
        $endpoint = $api->live ? 'https://finix.live-payments-api.com' : 'https://finix.sandbox-payments-api.com';
        return merchantsController::fetchPaymentInstrament(config("app.api_username"),config("app.api_password"),$id,$endpoint,request()->query())[0];
        }
        return response()->json(['error' => 'Invalid API key'], 401);
    }
    public function merchants(){
        $apiKey = request()->header('Authorization');
        $api = ApiKey::where('api_key', $apiKey)->first();
        if ($api) {
        $endpoint = $api->live ? 'https://finix.live-payments-api.com' : 'https://finix.sandbox-payments-api.com';
         return merchantsController::listMerchants(config("app.api_username"),config("app.api_password"),$endpoint,request()->query())[0];
        }
        return response()->json(['error' => 'Invalid API key'], 401);
    }
    public function merchant($id){
        $apiKey = request()->header('Authorization');
        $api = ApiKey::where('api_key', $apiKey)->first();
        if ($api) {
        $endpoint = $api->live ? 'https://finix.live-payments-api.com' : 'https://finix.sandbox-payments-api.com';
        return  merchantsController::fetchMerchant(config("app.api_username"),config("app.api_password"),$id,$endpoint,request()->query())[0];
        }
        return response()->json(['error' => 'Invalid API key'], 401);
    }
    public function fee_profile($id){
        $apiKey = request()->header('Authorization');
        $api = ApiKey::where('api_key', $apiKey)->first();
        if ($api) {
        $endpoint = $api->live ? 'https://finix.live-payments-api.com' : 'https://finix.sandbox-payments-api.com';
        return  merchantsController::fetchFeeProfile(config("app.api_username"),config("app.api_password"),$id,$endpoint,request()->query())[0];
        }
        return response()->json(['error' => 'Invalid API key'], 401);
    }
    public function fee_profiles(){
        $apiKey = request()->header('Authorization');
        $api = ApiKey::where('api_key', $apiKey)->first();
        if ($api) {
        $endpoint = $api->live ? 'https://finix.live-payments-api.com' : 'https://finix.sandbox-payments-api.com';
        return merchantsController::listFeeProfile(config("app.api_username"),config("app.api_password"),$endpoint,request()->query())[0];
        }
        return response()->json(['error' => 'Invalid API key'], 401);
    }
}