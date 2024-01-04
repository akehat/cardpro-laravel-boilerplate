<?php

namespace App\Http\Controllers;

use App\Http\Controllers\API\finixUsersController;
use App\Http\Controllers\API\merchantsController;
use Illuminate\Http\Request;
use App\Models\ApiKey;
use Illuminate\Support\Facades\Log;

class MerchantSignUpController extends Controller
{
    public function get(){
        return view('frontend.pages.portal.merchantSignUp');
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
        $request->entity_has_accepted_credit_cards_previously,
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
        merchantsController::createBankAccount(config("app.api_username"),config("app.api_password"),
        $request->bank_account_number,
        $request->bank_account_type,
        $request->bank_bank_code,
        $identity,
        $request->bank_name,
        $request->bank_type);
        $apiKeyPrefix = "SECRET_";
        $merchant=merchantsController::createAMerchantMinReq(config("app.api_username"),config("app.api_password"), $identity,merchantsController::$processors[0]);
        Log::info($merchant[0]);
        $merchantId=json_decode($merchant[0],true)["identity"];
        $apiKey = $apiKeyPrefix . $this->generateApiKey();

        // Check if the API key already exists in the database
        while (ApiKey::where('api_key', $apiKey)->exists()) {
            // If it exists, generate a new API key
            $apiKey = $apiKeyPrefix . $this->generateApiKey();
        }
        $api = ApiKey::create([
            'api_key' =>  $apiKey,
            'merchant_id' => $merchantId, // Associate with the merchant
            'live' => false,
            'balance' => 0,
            'identity' => $id[0],
        ]);
        $api->save();
        $api->refresh();
        dd($api);
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
        return view("frontend.pages.portal.jsonViewer",["json"=>merchantsController::listPayments(config("app.api_username"),config("app.api_password"),'https://finix.sandbox-payments-api.com',request()->query())[0]]);
    }
    public function payment($id){
        return view("frontend.pages.portal.jsonViewer",["json"=>merchantsController::fetchPayment(config("app.api_username"),config("app.api_password"),$id,'https://finix.sandbox-payments-api.com',request()->query())[0]]);
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
        return view("frontend.pages.portal.jsonViewer",["json"=>merchantsController::listPayments(config("app.api_username"),config("app.api_password"),'https://finix.live-payments-api.com',request()->query())[0]]);
    }
    public function payment_live($id){
        return view("frontend.pages.portal.jsonViewer",["json"=>merchantsController::fetchPayment(config("app.api_username"),config("app.api_password"),$id,'https://finix.live-payments-api.com',request()->query())[0]]);
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


}
