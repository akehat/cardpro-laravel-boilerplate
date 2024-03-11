<?php

namespace App\Http\Controllers\API;

use App\Domains\Auth\Models\User;
use App\Http\Controllers\API\merchantsController;
use App\Models\ApiKey;
use App\Models\ApiUser;
use App\Models\Authorization;
use App\Models\Authorization_live;
use App\Models\Dispute_Evidence;
use App\Models\Dispute_Evidence_Live;
use App\Models\Finix_Disputes;
use App\Models\Finix_Disputes_live;
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
            $userID=$user->id;
        }else{
            return ['worked'=>false,"responce"=>"Invalid API key"];
        }
    }else{
        $api_userID=$apiKey->api_user;
        $userID=$apiKey->userID??0;
        $live=$apiKey->live;
        $merchant=$apiKey->merchant_id;
        $apiKey=$apiKey->id;
    }
    return ['worked'=>true,"apikey"=>$apiKey,'api_userID'=>$api_userID,'userID'=>$userID,"live"=>$live,'merchant'=>$merchant];
}
public function getBalance(){

}
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
        return response()->json($custumer['ref'], 201 , [] , JSON_PRETTY_PRINT);
    }
    return response()->json([$custumer['responce']], 301);
}
public function updateCustomer($id){
    $request=request()->all();
    $info=$this->retrieveInfo($request['apikey']);
    if(!$info['worked']){return response()->json(['error' => 'Invalid API key'], 401);}
    if($info['live']){
        $custumerRef=identities_live::authenticateGetCustomerByID($id,$info['api_userID'],$info['apikey']);
    }else{
        $custumerRef=identities::authenticateGetCustomerByID($id,$info['api_userID'],$info['apikey']);
    }
    if($custumerRef==null){return response()->json(['error' => 'Invalid customer id'], 401);}
    if($info['live']){
        $custumer=identities_live::updateBuyerIdentity($custumerRef->finix_id,$request['email'],$info['userID'],$info['api_userID'],$info['apikey']??0);
    }else{
        $custumer=identities::updateBuyerIdentity($custumerRef->finix_id,$request['email'],$info['userID'],$info['api_userID'],$info['apikey']??0);
    }
    if($custumer['worked']){
        return response()->json($custumer['ref'], 201 , [] , JSON_PRETTY_PRINT);
    }
    return response()->json([$custumer['responce']], 301);
}
public function getCustomer($id){
    $info=$this->retrieveInfo(request()->header('apikey'));
    if(!$info['worked']){return response()->json(['error' => 'Invalid API key'], 401);}
    if($info['live']){
        $custumer=identities_live::authenticateGetCustomerByID($id,$info['api_userID'],$info['apikey']);
    }else{
        $custumer=identities::authenticateGetCustomerByID($id,$info['api_userID'],$info['apikey']);
    }
    if($custumer==null){
        return response()->json(['error'=>"failed to get customer"], 300);
    }
    return response()->json($custumer ,  201 , [] , JSON_PRETTY_PRINT);
}
public function getCustomers(){
    $info=$this->retrieveInfo(request()->header('apikey'));
    if(!$info['worked']){return response()->json(['error' => 'Invalid API key'], 401);}
    if($info['live']){
        $custumers=identities_live::authenticateGetCustomer($info['api_userID'],$info['apikey']);
    }else{
        $custumers=identities::authenticateGetCustomer($info['api_userID'],$info['apikey']);
    }
    if(empty($custumers)){
         return response()->json(['error'=>"failed to get customer"], 301);
    }
    return response()->json($custumers->toArray(), 201 , [] , JSON_PRETTY_PRINT);
}
public function customers_search(){
    $request=request()->all();
    $info=$this->retrieveInfo(request()->header('apikey'));
    if(!$info['worked']){return response()->json(['error' => 'Invalid API key'], 401);}
    if(!isset($request['search'])||empty($request['search'])){
        return response()->json(['error'=>"search not provided"], 301);
   }
   $search=$request['search'];
    if($info['live']){
        $charges=identities_live::authenticateSearchCustomer($info['api_userID'],$info['apikey'], $search);
    }else{
        $charges=identities::authenticateSearchCustomer($info['api_userID'],$info['apikey'], $search);
    }
    if(empty($charges)){
         return response()->json(['error'=>"failed to get charges"], 301);
    }
    return response()->json($charges->toArray(), 201 , [] , JSON_PRETTY_PRINT);
}
public function getCampaignCustomers(){}
public function getCampaignBalance(){}

public function createCharges(){
    $request=request()->all();
    // var_dump($request);
    // return 0;
    $info=$this->retrieveInfo($request['apikey']);
    if(!$info['worked']){return response()->json(['error' => 'Invalid API key'], 401);}
    if($info['live']){
        $card=payment_ways_live::authenticateGetID($request['cardID'],$info['api_userID'],$info['apikey']);
    }else{
        $card=payment_ways::authenticateGetID($request['cardID'],$info['api_userID'],$info['apikey']);
    }
    if(empty($card)){
        return response()->json(['error'=>"failed to identify card"], 301);
   }
   if($info['merchant']!=false){
    $request['MerchantID']=$info['merchant'];
   }
   if($info['live']){
        $merchant=Finix_Merchant_live::authenticateGetIDWithUserID($request['MerchantID'],$info['api_userID'],$info['apikey']);
        $merchant=$merchant->finix_id??0;
    }else{
        $merchant=Finix_Merchant::authenticateGetIDWithUserID($request['MerchantID'],$info['api_userID'],$info['apikey']);
        $merchant=$merchant->finix_id??0;
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
        $payment=finix_payments_live::makePayment($merchant,$currency,$amount,$card->finix_id,$info['userID'],$info['api_userID'],$info['apikey']??0);
    }else{
        $payment=finix_payments::makePayment($merchant,$currency,$amount,$card->finix_id,$info['userID'],$info['api_userID'],$info['apikey']??0);
    }
    if($payment['worked']){
        return response()->json($payment['ref'], 201, [] , JSON_PRETTY_PRINT);
    }
    return response()->json($payment, 301 , [] , JSON_PRETTY_PRINT);
}
public function updateCharge(){}
public function getCharge($id){
    $info=$this->retrieveInfo(request()->header('apikey'));
    if(!$info['worked']){return response()->json(['error' => 'Invalid API key'], 401);}
    if($info['live']){
        $payment=finix_payments_live::authenticateGetID($id,$info['api_userID'],$info['apikey']);
    }else{
        $payment=finix_payments::authenticateGetID($id,$info['api_userID'],$info['apikey']);
    }
    if($payment==null){
        return response()->json(['error'=>"failed to get charge"], 300);
    }
    return response()->json($payment ,  201 , [] , JSON_PRETTY_PRINT);
}
public function getCharges(){
    $info=$this->retrieveInfo(request()->header('apikey'));
    if(!$info['worked']){return response()->json(['error' => 'Invalid API key'], 401);}
    if($info['live']){
        $charges=finix_payments_live::authenticateGet($info['api_userID'],$info['apikey']);
    }else{
        $charges=finix_payments::authenticateGet($info['api_userID'],$info['apikey']);
    }
    if(empty($charges)){
         return response()->json(['error'=>"failed to get charges"], 301);
    }
    return response()->json($charges->toArray(), 201 , [] , JSON_PRETTY_PRINT);
}
public function charges_search(){
    $request=request()->all();
    $info=$this->retrieveInfo(request()->header('apikey'));
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
    return response()->json($charges->toArray(), 201 , [] , JSON_PRETTY_PRINT);
}


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
        $payment=finix_payments_live::authenticateGetID($request['id'],$info['api_userID'],$info['apikey']);
    }else{
        $payment=finix_payments::authenticateGetID($request['id'],$info['api_userID'],$info['apikey']);
    }
    if(empty($payment)){
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
        $refund=finix_payments_live::makeRefund($payment->finix_id,$amount,$info['api_userID'],$info['apikey']);
    }else{
        $refund=finix_payments::makeRefund($payment->finix_id,$amount,$info['api_userID'],$info['apikey']);
    }
    return response()->json($refund['ref'] ,  201 , [] , JSON_PRETTY_PRINT);
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
$cvv,$info['userID'],$info['api_userID'],$info['apikey']);
    }
    if($card==null){
        return response()->json(['error'=>"failed to create card"], 300);
    }
    return response()->json($card['ref'] ,  201 , [] , JSON_PRETTY_PRINT);
}
public function updatePaymentWay(){}
public function getCustomerPaymentWay(){}
public function getCustomerPaymentWays(){}
public function getPaymentWays(){
    $info=$this->retrieveInfo(request()->header('apikey'));
    if(!$info['worked']){return response()->json(['error' => 'Invalid API key'], 401);}
    if($info['live']){
        $paymentWay=payment_ways_live::authenticateGet($info['api_userID'],$info['apikey']);
    }else{
        $paymentWay=payment_ways::authenticateGet($info['api_userID'],$info['apikey']);
    }
    if(empty($paymentWay)){
         return response()->json(['error'=>"failed to get payment way"], 301);
    }
    return response()->json($paymentWay->toArray(), 201 , [] , JSON_PRETTY_PRINT );
}
public function getPaymentWay($id){
    $info=$this->retrieveInfo(request()->header('apikey'));
    if(!$info['worked']){return response()->json(['error' => 'Invalid API key'], 401);}
    if($info['live']){
        $paymentWay=payment_ways_live::authenticateGetID($id,$info['api_userID'],$info['apikey']);
    }else{
        $paymentWay=payment_ways::authenticateGetID($id,$info['api_userID'],$info['apikey']);
    }
    if($paymentWay==null){
        return response()->json(['error'=>"failed to get payment way"], 300);
    }
    return response()->json($paymentWay ,  201 , [] , JSON_PRETTY_PRINT);
}
public function payment_ways_search(){
    $request=request()->all();
    $info=$this->retrieveInfo(request()->header('apikey'));
    if(!$info['worked']){return response()->json(['error' => 'Invalid API key'], 401);}
    if(!isset($request['search'])||empty($request['search'])){
        return response()->json(['error'=>"search not provided"], 301);
   }
   $search=$request['search'];
    if($info['live']){
        $charges=payment_ways_live::authenticateSearch($info['api_userID'],$info['apikey'], $search);
    }else{
        $charges=payment_ways::authenticateSearch($info['api_userID'],$info['apikey'], $search);
    }
    if(empty($charges)){
         return response()->json(['error'=>"failed to get payment way"], 301);
    }
    return response()->json($charges->toArray(), 201 , [] , JSON_PRETTY_PRINT );
}


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
        $card=payment_ways_live::authenticateGetID($request['cardID'],$info['api_userID'],$info['apikey']);
    }else{
        $card=payment_ways::authenticateGetID($request['cardID'],$info['api_userID'],$info['apikey']);
    }
    if(empty($card)){
        return response()->json(['error'=>"failed to identify card"], 301);
   }
   if($info['merchant']!=false){
    $request['MerchantID']=$info['merchant'];
   }
   if($info['live']){
        $merchant=Finix_Merchant_live::authenticateGetIDWithUserID($request['MerchantID'],$info['api_userID'],$info['apikey']);
    }else{
        $merchant=Finix_Merchant::authenticateGetIDWithUserID($request['MerchantID'],$info['api_userID'],$info['apikey']);
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
        $payment=Authorization_live::makeHold($merchant->finix_id,$currency,$amount,$card->finix_id,$info['userID'],$info['api_userID'],$info['apikey']??0);
    }else{
        $payment=Authorization::makeHold($merchant->finix_id,$currency,$amount,$card->finix_id,$info['userID'],$info['api_userID'],$info['apikey']??0);
    }
    if($payment['worked']){
        return response()->json($payment['ref'], 201 , [] , JSON_PRETTY_PRINT );
    }
    return response()->json($payment['responce'], 301);
}
public function captureHold($id){
    $request=request()->all();
    $info=$this->retrieveInfo($request['apikey']);
    if(!$info['worked']){return response()->json(['error' => 'Invalid API key'], 401);}
    if($info['live']){
        $hold=Authorization_live::authenticateGetID($id,$info['api_userID'],$info['apikey']);
    }else{
        $hold=Authorization::authenticateGetID($id,$info['api_userID'],$info['apikey']);
    }
    if(empty($hold)){
        return response()->json(['error'=>"failed to get hold"], 300);
    }
    $amount=0;
    try {
       $amount=floatval($request['amount']);
       if($amount<=0){return response()->json(['error'=>"invalid amount"], 301);}
    } catch (\Throwable $th) {
            return response()->json(['error'=>"invalid amount"], 301);
    }
    if($info['live']){
        $capture=Authorization_live::makeCapture($hold->finix_id,$amount,$info['api_userID'],$info['apikey']);
    }else{
        $capture=Authorization::makeCapture($hold->finix_id,$amount,$info['api_userID'],$info['apikey']);
    }
    if($capture['worked']){
        return response()->json($capture['ref'], 201 , [] , JSON_PRETTY_PRINT );
    }
    return response()->json($capture['responce'], 301);
}
public function releaseHold($id){
    $request=request()->all();
    $info=$this->retrieveInfo($request['apikey']);
    if(!$info['worked']){return response()->json(['error' => 'Invalid API key'], 401);}
    if($info['live']){
        $hold=Authorization_live::authenticateGetID($id,$info['api_userID'],$info['apikey']);
    }else{
        $hold=Authorization::authenticateGetID($id,$info['api_userID'],$info['apikey']);
    }
    if(empty($hold)){
        return response()->json(['error'=>"failed to get hold"], 300);
    }
    if($info['live']){
        $refund=Authorization_live::voidCapture($hold->finix_id,$info['api_userID'],$info['apikey']);
    }else{
        $refund=Authorization::voidCapture($hold->finix_id,$info['api_userID'],$info['apikey']);
    }
    if($refund['worked']){
        return response()->json($refund['ref'], 201 , [] , JSON_PRETTY_PRINT );
    }
    return response()->json($refund['responce'], 301);
}
public function getHold($id){
    $info=$this->retrieveInfo(request()->header('apikey'));
    if(!$info['worked']){return response()->json(['error' => 'Invalid API key'], 401);}
    if($info['live']){
        $hold=Authorization_live::authenticateGetID($id,$info['api_userID'],$info['apikey']);
    }else{
        $hold=Authorization::authenticateGetID($id,$info['api_userID'],$info['apikey']);
    }
    if($hold==null){
        return response()->json(['error'=>"failed to get charge"], 300);
    }
    return response()->json($hold ,  201 , [] , JSON_PRETTY_PRINT);
}
public function getHolds(){
    $info=$this->retrieveInfo(request()->header('apikey'));
    if(!$info['worked']){return response()->json(['error' => 'Invalid API key'], 401);}
    if($info['live']){
        $holds=Authorization_live::authenticateGet($info['api_userID'],$info['apikey']);
    }else{
        $holds=Authorization::authenticateGet($info['api_userID'],$info['apikey']);
    }
    if(empty($holds)){
         return response()->json(['error'=>"failed to get holds"], 301);
    }
    return response()->json($holds->toArray(), 201 , [] , JSON_PRETTY_PRINT );
}
public function hold_search(){
    $request=request()->all();
    $info=$this->retrieveInfo(request()->header('apikey'));
    if(!$info['worked']){return response()->json(['error' => 'Invalid API key'], 401);}
    if(!isset($request['search'])||empty($request['search'])){
        return response()->json(['error'=>"search not provided"], 301);
   }
   $search=$request['search'];
    if($info['live']){
        $hold=Authorization_live::authenticateSearch($info['api_userID'],$info['apikey'], $search);
    }else{
        $hold=Authorization::authenticateSearch($info['api_userID'],$info['apikey'], $search);
    }
    if(empty($hold)){
         return response()->json(['error'=>"failed to get hold"], 301);
    }
    return response()->json($hold->toArray(), 201 , [] , JSON_PRETTY_PRINT );
}


public function getDispute($id){
    $info=$this->retrieveInfo(request()->header('apikey'));
    if(!$info['worked']){return response()->json(['error' => 'Invalid API key'], 401);}
    if($info['live']){
        $dispute=Finix_Disputes_live::authenticateGetID($id,$info['api_userID'],$info['apikey']);
    }else{
        $dispute=Finix_Disputes::authenticateGetID($id,$info['api_userID'],$info['apikey']);
    }
    if($dispute==null){
        return response()->json(['error'=>"failed to get dispute"], 300);
    }
    return response()->json($dispute ,  201 , [] , JSON_PRETTY_PRINT);
}
public function getDisputes(){
    $info=$this->retrieveInfo(request()->header('apikey'));
    if(!$info['worked']){return response()->json(['error' => 'Invalid API key'], 401);}
    if($info['live']){
        $disputes=Finix_Disputes_live::authenticateGet($info['api_userID'],$info['apikey']);
    }else{
        $disputes=Finix_Disputes::authenticateGet($info['api_userID'],$info['apikey']);
    }
    if(empty($disputes)){
         return response()->json(['error'=>"failed to get disputes"], 301);
    }
    return response()->json($disputes->toArray(), 201 , [] , JSON_PRETTY_PRINT );
}
public function dispute_search(){
    $request=request()->all();
    $info=$this->retrieveInfo(request()->header('apikey'));
    if(!$info['worked']){return response()->json(['error' => 'Invalid API key'], 401);}
    if(!isset($request['search'])||empty($request['search'])){
        return response()->json(['error'=>"search not provided"], 301);
   }
   $search=$request['search'];
    if($info['live']){
        $disputes=Finix_Disputes_live::authenticateSearch($info['api_userID'],$info['apikey'], $search);
    }else{
        $disputes=Finix_Disputes::authenticateSearch($info['api_userID'],$info['apikey'], $search);
    }
    if(empty($disputes)){
         return response()->json(['error'=>"failed to get dispute"], 301);
    }
    return response()->json($disputes->toArray(), 201 , [] , JSON_PRETTY_PRINT );
}

public function acceptDispute($id){
    $request=request()->all();
    $info=$this->retrieveInfo($request['apikey']);
    if(!$info['worked']){return response()->json(['error' => 'Invalid API key'], 401);}
    if($info['live']){
        $dipute=Finix_Disputes_live::authenticateGetID($id,$info['api_userID'],$info['apikey']);
    }else{
        $dipute=Finix_Disputes::authenticateGetID($id,$info['api_userID'],$info['apikey']);
    }
    if(empty($dipute)){
        return response()->json(['error'=>"failed to get Dispute"], 300);
    }
       $note=$request['note'];
       if(empty($note)){return response()->json(['error'=>"invalid note"], 301);}

    if($info['live']){
        $refund=Finix_Disputes_live::acceptDispute($dipute->finix_id,$note,$info['api_userID'],$info['apikey']);
    }else{
        $refund=Finix_Disputes::acceptDispute($dipute->finix_id,$note,$info['api_userID'],$info['apikey']);
    }
    if($refund['worked']){
        return response()->json($refund['ref'], 201 , [] , JSON_PRETTY_PRINT );
    }
    return response()->json($refund['responce'], 301);
}
public function updateDispute($id){
    $request=request()->all();
    $info=$this->retrieveInfo($request['apikey']);
    if(!$info['worked']){return response()->json(['error' => 'Invalid API key'], 401);}
    if($info['live']){
        $dipute=Finix_Disputes_live::authenticateGetID($id,$info['api_userID'],$info['apikey']);
    }else{
        $dipute=Finix_Disputes::authenticateGetID($id,$info['api_userID'],$info['apikey']);
    }
    if(empty($dipute)){
        return response()->json(['error'=>"failed to get Dispute"], 300);
    }

    $note=$request['note'];
    if(empty($note)){
        $file = request()->file('evidence');

        if ($file) {
            $filePath = $file->getPathname();
            // Pass $filePath to your function
            if($info['live']){
                $evidence=Dispute_Evidence_Live::uploadFileAsEvidence($dipute->finix_id,$filePath,$info['api_userID'],$info['apikey']);
            }else{
                $evidence=Dispute_Evidence::uploadFileAsEvidence($dipute->finix_id,$filePath,$info['api_userID'],$info['apikey']);
            }
            if($evidence['worked']){
                return response()->json($evidence['ref'], 201 , [] , JSON_PRETTY_PRINT );
            }
            return response()->json($evidence['responce'], 301);
        } else {
            return response()->json(['error' => "no file to say no evidence or note"], 301);
        }

    }

    if($info['live']){
        $evidence=Finix_Disputes_live::uploadNoteEvidence($dipute->finix_id,$note,$info['api_userID'],$info['apikey']);
    }else{
        $evidence=Finix_Disputes::uploadNoteEvidence($dipute->finix_id,$note,$info['api_userID'],$info['apikey']);
    }
    if($evidence['worked']){
        return response()->json($evidence['ref'], 201 , [] , JSON_PRETTY_PRINT );
    }
    return response()->json($evidence['responce'], 301);
}


public function getMerchant($id){
    $info=$this->retrieveInfo(request()->header('apikey'));
    if(!$info['worked']){return response()->json(['error' => 'Invalid API key'], 401);}
    if($info['live']){
        $merchant=Finix_Merchant_live::authenticateGetID($id,$info['api_userID'],$info['apikey']);
    }else{
        $merchant=Finix_Merchant::authenticateGetID($id,$info['api_userID'],$info['apikey']);
    }
    if($merchant==null){
        return response()->json(['error'=>"failed to get merhcant"], 300);
    }
    return response()->json($merchant ,  201 , [] , JSON_PRETTY_PRINT);
}
public function getMerchants(){
    $info=$this->retrieveInfo(request()->header('apikey'));
    if(!$info['worked']){return response()->json(['error' => 'Invalid API key'], 401);}
    if($info['live']){
        $merchants=Finix_Merchant_live::authenticateGet($info['api_userID'],$info['apikey']);
    }else{
        $merchants=Finix_Merchant::authenticateGet($info['api_userID'],$info['apikey']);
    }
    if(empty($merchants)){
         return response()->json(['error'=>"failed to get merchants"], 301);
    }
    return response()->json($merchants->toArray(), 201 , [] , JSON_PRETTY_PRINT );
}
public function merchants_search(){
    $request=request()->all();
    $info=$this->retrieveInfo(request()->header('apikey'));
    if(!$info['worked']){return response()->json(['error' => 'Invalid API key'], 401);}
    if(!isset($request['search'])||empty($request['search'])){
        return response()->json(['error'=>"search not provided"], 301);
   }
   $search=$request['search'];
    if($info['live']){
        $merchants=Finix_Merchant_live::authenticateSearch($info['api_userID'],$info['apikey'], $search);
    }else{
        $merchants=Finix_Merchant::authenticateSearch($info['api_userID'],$info['apikey'], $search);
    }
    if(empty($merchants)){
         return response()->json(['error'=>"failed to get merchants"], 301);
    }
    return response()->json($merchants->toArray(), 201 , [] , JSON_PRETTY_PRINT );
}


public function createMerchantIdentity(){
    $request=request()->all();

    // Validation rules
    $validator = Validator::make($request->all(), [
        'entity_annual_card_volume' => 'required|integer|min:0',
        'entity_business_address_city' => 'required|string|max:255',
        'entity_business_address_country' => 'required|string|max:255',
        'entity_business_address_region' => 'required|string|max:255',
        'entity_business_address_line2' => 'nullable|string|max:255',
        'entity_business_address_line1' => 'required|string|max:255',
        'entity_business_address_postal_code' => 'required|string|max:20',
        'entity_business_name' => 'required|string|max:255',
        'entity_business_phone' => 'required|string|max:255',
        'entity_business_tax_id' => 'required|string|max:255',
        'entity_business_type' => 'required|string|max:255',
        'entity_default_statement_descriptor' => 'required|string|max:255',
        'entity_dob_year' => 'required|integer|min:1900|max:' . date('Y'),
        'entity_dob_day' => 'required|integer|min:1|max:31',
        'entity_dob_month' => 'required|integer|min:1|max:12',
        'entity_doing_business_as' => 'required|string|max:255',
        'entity_email' => 'required|email|max:255',
        'entity_first_name' => 'required|string|max:255',
        'entity_has_accepted_credit_cards_previously' => 'nullable|boolean',
        'entity_incorporation_date_year' => 'required|integer|min:1900|max:' . date('Y'),
        'entity_incorporation_date_day' => 'required|integer|min:1|max:31',
        'entity_incorporation_date_month' => 'required|integer|min:1|max:12',
        'entity_last_name' => 'required|string|max:255',
        'entity_max_transaction_amount' => 'required|numeric|min:0',
        'entity_ach_max_transaction_amount' => 'required|numeric|min:0',
        'entity_mcc' => 'required|string|max:255',
        'entity_ownership_type' => 'required|string|max:255',
        'entity_personal_address_city' => 'required|string|max:255',
        'entity_personal_address_country' => 'required|string|max:255',
        'entity_personal_address_region' => 'required|string|max:255',
        'entity_personal_address_line2' => 'nullable|string|max:255',
        'entity_personal_address_line1' => 'required|string|max:255',
        'entity_personal_address_postal_code' => 'required|string|max:20',
        'entity_phone' => 'required|string|max:255',
        'entity_principal_percentage_ownership' => 'required|integer|min:0|max:100',
        'entity_tax_id' => 'required|string|max:255',
        'entity_title' => 'required|string|max:255',
        'entity_url' => 'required|url|max:255',
    ]);

    // Validate the input data
    $validator = Validator::make($request, $rules);

    if ($validator->fails()) {
        // If validation fails, return error response
        return response()->json(['errors' => $validator->errors()], 400);
    }

    $info=$this->retrieveInfo($request['apikey']);
    if(!$info['worked']){return response()->json(['error' => 'Invalid API key'], 401);}
    $request=(object)$request;
    if($info['live']){
        $merchantIdentity=identities::makeMerchantIdentity( $request->entity_annual_card_volume,
        $request->entity_business_address_city,
        $request->entity_business_address_country,
        $request->entity_business_address_region,
        $request->entity_business_address_line2,
        $request->entity_business_address_line1,
        $request->entity_business_address_postal_code,
        $request->entity_business_name,
        $request->entity_business_phone,
        $request->entity_business_tax_id,
        $request->entity_business_type,
        $request->entity_default_statement_descriptor,
        $request->entity_dob_year,
        $request->entity_dob_day,
        $request->entity_dob_month,
        $request->entity_doing_business_as,
        $request->entity_email,
        $request->entity_first_name,
        $request->entity_has_accepted_credit_cards_previously??'false',
        $request->entity_incorporation_date_year,
        $request->entity_incorporation_date_day,
        $request->entity_incorporation_date_month,
        $request->entity_last_name,
        $request->entity_max_transaction_amount,
        $request->entity_ach_max_transaction_amount,
        $request->entity_mcc,
        $request->entity_ownership_type,
        $request->entity_personal_address_city,
        $request->entity_personal_address_country,
        $request->entity_personal_address_region,
        $request->entity_personal_address_line2,
        $request->entity_personal_address_line1,
        $request->entity_personal_address_postal_code,
        $request->entity_phone,
        $request->entity_principal_percentage_ownership,
        $request->entity_tax_id,
        $request->entity_title,
        $request->entity_url,$info['api_userID'],$info['apikey']);
    }else{
        $merchantIdentity=identities::makeMerchantIdentity( $request->entity_annual_card_volume,
        $request->entity_business_address_city,
        $request->entity_business_address_country,
        $request->entity_business_address_region,
        $request->entity_business_address_line2,
        $request->entity_business_address_line1,
        $request->entity_business_address_postal_code,
        $request->entity_business_name,
        $request->entity_business_phone,
        $request->entity_business_tax_id,
        $request->entity_business_type,
        $request->entity_default_statement_descriptor,
        $request->entity_dob_year,
        $request->entity_dob_day,
        $request->entity_dob_month,
        $request->entity_doing_business_as,
        $request->entity_email,
        $request->entity_first_name,
        $request->entity_has_accepted_credit_cards_previously??'false',
        $request->entity_incorporation_date_year,
        $request->entity_incorporation_date_day,
        $request->entity_incorporation_date_month,
        $request->entity_last_name,
        $request->entity_max_transaction_amount,
        $request->entity_ach_max_transaction_amount,
        $request->entity_mcc,
        $request->entity_ownership_type,
        $request->entity_personal_address_city,
        $request->entity_personal_address_country,
        $request->entity_personal_address_region,
        $request->entity_personal_address_line2,
        $request->entity_personal_address_line1,
        $request->entity_personal_address_postal_code,
        $request->entity_phone,
        $request->entity_principal_percentage_ownership,
        $request->entity_tax_id,
        $request->entity_title,
        $request->entity_url,$info['api_userID'],$info['apikey']);
    }
    if($merchantIdentity['worked']){
        return response()->json($merchantIdentity['ref'], 201 , [] , JSON_PRETTY_PRINT );
    }
    return response()->json($merchantIdentity['responce'], 301);
}


public function getMerchantIdentity($id){
    $info=$this->retrieveInfo(request()->header('apikey'));
    if(!$info['worked']){return response()->json(['error' => 'Invalid API key'], 401);}
    if($info['live']){
        $merchant=identities_live::authenticateGetMerchantByID($id,$info['api_userID'],$info['apikey']);
    }else{
        $merchant=identities::authenticateGetMerchantByID($id,$info['api_userID'],$info['apikey']);
    }
    if($merchant==null){
        return response()->json(['error'=>"failed to get merhcant"], 300);
    }
    return response()->json($merchant ,  201 , [] , JSON_PRETTY_PRINT);
}
public function getMerchantIdentities(){
    $info=$this->retrieveInfo(request()->header('apikey'));
    if(!$info['worked']){return response()->json(['error' => 'Invalid API key'], 401);}
    if($info['live']){
        $merchants=identities_live::authenticateGetMerchant($info['api_userID'],$info['apikey']);
    }else{
        $merchants=identities::authenticateGetMerchant($info['api_userID'],$info['apikey']);
    }
    if(empty($merchants)){
         return response()->json(['error'=>"failed to get merchants"], 301);
    }
    return response()->json($merchants->toArray(), 201 , [] , JSON_PRETTY_PRINT );
}
public function MerchantIdentities_search(){
    $request=request()->all();
    $info=$this->retrieveInfo(request()->header('apikey'));
    if(!$info['worked']){return response()->json(['error' => 'Invalid API key'], 401);}
    if(!isset($request['search'])||empty($request['search'])){
        return response()->json(['error'=>"search not provided"], 301);
   }
   $search=$request['search'];
    if($info['live']){
        $merchants=identities_live::authenticateSearchMerchant($info['api_userID'],$info['apikey'], $search);
    }else{
        $merchants=identities::authenticateSearchMerchant($info['api_userID'],$info['apikey'], $search);
    }
    if(empty($merchants)){
         return response()->json(['error'=>"failed to get merchants"], 301);
    }
    return response()->json($merchants->toArray(), 201 , [] , JSON_PRETTY_PRINT );
}
public function createSubscription(){}
public function updateSubscription(){}
public function getSubscription(){}
public function getSubscriptions(){}
public function subscriptions_search(){}
}
