<?php

namespace App\Http\Controllers;

use App\Http\Controllers\API\finixUsersController;
use App\Http\Controllers\API\formController;
use App\Http\Controllers\API\merchantsController;
use App\Http\Controllers\API\payfacController;
use App\Http\Controllers\API\subscriptionController;
use Illuminate\Http\Request;
use App\Models\ApiKey;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class MerchantSignUpController extends Controller
{
    public function get(){
        if(Auth::user()->hasID){
        return view('frontend.pages.portal.merchantSignUp');
        }else{
        return view('frontend.pages.portal.organizationSignUp');
        }
    }
    public function getPayment(){
        return view('frontend.pages.portal.testPayment',['merchantJson'=>merchantsController::listMerchants(config("app.api_username"),config("app.api_password"),'https://finix.sandbox-payments-api.com',request()->query())[0]]);
    }
    public function getHold(){
        return view('frontend.pages.portal.testHold',['merchantJson'=>merchantsController::listMerchants(config("app.api_username"),config("app.api_password"),'https://finix.sandbox-payments-api.com',request()->query())[0]]);
    }
    public function getCheckout(){
        return view('frontend.pages.portal.testCheckout',['merchantJson'=>merchantsController::listMerchants(config("app.api_username"),config("app.api_password"),'https://finix.sandbox-payments-api.com',request()->query())[0]]);
    }
    public function paymentTest(Request $request){
        $id=merchantsController::createIdentityBuyerMinReq(config("app.api_username"),config("app.api_password"),$request->email);
        $id=json_decode($id[0],true)['id'];
        $card=merchantsController::createPaymentInstramentMinReq(config("app.api_username"),config("app.api_password"),
        $request->exp_month,$request->exp_year,$id,$request->name,$request->card_number,$request->cvv,"PAYMENT_CARD");
        $card=json_decode($card[0],true)['id'];
        $payment=merchantsController::makePaymentMinReq(config("app.api_username"),config("app.api_password"),$request->merchant,$request->currency,$request->amount_in_cents,$card);
        session()->flash('success', json_encode($payment[0]));
        return redirect()->back();
    }
    public function holdTest(Request $request){
        // dd($request);
        $id=merchantsController::createIdentityBuyerMinReq(config("app.api_username"),config("app.api_password"),$request->email);
        $id=json_decode($id[0],true)['id'];
        $card=merchantsController::createPaymentInstramentMinReq(config("app.api_username"),config("app.api_password"),
        $request->exp_month,$request->exp_year,$id,$request->name,$request->card_number,$request->cvv,"PAYMENT_CARD");
        $card=json_decode($card[0],true)['id'];
        $hold=merchantsController::createHold(config("app.api_username"),config("app.api_password"),$request->amount_in_cents,$request->currency,$request->merchant,$card,['hold'=>'new']);
        session()->flash('success', json_encode($hold[0]));
        return redirect()->back();
    }
    public function makeReturn(Request $request){
        return merchantsController::createRefund(config("app.api_username"),config("app.api_password"),$request->id,["refund"=>"made"],$request->amount)[0];
    }
    public function captureHold(Request $request){
        return merchantsController::captureHold(config("app.api_username"),config("app.api_password"),$request->id,$request->amount,0)[0];
    }
    public function returnHold(Request $request){
        return merchantsController::releaseHold(config("app.api_username"),config("app.api_password"),$request->id,true)[0];
    }
    public function checkoutTest(Request $request){
        // dd($request);
        return merchantsController::createPaymentLinkMinReq(config("app.api_username"),config("app.api_password"),
        $request->merchant,
        "ONE_TIME",
        $request->allowed_payment_methods_0,
        $request->nickname,
        ["primary_image_url" =>  $request->items_0_image_details_primary_image_url,
        "alternative_image_urls_0" => $request->items_0_image_details_alternative_image_urls_0,
        "alternative_image_urls_1" => $request->items_0_image_details_alternative_image_urls_1],
        $request->description,
        ["sale_amount" => $request->items_0_price_details_sale_amount,
        "currency" => $request->items_0_price_details_currency,
         "price_type" => $request->items_0_price_details_price_type,
        "regular_amount" => $request->items_0_price_details_regular_amount],
        1,
        $request->amount_details_amount_type,
        $request->amount_details_total_amount,
        $request->amount_details_currency,
        $request->amount_details_amount_breakdown_subtotal_amount,
        $request->amount_details_amount_breakdown_shipping_amount,
        $request->amount_details_amount_breakdown_estimated_tax_amount,
        $request->amount_details_amount_breakdown_discount_amount,
        $request->amount_details_amount_breakdown_tip_amount,
        $request->branding_brand_color,
      $request->branding_accent_color,
      $request->branding_logo,
      $request->branding_icon,
      $request->additional_details_collect_name??'false',
      $request->additional_details_collect_email??'false',
      $request->additional_details_collect_phone_number??'false',
      $request->additional_details_collect_billing_address??'false',
      $request->additional_details_collect_shipping_address??'false',
      $request->additional_details_success_return_url,
      $request->additional_details_cart_return_url,
      $request->additional_details_expired_session_url,
      $request->additional_details_terms_of_service_url,
      $request->additional_details_expiration_in_minutes
        )[0];
    }
    public function paylinkTest(Request $request){
        return 0;//formController::createCheckoutForm(config("app.api_username"),config("app.api_password"),$request->id,true)[0];
    }
    public function signup(Request $request){

        $id=merchantsController::createIdentityMerchantMinReq(config("app.api_username"),config("app.api_password"),
        $request->entity_annual_card_volume,
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
        $request->entity_url);
        Log::info($id[0]);
        $identity=json_decode($id[0],true)['id'];
        $apiKeyPrefix = "SECRET_";

        $apiKey = $apiKeyPrefix . $this->generateApiKey();

        // Check if the API key already exists in the database
        while (ApiKey::where('api_key', $apiKey)->exists()) {
            // If it exists, generate a new API key
            $apiKey = $apiKeyPrefix . $this->generateApiKey();
        }
        // if(!Auth::user()->hasID){
        //     $application=json_decode(payfacController::listApplications(config("app.api_username"),config("app.api_password"))[0])->_embedded->applications[0]->id;
        //     $user = finixUsersController::createAUser(config("app.api_username"),config("app.api_password"), $application,'https://finix.sandbox-payments-api.com',[],
        //     ["role"=> "ROLE_MERCHANT",
        //     "identity_id"=> $identity]
        // );
            // $user=Auth::user();
        //     Log::info($user[0]);

        //     return back();
        // }
        merchantsController::createBankAccount(config("app.api_username"),config("app.api_password"),
        $request->bank_account_number,
        $request->bank_account_type,
        $request->bank_bank_code,
        $identity,
        $request->bank_name,
        $request->bank_type);
        $merchant=merchantsController::createAMerchantMinReq(config("app.api_username"),config("app.api_password"), $identity,merchantsController::$processors[0]);
        Log::info($merchant[0]);
        $merchantId=json_decode($merchant[0],true)["identity"];
        $api = ApiKey::create([
            'api_key' =>  $apiKey,
            'merchant_id' => $merchantId, // Associate with the merchant
            'live' => false,
            'balance' => 0,
            'identity' => $id[0],
        ]);
        $api->save();
        $api->refresh();
        return view('frontend.pages.portal.merchantSignUp');
    }

    function generateApiKey($length = 32)
    {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $apiKey = '';

        for ($i = 0; $i < $length; $i++) {
            $apiKey .= $characters[rand(0, strlen($characters) - 1)];
        }

        return $apiKey;
    }
    public function identities(){
        return view("frontend.pages.portal.jsonViewer",["json"=>merchantsController::listIdentities(config("app.api_username"),config("app.api_password"),'https://finix.sandbox-payments-api.com',request()->query())[0]]);
    }
    public function apiusers(){
        return view("frontend.pages.portal.jsonViewer",["json"=>finixUsersController::listAllUsers(config("app.api_username"),config("app.api_password"),'https://finix.sandbox-payments-api.com',request()->query())[0]]);
    }
    public function fee_profiles(){
        return view("frontend.pages.portal.jsonViewer",["json"=>merchantsController::listFeeProfile(config("app.api_username"),config("app.api_password"),'https://finix.sandbox-payments-api.com',request()->query())[0]]);
    }
    public function fee_profile($id){
        return view("frontend.pages.portal.jsonViewer",["json"=>merchantsController::fetchFeeProfile(config("app.api_username"),config("app.api_password"),$id,'https://finix.sandbox-payments-api.com',request()->query())[0]]);
    }
    public function settlements(){
        return view("frontend.pages.portal.jsonViewer",["json"=>merchantsController::listSettlements(config("app.api_username"),config("app.api_password"),'https://finix.sandbox-payments-api.com',request()->query())[0]]);
    }
    public function settlement($id){
        return view("frontend.pages.portal.jsonViewer",["json"=>merchantsController::fetchSettlement(config("app.api_username"),config("app.api_password"),$id,'https://finix.sandbox-payments-api.com',request()->query())[0]]);
    }
    public function identity($id){
        return view("frontend.pages.portal.jsonViewer",["json"=>merchantsController::fetchIDIdentity(config("app.api_username"),config("app.api_password"),$id,'https://finix.sandbox-payments-api.com',request()->query())[0]]);
    }
    public function payments(){
        return view("frontend.pages.portal.paymentsViewer",["json"=>merchantsController::listPayments(config("app.api_username"),config("app.api_password"),'https://finix.sandbox-payments-api.com',request()->query())[0]]);
    }
    public function payment($id){
        return view("frontend.pages.portal.paymentsViewer",["json"=>merchantsController::fetchPayment(config("app.api_username"),config("app.api_password"),$id,'https://finix.sandbox-payments-api.com',request()->query())[0]]);
    }
    public function payment_instraments(){
        return view("frontend.pages.portal.jsonViewer",["json"=>merchantsController::listPaymentInstraments(config("app.api_username"),config("app.api_password"),'https://finix.sandbox-payments-api.com',request()->query())[0]]);
    }
    public function payment_instrament($id){
        return view("frontend.pages.portal.jsonViewer",["json"=>merchantsController::fetchPaymentInstrament(config("app.api_username"),config("app.api_password"),$id,'https://finix.sandbox-payments-api.com',request()->query())[0]]);
    }
    public function merchants(){
        return view("frontend.pages.portal.jsonViewer",['json'=>merchantsController::listMerchants(config("app.api_username"),config("app.api_password"),'https://finix.sandbox-payments-api.com',request()->query())[0]]);
    }
    public function merchant($id){
        return view("frontend.pages.portal.jsonViewer",['json'=>merchantsController::fetchMerchant(config("app.api_username"),config("app.api_password"),$id,'https://finix.sandbox-payments-api.com',request()->query())[0]]);
    }
    public function identities_live(){
        return view("frontend.pages.portal.jsonViewer",["json"=>merchantsController::listIdentities(config("app.api_username"),config("app.api_password"),'https://finix.live-payments-api.com',request()->query())[0]]);
    }
    public function apiusers_live(){
        return view("frontend.pages.portal.jsonViewer",["json"=>finixUsersController::listAllUsers(config("app.api_username"),config("app.api_password"),'https://finix.live-payments-api.com',request()->query())[0]]);
    }
    public function apiuser_live($id){
        return view("frontend.pages.portal.jsonViewer",["json"=>finixUsersController::fetchAUser(config("app.api_username"),config("app.api_password"),$id,'https://finix.live-payments-api.com',request()->query())[0]]);
    }
    public function identity_live($id){
        return view("frontend.pages.portal.jsonViewer",["json"=>merchantsController::fetchIDIdentity(config("app.api_username"),config("app.api_password"),$id,'https://finix.live-payments-api.com',request()->query())[0]]);
    }
    public function payments_live(){
        return view("frontend.pages.portal.paymentsViewer",["json"=>merchantsController::listPayments(config("app.api_username"),config("app.api_password"),'https://finix.live-payments-api.com',request()->query())[0]]);
    }
    public function payment_live($id){
        return view("frontend.pages.portal.paymentsViewer",["json"=>merchantsController::fetchPayment(config("app.api_username"),config("app.api_password"),$id,'https://finix.live-payments-api.com',request()->query())[0]]);
    }
    public function payment_instraments_live(){
        return view("frontend.pages.portal.jsonViewer",["json"=>merchantsController::listPaymentInstraments(config("app.api_username"),config("app.api_password"),'https://finix.live-payments-api.com',request()->query())[0]]);
    }
    public function payment_instrament_live($id){
        return view("frontend.pages.portal.jsonViewer",["json"=>merchantsController::fetchPaymentInstrament(config("app.api_username"),config("app.api_password"),$id,'https://finix.live-payments-api.com',request()->query())[0]]);
    }
    public function merchants_live(){
        return view("frontend.pages.portal.jsonViewer",['json'=>merchantsController::listMerchants(config("app.api_username"),config("app.api_password"),'https://finix.live-payments-api.com',request()->query())[0]]);
    }
    public function merchant_live($id){
        return view("frontend.pages.portal.jsonViewer",['json'=>merchantsController::fetchMerchant(config("app.api_username"),config("app.api_password"),$id,'https://finix.live-payments-api.com',request()->query())[0]]);
    }
    public function settlements_live(){
        return view("frontend.pages.portal.jsonViewer",["json"=>merchantsController::listSettlements(config("app.api_username"),config("app.api_password"),'https://finix.live-payments-api.com',request()->query())[0]]);
    }
    public function settlement_live($id){
        return view("frontend.pages.portal.jsonViewer",["json"=>merchantsController::fetchSettlement(config("app.api_username"),config("app.api_password"),$id,'https://finix.live-payments-api.com',request()->query())[0]]);
    }
    public function fee_profiles_live(){
        return view("frontend.pages.portal.jsonViewer",["json"=>merchantsController::listFeeProfile(config("app.api_username"),config("app.api_password"),'https://finix.live-payments-api.com',request()->query())[0]]);
    }
    public function fee_profile_live($id){
        return view("frontend.pages.portal.jsonViewer",["json"=>merchantsController::fetchFeeProfile(config("app.api_username"),config("app.api_password"),$id,'https://finix.live-payments-api.com',request()->query())[0]]);
    }
    public function disputes(){
        return view("frontend.pages.portal.jsonViewer",["json"=>merchantsController::listDisputes(config("app.api_username"),config("app.api_password"),'https://finix.sandbox-payments-api.com',request()->query())[0]]);
    }
    public function dispute($id){
        return view("frontend.pages.portal.jsonViewer",["json"=>merchantsController::fetchDispute(config("app.api_username"),config("app.api_password"),$id,'https://finix.sandbox-payments-api.com',request()->query())[0]]);
    }
    public function disputes_live(){
        return view("frontend.pages.portal.jsonViewer",["json"=>merchantsController::listDisputes(config("app.api_username"),config("app.api_password"),'https://finix.live-payments-api.com',request()->query())[0]]);
    }
    public function dispute_live($id){
        return view("frontend.pages.portal.jsonViewer",["json"=>merchantsController::fetchDispute(config("app.api_username"),config("app.api_password"),$id,'https://finix.live-payments-api.com',request()->query())[0]]);
    }
    public function compliances(){
        return view("frontend.pages.portal.jsonViewer",["json"=>formController::listPCIforms(config("app.api_username"),config("app.api_password"),'https://finix.sandbox-payments-api.com',request()->query())[0]]);
    }
    public function compliance($id){
        return view("frontend.pages.portal.jsonViewer",["json"=>formController::fetchPCIForm(config("app.api_username"),config("app.api_password"),$id,'https://finix.sandbox-payments-api.com',request()->query())[0]]);
    }
    public function compliances_live(){
        return view("frontend.pages.portal.jsonViewer",["json"=>formController::listPCIforms(config("app.api_username"),config("app.api_password"),'https://finix.live-payments-api.com',request()->query())[0]]);
    }
    public function compliance_live($id){
        return view("frontend.pages.portal.jsonViewer",["json"=>formController::fetchPCIForm(config("app.api_username"),config("app.api_password"),$id,'https://finix.live-payments-api.com',request()->query())[0]]);
    }
    public function holds(){
        return view("frontend.pages.portal.holdsViewer",["json"=>merchantsController::listHolds(config("app.api_username"),config("app.api_password"),'https://finix.sandbox-payments-api.com',request()->query())[0]]);
    }
    public function hold($id){
        return view("frontend.pages.portal.holdsViewer",["json"=>merchantsController::fetchHold(config("app.api_username"),config("app.api_password"),$id,'https://finix.sandbox-payments-api.com',request()->query())[0]]);
    }
    public function holds_live(){
        return view("frontend.pages.portal.holdsViewer",["json"=>merchantsController::listHolds(config("app.api_username"),config("app.api_password"),'https://finix.live-payments-api.com',request()->query())[0]]);
    }
    public function hold_live($id){
        return view("frontend.pages.portal.holdsViewer",["json"=>merchantsController::fetchHold(config("app.api_username"),config("app.api_password"),$id,'https://finix.live-payments-api.com',request()->query())[0]]);
    }
    public function checkouts(){
        return view("frontend.pages.portal.jsonViewer",["json"=>formController::listCheckoutForm(config("app.api_username"),config("app.api_password"),'https://finix.sandbox-payments-api.com',request()->query())[0]]);
    }
    public function checkout($id){
        return view("frontend.pages.portal.jsonViewer",["json"=>formController::fetchCheckoutForm(config("app.api_username"),config("app.api_password"),$id,'https://finix.sandbox-payments-api.com',request()->query())[0]]);
    }
    public function checkouts_live(){
        return view("frontend.pages.portal.jsonViewer",["json"=>formController::listCheckoutForm(config("app.api_username"),config("app.api_password"),'https://finix.live-payments-api.com',request()->query())[0]]);
    }
    public function checkout_live($id){
        return view("frontend.pages.portal.jsonViewer",["json"=>formController::fetchCheckoutForm(config("app.api_username"),config("app.api_password"),$id,'https://finix.live-payments-api.com',request()->query())[0]]);
    }
    public function onboarding($id){
        return view("frontend.pages.portal.jsonViewer",["json"=>formController::fetchOnBoardingForm(config("app.api_username"),config("app.api_password"),$id,'https://finix.sandbox-payments-api.com',request()->query())[0]]);
    }
    public function onboarding_live($id){
        return view("frontend.pages.portal.jsonViewer",["json"=>formController::fetchOnBoardingForm(config("app.api_username"),config("app.api_password"),$id,'https://finix.live-payments-api.com',request()->query())[0]]);
    }
    public function paymentLinks(){
        return view("frontend.pages.portal.jsonViewer",["json"=>merchantsController::listPymentLink(config("app.api_username"),config("app.api_password"),'https://finix.sandbox-payments-api.com',request()->query())[0]]);
    }
    public function paymentLink($id){
        return view("frontend.pages.portal.jsonViewer",["json"=>merchantsController::fetchPaymentLink(config("app.api_username"),config("app.api_password"),$id,'https://finix.sandbox-payments-api.com',request()->query())[0]]);
    }
    public function paymentLinks_live(){
        return view("frontend.pages.portal.jsonViewer",["json"=>merchantsController::listPymentLink(config("app.api_username"),config("app.api_password"),'https://finix.live-payments-api.com',request()->query())[0]]);
    }
    public function paymentLink_live($id){
        return view("frontend.pages.portal.jsonViewer",["json"=>merchantsController::fetchPaymentLink(config("app.api_username"),config("app.api_password"),$id,'https://finix.live-payments-api.com',request()->query())[0]]);
    }
    public function balanceTransfers(){
        return view("frontend.pages.portal.jsonViewer",["json"=>payfacController::listBalanceTransfers(config("app.api_username"),config("app.api_password"),'https://finix.sandbox-payments-api.com',request()->query())[0]]);
    }
    public function balanceTransfer($id){
        return view("frontend.pages.portal.jsonViewer",["json"=>payfacController::fetchBalanceTransfers(config("app.api_username"),config("app.api_password"),$id,'https://finix.sandbox-payments-api.com',request()->query())[0]]);
    }
    public function balanceTransfers_live(){
        return view("frontend.pages.portal.jsonViewer",["json"=>payfacController::listBalanceTransfers(config("app.api_username"),config("app.api_password"),'https://finix.live-payments-api.com',request()->query())[0]]);
    }
    public function balanceTransfer_live($id){
        return view("frontend.pages.portal.jsonViewer",["json"=>payfacController::fetchBalanceTransfers(config("app.api_username"),config("app.api_password"),$id,'https://finix.live-payments-api.com',request()->query())[0]]);
    }
    public function verifications(){
        return view("frontend.pages.portal.jsonViewer",["json"=>payfacController::listVerifications(config("app.api_username"),config("app.api_password"),'https://finix.sandbox-payments-api.com',request()->query())[0]]);
    }
    public function verification($id){
        return view("frontend.pages.portal.jsonViewer",["json"=>payfacController::fetchVerifications(config("app.api_username"),config("app.api_password"),$id,'https://finix.sandbox-payments-api.com',request()->query())[0]]);
    }
    public function verifications_live(){
        return view("frontend.pages.portal.jsonViewer",["json"=>payfacController::listVerifications(config("app.api_username"),config("app.api_password"),'https://finix.live-payments-api.com',request()->query())[0]]);
    }
    public function verification_live($id){
        return view("frontend.pages.portal.jsonViewer",["json"=>payfacController::fetchVerifications(config("app.api_username"),config("app.api_password"),$id,'https://finix.live-payments-api.com',request()->query())[0]]);
    }
    public function subscriptionSchedules(){
        return view("frontend.pages.portal.jsonViewer",["json"=>subscriptionController::listsubscriptionSchedule(config("app.api_username"),config("app.api_password"),'https://finix.sandbox-payments-api.com',request()->query())[0]]);
    }
    public function subscriptionSchedule($id){
        return view("frontend.pages.portal.jsonViewer",["json"=>subscriptionController::fetchsubscriptionSchedule(config("app.api_username"),config("app.api_password"),$id,'https://finix.sandbox-payments-api.com',request()->query())[0]]);
    }
    public function subscriptionSchedules_live(){
        return view("frontend.pages.portal.jsonViewer",["json"=>subscriptionController::listSubscriptionSchedule(config("app.api_username"),config("app.api_password"),'https://finix.live-payments-api.com',request()->query())[0]]);
    }
    public function subscriptionSchedule_live($id){
        return view("frontend.pages.portal.jsonViewer",["json"=>subscriptionController::fetchSubscriptionSchedule(config("app.api_username"),config("app.api_password"),$id,'https://finix.live-payments-api.com',request()->query())[0]]);
    }
    public function subscriptionAmounts(){
        return view("frontend.pages.portal.jsonViewer",["json"=>subscriptionController::listSubscriptionAmounts(config("app.api_username"),config("app.api_password"),'https://finix.sandbox-payments-api.com',request()->query())[0]]);
    }
    public function subscriptionAmount($id){
        return view("frontend.pages.portal.jsonViewer",["json"=>subscriptionController::fetchSubscriptionAmount(config("app.api_username"),config("app.api_password"),$id,'https://finix.sandbox-payments-api.com',request()->query())[0]]);
    }
    public function subscriptionAmounts_live(){
        return view("frontend.pages.portal.jsonViewer",["json"=>subscriptionController::listSubscriptionAmounts(config("app.api_username"),config("app.api_password"),'https://finix.live-payments-api.com',request()->query())[0]]);
    }
    public function subscriptionAmount_live($id){
        return view("frontend.pages.portal.jsonViewer",["json"=>subscriptionController::fetchSubscriptionAmount(config("app.api_username"),config("app.api_password"),$id,'https://finix.live-payments-api.com',request()->query())[0]]);
    }
    public function subscriptionEnrollments(){
        return view("frontend.pages.portal.jsonViewer",["json"=>subscriptionController::listSubscriptionEnrollments(config("app.api_username"),config("app.api_password"),'https://finix.sandbox-payments-api.com',request()->query())[0]]);
    }
    public function subscriptionEnrollment($id){
        return view("frontend.pages.portal.jsonViewer",["json"=>subscriptionController::fetchSubscriptionEnrollment(config("app.api_username"),config("app.api_password"),$id,'https://finix.sandbox-payments-api.com',request()->query())[0]]);
    }
    public function subscriptionEnrollments_live(){
        return view("frontend.pages.portal.jsonViewer",["json"=>subscriptionController::listSubscriptionEnrollments(config("app.api_username"),config("app.api_password"),'https://finix.live-payments-api.com',request()->query())[0]]);
    }
    public function subscriptionEnrollment_live($id){
        return view("frontend.pages.portal.jsonViewer",["json"=>subscriptionController::fetchSubscriptionEnrollment(config("app.api_username"),config("app.api_password"),$id,'https://finix.live-payments-api.com',request()->query())[0]]);
    }


}
