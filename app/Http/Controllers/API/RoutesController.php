<?php

namespace App\Http\Controllers\API;

use App\Domains\Auth\Models\User;
use App\Http\Controllers\API\merchantsController;
use App\Models\ApiKey;
use App\Models\ApiUser;
use App\Models\Authorization;
use App\Models\Authorization_live;
use App\Models\Finix_Merchant;
use App\Models\Finix_Merchant_live;
use App\Models\finix_payments;
use App\Models\finix_payments_live;
use App\Models\identities;
use App\Models\identities_live;
use App\Models\payment_ways;
use App\Models\payment_ways_live;
use Illuminate\Http\Request;
use Validator;

class RoutesController extends Controller
{
    //  function handlePaymentRequest($apiKey, $paymentId = null)
    // {
    //     // Check if API key exists in the database
    //     $api = ApiKey::where('api_key', $apiKey)->first();

    //     if ($api) {
    //         // Set endpoint based on the "live" parameter
    //         $endpoint = $api->live ? 'https://finix.live-payments-api.com' : 'https://finix.sandbox-payments-api.com';

    //         // Call the appropriate function based on the presence of $paymentId
    //         if ($paymentId) {
    //             $result = merchantsController::fetchPayment(config("app.api_username"), config("app.api_password"), $paymentId, $endpoint);
    //         } else {
    //             $result = merchantsController::listPayments(config("app.api_username"), config("app.api_password"), config(), $endpoint, ['filter' => json_encode(['tags.api' => $apiKey])]);
    //         }

    //         return $result[0];
    //     } else {
    //         // API key not found
    //         return response()->json(['error' => 'Invalid API key'], 401);
    //     }
    // }
    // function handleMakePaymentRequest($apiKey, $live, $email, $exp_month, $exp_year, $name, $cardNumber, $cvv, $amount, $currency)
    // {
    //     // Check if API key exists in the database
    //     $api = ApiKey::where('api_key', $apiKey)->first();
    //     $merchant = ApiUser::where('api_key',$apiKey)->first();
    //     if ($api) {
    //         // Set endpoint based on the "live" parameter
    //         $endpoint = $live ? 'https://finix.live-payments-api.com' : 'https://finix.sandbox-payments-api.com';
    //         $id=merchantsController::createIdentityBuyerMinReq(config("app.api_username"),config("app.api_password"),"byersolomon@mail.com",$endpoint);
    //         $id=json_decode($id[0],true)['id'];
    //         $card=merchantsController::createPaymentInstramentMinReq(config("app.api_username"),config("app.api_password"),
    //         $exp_month,$exp_year,$id,$name,$cardNumber,$cvv,"PAYMENT_CARD",$endpoint,[],["tags"=>["api"=>$api,"merchant"=>$merchant->id]]);
    //         $card=json_decode($card[0],true)['id'];
    //         $result=merchantsController::makePaymentMinReq(config("app.api_username"),config("app.api_password"),$api->merchant,$currency,$amount,$card, $endpoint,[],["tags"=>["api"=>$api,"merchant"=>$merchant->id]]);
    //         return $result[0];
    //     } else {
    //         // API key not found
    //         return response()->json(['error' => 'Invalid API key'], 401);
    //     }
    // }
    // function handlePaymentMethodsRequest($apiKey, $live, $paymentMethodId = null)
    // {
    //     // Check if API key exists in the database
    //     $api = ApiKey::where('api_key', $apiKey)->first();

    //     if ($api) {
    //         // Set endpoint based on the "live" parameter
    //         $endpoint = $live ? 'https://finix.live-payments-api.com' : 'https://finix.sandbox-payments-api.com';

    //         // Call the appropriate function based on the presence of $paymentId
    //         if ($paymentMethodId) {
    //             $result = merchantsController::fetchPayment(config("app.api_username"), config("app.api_password"), $paymentMethodId, $endpoint);
    //         } else {
    //             $result = merchantsController::listPaymentInstraments(config("app.api_username"), config("app.api_password"), config(), $endpoint, ['filter' => json_encode(['tags.api' => $apiKey])]);
    //         }

    //         return $result[0];
    //     } else {
    //         // API key not found
    //         return response()->json(['error' => 'Invalid API key'], 401);
    //     }
    // }
    // function handleRefundRequest($apiKey, $live, $paymentId, $refundAmount)
    // {
    //     // Check if API key exists in the database
    //     $api = ApiKey::where('api_key', $apiKey)->first();

    //     if ($api) {
    //         // Set endpoint based on the "live" parameter
    //         $endpoint = $live ? 'https://finix.live-payments-api.com' : 'https://finix.sandbox-payments-api.com';

    //         // Call the appropriate function based on the presence of $paymentId
    //         if ($paymentId) {
    //             $result = merchantsController::createRefund(config("app.api_username"), config("app.api_password"), $paymentId, $refundAmount ,$endpoint);
    //         }

    //         return $result[0];
    //     } else {
    //         // API key not found
    //         return response()->json(['error' => 'Invalid API key'], 401);
    //     }
    // }
    // function makePyament(){
    //     return $this->handleMakePaymentRequest(request('api_key'), request('live', false), request('email'),request('$exp_month'),request('$exp_year'),request('$name'),request('$cardNumber'),request('$cvv'),request('$amount'),request('currency'),);
    // }
    // function listPayments(){
    //     return $this->handlePaymentRequest(request('api_key'), request('live', false), null);
    // }
    // function fetchPayment(){
    //     return $this->handlePaymentRequest(request('api_key'), request('live', false), request('payment_id'));
    // }
    // function refundPayment(){
    //     return $this->handlePaymentRequest(request('api_key'), request('live', false), request('payment_id'),request('refund_amount'));
    // }public function identities(){
    //     $apiKey = request()->header('Authorization');
    //     $api = ApiKey::where('api_key', $apiKey)->first();
    //     if ($api) {
    //     $endpoint = $api->live ? 'https://finix.live-payments-api.com' : 'https://finix.sandbox-payments-api.com';
    //     return merchantsController::listIdentities(config("app.api_username"),config("app.api_password"), $endpoint,array_merge(request()->query(),['filter' => json_encode(['tags.api' => $apiKey])]))[0];
    //     }
    //     return response()->json(['error' => 'Invalid API key'], 401);
    // }
    // public function identity($id){
    //     $apiKey = request()->header('Authorization');
    //     $api = ApiKey::where('api_key', $apiKey)->first();
    //     if ($api) {
    //     $endpoint = $api->live ? 'https://finix.live-payments-api.com' : 'https://finix.sandbox-payments-api.com';
    //     return merchantsController::fetchIDIdentity(config("app.api_username"),config("app.api_password"),$id, $endpoint,request()->query())[0];
    //     }
    //     return response()->json(['error' => 'Invalid API key'], 401);
    // }
    // public function payments(){
    //     $apiKey = request()->header('Authorization');
    //     $api = ApiKey::where('api_key', $apiKey)->first();
    //     if ($api) {
    //     $endpoint = $api->live ? 'https://finix.live-payments-api.com' : 'https://finix.sandbox-payments-api.com';
    //     return merchantsController::listPayments(config("app.api_username"),config("app.api_password"),$endpoint,request()->query())[0];
    //     }
    //     return response()->json(['error' => 'Invalid API key'], 401);
    // }
    // public function payment($id){
    //     $apiKey = request()->header('Authorization');
    //     $api = ApiKey::where('api_key', $apiKey)->first();
    //     if ($api) {
    //     $endpoint = $api->live ? 'https://finix.live-payments-api.com' : 'https://finix.sandbox-payments-api.com';
    //     return merchantsController::fetchPayment(config("app.api_username"),config("app.api_password"),$id,$endpoint,request()->query())[0];
    //     }
    //     return response()->json(['error' => 'Invalid API key'], 401);
    // }
    // public function payment_instraments(){
    //     $apiKey = request()->header('Authorization');
    //     $api = ApiKey::where('api_key', $apiKey)->first();
    //     if ($api) {
    //     $endpoint = $api->live ? 'https://finix.live-payments-api.com' : 'https://finix.sandbox-payments-api.com';
    //     return merchantsController::listPaymentInstraments(config("app.api_username"),config("app.api_password"),$endpoint,request()->query())[0];
    //     }
    //     return response()->json(['error' => 'Invalid API key'], 401);
    // }
    // public function payment_instrament($id){
    //     $apiKey = request()->header('Authorization');
    //     $api = ApiKey::where('api_key', $apiKey)->first();
    //     if ($api) {
    //     $endpoint = $api->live ? 'https://finix.live-payments-api.com' : 'https://finix.sandbox-payments-api.com';
    //     return merchantsController::fetchPaymentInstrament(config("app.api_username"),config("app.api_password"),$id,$endpoint,request()->query())[0];
    //     }
    //     return response()->json(['error' => 'Invalid API key'], 401);
    // }
    // public function merchants(){
    //     $apiKey = request()->header('Authorization');
    //     $api = ApiKey::where('api_key', $apiKey)->first();
    //     if ($api) {
    //     $endpoint = $api->live ? 'https://finix.live-payments-api.com' : 'https://finix.sandbox-payments-api.com';
    //      return merchantsController::listMerchants(config("app.api_username"),config("app.api_password"),$endpoint,request()->query())[0];
    //     }
    //     return response()->json(['error' => 'Invalid API key'], 401);
    // }
    // public function merchant($id){
    //     $apiKey = request()->header('Authorization');
    //     $api = ApiKey::where('api_key', $apiKey)->first();
    //     if ($api) {
    //     $endpoint = $api->live ? 'https://finix.live-payments-api.com' : 'https://finix.sandbox-payments-api.com';
    //     return  merchantsController::fetchMerchant(config("app.api_username"),config("app.api_password"),$id,$endpoint,request()->query())[0];
    //     }
    //     return response()->json(['error' => 'Invalid API key'], 401);
    // }
    // public function fee_profile($id){
    //     $apiKey = request()->header('Authorization');
    //     $api = ApiKey::where('api_key', $apiKey)->first();
    //     if ($api) {
    //     $endpoint = $api->live ? 'https://finix.live-payments-api.com' : 'https://finix.sandbox-payments-api.com';
    //     return  merchantsController::fetchFeeProfile(config("app.api_username"),config("app.api_password"),$id,$endpoint,request()->query())[0];
    //     }
    //     return response()->json(['error' => 'Invalid API key'], 401);
    // }
    // public function fee_profiles(){
    //     $apiKey = request()->header('Authorization');
    //     $api = ApiKey::where('api_key', $apiKey)->first();
    //     if ($api) {
    //     $endpoint = $api->live ? 'https://finix.live-payments-api.com' : 'https://finix.sandbox-payments-api.com';
    //     return merchantsController::listFeeProfile(config("app.api_username"),config("app.api_password"),$endpoint,request()->query())[0];
    //     }
    //     return response()->json(['error' => 'Invalid API key'], 401);
    // }
public function retrieveInfo($apiKey){
    $apiKey=ApiKey::where('api_key', $apiKey)->first();
    $merchant=false;
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
        $merchant=$apiKey->merchant_id;
    }
    $userID=$api_userID->user_id;
    return ['worked'=>true,"apikey"=>$apiKey,'api_userID'=>$api_userID,'userID'=>$userID,"live"=>$live,'merchant'=>$merchant];
}
public function getBalance(){}
public function createCustomer(){
    $request=request()->all();
    $info=$this->retrieveInfo($request['apikey']);
    if(!$info['worked']){return response()->json(['error' => 'Invalid API key'], 401);}
    if($info['live']){
        $custumer=identities_live::makeBuyerIdentity($request['email'],$info['userID'],$info['api_userID'],$info['apikey']??0);
    }else{
        $custumer=identities::makeBuyerIdentity($request['email'],$info['userID'],$info['api_userID'],$info['apikey']??0);
    }
    if($custumer['worked']){
        return response()->json([$custumer['responce']], 200);
    }
    return response()->json([$custumer['responce']], 301);
}
public function updateCustomer($request){}
public function getCustomer(){
    $request=request()->all();
    $info=$this->retrieveInfo($request['apikey']);
    if(!$info['worked']){return response()->json(['error' => 'Invalid API key'], 401);}
    if($info['live']){
        $custumer=identities_live::authenticateGetCustomerByID($request['id'],$info['api_userID'],$info['apikey']);
    }else{
        $custumer=identities::authenticateGetCustomerByID($request['id'],$info['api_userID'],$info['apikey']);
    }
    if($custumer==null){
        return response()->json(['error'=>"failed to get customer"], 300);
    }
    return response()->json([$custumer], 201);
}
public function getCustomers(){
    $request=request()->all();
    $info=$this->retrieveInfo($request['apikey']);
    if(!$info['worked']){return response()->json(['error' => 'Invalid API key'], 401);}
    if($info['live']){
        $custumers=identities_live::authenticateGetCustomer($info['api_userID'],$info['apikey']);
    }else{
        $custumers=identities::authenticateGetCustomer($info['api_userID'],$info['apikey']);
    }
    if(empty($custumers)){
         return response()->json(['error'=>"failed to get customer"], 301);
    }
    return response()->json($custumers->toArray(), 201);
}
public function customers_search(){
    $request=request()->all();
    $info=$this->retrieveInfo($request['apikey']);
    if(!$info['worked']){return response()->json(['error' => 'Invalid API key'], 401);}
    if(!isset($request['search'])||empty($request['search'])){
        return response()->json(['error'=>"search not provided"], 301);
   }
   $search=$request['search'];
    if($info['live']){
        $charges=finix_payments_live::authenticateSearch($info['api_userID'],$info['apikey'], $search);
    }else{
        $charges=identities::authenticateSearchCustomer($info['api_userID'],$info['apikey'], $search);
    }
    if(empty($charges)){
         return response()->json(['error'=>"failed to get charges"], 301);
    }
    return response()->json($charges->toArray(), 201);
}
public function getCampaignCustomers(){}
public function getCampaignBalance(){}

public function createCharges(){
    $request=request()->all();
    $info=$this->retrieveInfo($request['apikey']);
    if(!$info['worked']){return response()->json(['error' => 'Invalid API key'], 401);}
    if($info['live']){
        $card=identities_live::authenticateGetCustomerByID($request['CardID'],$info['api_userID'],$info['apikey']);
    }else{
        $card=identities::authenticateGetCustomerByID($request['CardID'],$info['api_userID'],$info['apikey']);
    }
    if(empty($card)){
        return response()->json(['error'=>"failed to identify card"], 301);
   }
   if($info['merchant']!=false){
    $merchant=$info['merchant'];
   }elseif($info['live']){
        $merchant=Finix_Merchant_live::authenticateGetCustomerByID($request['MerchantID'],$info['api_userID'],$info['apikey']);
    }else{
        $merchant=Finix_Merchant::authenticateGetCustomerByID($request['MerchantID'],$info['api_userID'],$info['apikey']);
    }
    if(empty($merchant)){
        return response()->json(['error'=>"failed to identify merchant"], 301);
    }
    $amount=0;
    try {
       $amount=floatval($request['amount']);
       if($amount<=0){return response()->json(['error'=>"invalid amount"], 301);}
    } catch (\Throwable $th) {
            return response()->json(['error'=>"invalid amount"], 301);
    }
    if(!isset($request['currency'])||empty($request['currency'])){
        return response()->json(['error'=>"invalid currency"], 301);
    }
    $currency=strtoupper($request['currency']);
    if($info['live']){
        $payment=finix_payments_live::makePayment($merchant->finix_id,$currency,$amount,$card->finix_id,$request['userID'],$info['api_userID'],$info['apikey']??0);
    }else{
        $payment=finix_payments::makePayment($merchant->finix_id,$currency,$amount,$card->finix_id,$request['userID'],$info['api_userID'],$info['apikey']??0);
    }
    if($payment['worked']){
        return response()->json($payment['responce'], 200);
    }
    return response()->json($payment['responce'], 301);
}
public function updateCharge(){}
public function getCharge(){
    $request=request()->all();
    $info=$this->retrieveInfo($request['apikey']);
    if(!$info['worked']){return response()->json(['error' => 'Invalid API key'], 401);}
    if($info['live']){
        $payment=finix_payments_live::authenticateGetByID($request['id'],$info['api_userID'],$info['apikey']);
    }else{
        $payment=finix_payments::authenticateGetByID($request['id'],$info['api_userID'],$info['apikey']);
    }
    if($payment==null){
        return response()->json(['error'=>"failed to get charge"], 300);
    }
    return response()->json([$payment], 201);
}
public function getCharges(){
    $request=request()->all();
    $info=$this->retrieveInfo($request['apikey']);
    if(!$info['worked']){return response()->json(['error' => 'Invalid API key'], 401);}
    if($info['live']){
        $charges=finix_payments_live::authenticateGet($info['api_userID'],$info['apikey']);
    }else{
        $charges=finix_payments::authenticateGet($info['api_userID'],$info['apikey']);
    }
    if(empty($charges)){
         return response()->json(['error'=>"failed to get charges"], 301);
    }
    return response()->json($charges->toArray(), 201);
}
public function charges_search(){
    $request=request()->all();
    $info=$this->retrieveInfo($request['apikey']);
    if(!$info['worked']){return response()->json(['error' => 'Invalid API key'], 401);}
    if(!isset($request['search'])||empty($request['search'])){
        return response()->json(['error'=>"search not provided"], 301);
   }
   $search=$request['search'];
    if($info['live']){
        $charges=finix_payments_live::authenticateSearch($info['api_userID'],$info['apikey'], $search);
    }else{
        $charges=finix_payments::authenticateSearch($info['api_userID'],$info['apikey'], $search);
    }
    if(empty($charges)){
         return response()->json(['error'=>"failed to get charges"], 301);
    }
    return response()->json($charges->toArray(), 201);
}


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

public function createRefund(){
    $request=request()->all();
    $info=$this->retrieveInfo($request['apikey']);
    if(!$info['worked']){return response()->json(['error' => 'Invalid API key'], 401);}
    if($info['live']){
        $payment=finix_payments::authenticateGetByID($request['id'],$info['api_userID'],$info['apikey']);
    }else{
        $payment=finix_payments::authenticateGetByID($request['id'],$info['api_userID'],$info['apikey']);
    }
    if($payment!=null){
        return response()->json(['error'=>"failed to get charge"], 300);
    }
    $amount=0;
    try {
       $amount=floatval($request['amount']);
       if($amount<=0){return response()->json(['error'=>"invalid amount"], 301);}
    } catch (\Throwable $th) {
            return response()->json(['error'=>"invalid amount"], 301);
    }
    if($info['live']){
        $refund=finix_payments::makeRefund($payment->finix_id,$amount,$info['api_userID'],$info['apikey']);
    }else{
        $refund=finix_payments::makeRefund($payment->finix_id,$amount,$info['api_userID'],$info['apikey']);
    }
    return response()->json([$refund], 201);
}
public function updateRefund(){}
public function getRefund(){}
public function getRefunds(){}

public function createBalenceTransfer(){}
public function updateBalenceTransfer(){}
public function getBalenceTransfer(){}
public function createBalenceTransfers(){}
public function balence_transfers_search(){}


public function postTokenize(){}

public function createPaymentWay(){
    $request=request()->all();

    // Validation rules
    $rules = [
        'exp_month' => 'required|numeric|digits_between:1,2',
        'exp_year' => 'required|numeric|digits:4',
        'name' => 'required|string',
        'card_number' => 'required|numeric|digits:16',
        'cvv' => 'required|numeric|digits_between:3,4',
    ];

    // Validate the input data
    $validator = Validator::make($request, $rules);

    if ($validator->fails()) {
        // If validation fails, return error response
        return response()->json(['errors' => $validator->errors()], 400);
    }

    // If validation passes, assign the data to variables
    $exp_month = $request['exp_month'];
    $exp_year = $request['exp_year'];
    $name = $request['name'];
    $card_number = $request['card_number'];
    $cvv = $request['cvv'];
    $info=$this->retrieveInfo($request['apikey']);
    if(!$info['worked']){return response()->json(['error' => 'Invalid API key'], 401);}
    if($info['live']){
        $custumer=identities_live::authenticateGetCustomerByID($request['id'],$info['api_userID'],$info['apikey']);
    }else{
        $custumer=identities::authenticateGetCustomerByID($request['id'],$info['api_userID'],$info['apikey']);
    }
    if($custumer==null){
        return response()->json(['error'=>"failed to get customer"], 300);
    }
    if($info['live']){
        $card=payment_ways_live::makeCard($exp_month,
$exp_year,
$custumer->finix_id,
$name,
$card_number,
$cvv,$info['api_userID'],$info['apikey']);
    }else{
        $card=payment_ways::makeCard($exp_month,
$exp_year,
$custumer->finix_id,
$name,
$card_number,
$cvv,$info['api_userID'],$info['apikey']);
    }
    if($card==null){
        return response()->json(['error'=>"failed to create card"], 300);
    }
    return response()->json([$card], 201);
}
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


public function createHold(){
    $request=request()->all();
    $info=$this->retrieveInfo($request['apikey']);
    if(!$info['worked']){return response()->json(['error' => 'Invalid API key'], 401);}
    if($info['live']){
        $card=identities_live::authenticateGetCustomerByID($request['CardID'],$info['api_userID'],$info['apikey']);
    }else{
        $card=identities::authenticateGetCustomerByID($request['CardID'],$info['api_userID'],$info['apikey']);
    }
    if(empty($card)){
        return response()->json(['error'=>"failed to identify card"], 301);
   }
   if($info['merchant']!=false){
    $merchant=$info['merchant'];
   }elseif($info['live']){
        $merchant=Finix_Merchant_live::authenticateGetCustomerByID($request['MerchantID'],$info['api_userID'],$info['apikey']);
    }else{
        $merchant=Finix_Merchant::authenticateGetCustomerByID($request['MerchantID'],$info['api_userID'],$info['apikey']);
    }
    if(empty($merchant)){
        return response()->json(['error'=>"failed to identify merchant"], 301);
    }
    $amount=0;
    try {
       $amount=floatval($request['amount']);
       if($amount<=0){return response()->json(['error'=>"invalid amount"], 301);}
    } catch (\Throwable $th) {
            return response()->json(['error'=>"invalid amount"], 301);
    }
    if(!isset($request['currency'])||empty($request['currency'])){
        return response()->json(['error'=>"invalid currency"], 301);
    }
    $currency=strtoupper($request['currency']);
    if($info['live']){
        $payment=Authorization_live::makeHold($merchant->finix_id,$currency,$amount,$card->finix_id,$request['userID'],$info['api_userID'],$info['apikey']??0);
    }else{
        $payment=Authorization::makeHold($merchant->finix_id,$currency,$amount,$card->finix_id,$request['userID'],$info['api_userID'],$info['apikey']??0);
    }
    if($payment['worked']){
        return response()->json($payment['responce'], 200);
    }
    return response()->json($payment['responce'], 301);
}
public function updateHold(){}
public function getHold(){
    $request=request()->all();
    $info=$this->retrieveInfo($request['apikey']);
    if(!$info['worked']){return response()->json(['error' => 'Invalid API key'], 401);}
    if($info['live']){
        $hold=Authorization_live::authenticateGetByID($request['id'],$info['api_userID'],$info['apikey']);
    }else{
        $hold=Authorization::authenticateGetByID($request['id'],$info['api_userID'],$info['apikey']);
    }
    if($hold==null){
        return response()->json(['error'=>"failed to get charge"], 300);
    }
    return response()->json([$hold], 201);
}
public function getHolds(){
    $request=request()->all();
    $info=$this->retrieveInfo($request['apikey']);
    if(!$info['worked']){return response()->json(['error' => 'Invalid API key'], 401);}
    if($info['live']){
        $charges=identities_live::authenticateGet($info['api_userID'],$info['apikey']);
    }else{
        $charges=identities::authenticateGet($info['api_userID'],$info['apikey']);
    }
    if(empty($charges)){
         return response()->json(['error'=>"failed to get charges"], 301);
    }
    return response()->json($charges->toArray(), 201);
}
public function hold_search(){}

public function createSubscription(){}
public function updateSubscription(){}
public function getSubscription(){}
public function getSubscriptions(){}
public function subscriptions_search(){}
}
