<?php

namespace App\Http\Controllers\API;

use App\Domains\Auth\Models\User;
use App\Http\Controllers\API\merchantsController;
use App\Models\ApiKey;
use App\Models\ApiUser;
use App\Models\identities;
use App\Models\identities_live;
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
public function retrieveInfo($apiKey){
    $apiKey=ApiKey::where('api_key', $apiKey)->first();
    if($apiKey==null){
        $user=User::where('api_key', $apiKey)->first();
        if($user!==null){
            $api_userID=$user->api_users_id;
            $live=$user->live;
        }else{
            return ['worked'=>false,"responce"=>"Invalid API key"];
        }
    }else{
        $api_userID=$apiKey->api_user;
        $apiKey=$apiKey->id;
        $live=$apiKey->live;
    }
    $userID=$api_userID->user_id;
    return ['worked'=>true,"apikey"=>$apiKey,'api_userID'=>$api_userID,'userID'=>$userID,"live"=>$live];
}
public function getBalance($request){}
public function createCustomer(){
    $request=request()->all();
    $info=$this->retrieveInfo($request['apikey']);
    if(!$info['worked']){return response()->json(['error' => 'Invalid API key'], 401);}
    if($info['live']){
        $custumer=identities_live::makeBuyerIdentity($request['email'],$request['userID'],$request['api_userID'],$request['apikey']??0);
    }else{
        $custumer=identities::makeBuyerIdentity($request['email'],$request['userID'],$request['api_userID'],$request['apikey']??0);
    }
    if($custumer['worked']){
        return response()->json($custumer['responce'], 200);
    }
    return response()->json($custumer['responce'], 301);
}
public function updateCustomer($request){}
public function getCustomer(){
    $request=request()->all();
    $info=$this->retrieveInfo($request['apikey']);
    if($info['live']){
        $custumer=identities_live::authenticateGetCustomerByID($request['id'],$request['api_userID'],$request['apikey']);
    }else{
        $custumer=identities::authenticateGetCustomerByID($request['id'],$request['api_userID'],$request['apikey']);
    }
    return response()->json($custumer['responce'], 301);
}
public function getCustomers(){}
public function customers_search(){}
public function getCampaignCustomers(){}
public function getCampaignBalance(){}

public function createCharges(){}
public function updateCharge(){}
public function getCharge(){}
public function getCharges(){}
public function charges_search(){}


public function updateDispute(){}
public function getDispute(){}
public function getDisputes(){}
// public function postDisputeClose(){}


// public function event(){}
// public function events(){}


public function createFile(){}
public function getfile(){}
public function getfiles(){}

public function createFile_links(){}
public function file_link(){}
public function file_links(){}


public function createPayout(){}
public function updatePayout(){}
public function getPayout(){}
public function getPayouts(){}
public function cancelPayout(){}
public function reversePayout(){}

public function createRefund(){}
public function updateRefund(){}
public function getRefund(){}
public function getRefunds(){}

public function createBalenceTransfer(){}
public function updateBalenceTransfer(){}
public function getBalenceTransfer(){}
public function createBalenceTransfers(){}
public function balence_transfers_search(){}


public function postTokenize(){}

public function createPaymentWay(){}
public function updatePaymentWay(){}
public function getCustomerPaymentWay(){}
public function getCustomerPaymentWays(){}
public function getPaymentWays(){}
public function getPaymentWay(){}
public function payment_ways_search(){}


public function createCustomerCard(){}
public function updateCustomerCard(){}
public function updateCustomerBankAcount(){}
public function createCustomerBankAcount(){}
public function updateMerchantBankAcount(){}
public function createMerchantBankAcount(){}
public function getMerchantBankAcount(){}
public function getMerchantBankAcounts(){}
public function getCustomerCards(){}
public function getCustomerCard(){}
public function getCustomerBankAcount(){}
public function getCustomerBankAcounts(){}


public function createPaymentLink(){}
public function updatePaymentLink(){}
public function getPaymentLinks(){}
public function getPaymentLink(){}
public function payment_links_search(){}


public function createCheckout(){}
public function updateCheckout(){}
public function getCheckouts(){}
public function getCheckout(){}
public function checkout_search(){}


public function createHold(){}
public function updateHold(){}
public function getHold(){}
public function getHolds(){}
public function hold_search(){}

public function createSubscription(){}
public function updateSubscription(){}
public function getSubscription(){}
public function getSubscriptions(){}
public function subscriptions_search(){}
}
