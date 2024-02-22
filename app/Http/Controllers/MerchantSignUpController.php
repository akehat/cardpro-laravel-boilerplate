<?php

namespace App\Http\Controllers;

use App\Domains\Auth\Models\User;
use App\Http\Controllers\API\finixUsersController;
use App\Http\Controllers\API\formController;
use App\Http\Controllers\API\merchantsController;
use App\Http\Controllers\API\payfacController;
use App\Http\Controllers\API\subscriptionController;
use Illuminate\Http\Request;
use App\Models\ApiKey;
use App\Models\ApiUser;
use App\Models\Authorization;
use App\Models\Authorization_live;
use App\Models\awaiting_PCI;
use App\Models\awaiting_PCI_live;
use App\Models\awaiting_users;
use App\Models\awaiting_users_live;
use App\Models\BalanceTransfer;
use App\Models\BalanceTransfer_live;
use App\Models\finix_checkout_forms;
use App\Models\finix_checkout_forms_live;
use App\Models\Finix_Disputes;
use App\Models\Finix_Disputes_live;
use App\Models\finix_fee_profiles;
use App\Models\finix_fee_profiles_live;
use App\Models\Finix_Merchant;
use App\Models\Finix_Merchant_live;
use App\Models\finix_payment_links;
use App\Models\finix_payment_links_live;
use App\Models\finix_payments;
use App\Models\finix_payments_live;
use App\Models\identities;
use App\Models\identities_live;
use App\Models\payment_ways;
use App\Models\payment_ways_live;
use App\Models\pci_forms;
use App\Models\pci_forms_live;
use App\Models\settlements;
use App\Models\settlements_live;
use App\Models\subscription_amounts;
use App\Models\subscription_amounts_live;
use App\Models\subscription_enrollments;
use App\Models\subscription_enrollments_live;
use App\Models\subscription_schedules;
use App\Models\subscription_schedules_live;
use App\Models\verifications;
use App\Models\verifications_live;
use Browser;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;

class MerchantSignUpController extends Controller
{
    public function get(){
        // if(Auth::user()->hasID){
            $this->loadUserSession();
            return view('frontend.pages.portal.merchantSignUp');
        // }else{
            return view('frontend.pages.portal.organizationSignUp');
        // }
    }
    public function getKeys(){
        $array['data']=User::getApiDataByUserId(Auth::id());
        // dd($array);
        $array['next_page_url']=null;
        $array['prev_page_url']=null;
        $array['data']=isset($array['data'])?$array['data']:null;
        return view("frontend.pages.portal.jsonViewer",["json"=>str_replace(['\\','`'],['\\\\','｀'],json_encode((object)[$array['data']], JSON_PRETTY_PRINT)),'next'=>$array['next_page_url'],'prev'=>$array['prev_page_url']]);
    }

    public function getFeeForm(){
        return view('frontend.pages.portal.feeProfileAdmin');
    }
    public function getPayment(){
        $array['data']=Finix_Merchant::accessible()->get()->toArray();
        $array['data']=isset($array['data'])?$array['data']:null;

        return view('frontend.pages.portal.testPayment',['merchantJson'=>str_replace(['\\','`'],['\\\\','｀'],json_encode((object)[$array['data']], JSON_PRETTY_PRINT))]);
    }
    public function getPaylink(){
        $array['data']=Finix_Merchant::accessible()->get()->toArray();
        $array['data']=isset($array['data'])?$array['data']:null;
        return view('frontend.pages.portal.testPaymentLink',['merchantJson'=>str_replace(['\\','`'],['\\\\','｀'],json_encode((object)[$array['data']], JSON_PRETTY_PRINT))]);
    }
    public function getHold(){
        $array['data']=Finix_Merchant::accessible()->get()->toArray();
        $array['data']=isset($array['data'])?$array['data']:null;
        return view('frontend.pages.portal.testHold',['merchantJson'=>str_replace(['\\','`'],['\\\\','｀'],json_encode((object)[$array['data']], JSON_PRETTY_PRINT))]);
    }
    public function getCheckout(){
        $array['data']=Finix_Merchant::accessible()->get()->toArray();
        $array['data']=isset($array['data'])?$array['data']:null;

        return view('frontend.pages.portal.testCheckout',['merchantJson'=>str_replace(['\\','`'],['\\\\','｀'],json_encode((object)[$array['data']], JSON_PRETTY_PRINT))]);
    }
    public function paymentTest(Request $request){
        $user_id=Auth::id();
        $apiUser_id=ApiUser::where("user_id",$user_id)->select("id")->first()->id;
        $apiKeyID=ApiKey::where("merchant_id",$request->merchant)->select("id")->first();
        $apiKeyID=($apiKeyID!=null)?$apiKeyID->id:0;
        $buyerIdentity=identities::makeBuyerIdentity($request->email,
        $user_id,
        $apiUser_id,
        $apiKeyID
    );
        if(!$buyerIdentity["worked"]){
            session()->flash('success', 'unable to make buyer identity '.$buyerIdentity["responce"]);
            return redirect()->back();
        }
        $buyerId=$buyerIdentity["ref"]->finix_id;
        $card=payment_ways::makeCard(
            $request->exp_month,$request->exp_year,$buyerId,$request->name,$request->card_number,$request->cvv,
            $user_id,
            $apiUser_id,
            $apiKeyID
        );
        if(!$card["worked"]){
            session()->flash('success', 'unable to make card object '.$card["responce"]);
            return redirect()->back();
        }
        $cardId=$card["ref"]->finix_id;
        $payment=finix_payments::makePayment(
            $request->merchant,$request->currency,$request->amount_in_cents,$cardId,
            $user_id,
            $apiUser_id,
            $apiKeyID
        );
        if(!$payment["worked"]){
            session()->flash('success', 'unable to make payment '.$payment["responce"]);
            return redirect()->back();
        }
        session()->flash('success', json_encode($payment["responce"]));
        return redirect()->back();
    }
    public function feeProfileTest(Request $request){
        $application=json_decode(payfacController::listApplications(config("app.api_username"),config("app.api_password"))[0])->_embedded->applications[0]->id;
        $id=merchantsController::createFeeProfile(config("app.api_username"),config("app.api_password"),
        $request->ach_basis_points,
        $request->ach_fixed_fee,
        $application,
        $request->basis_points,
        $request->card_cross_border_basis_points,
        $request->card_cross_border_fixed_fee,
        $request->charge_interchange??false,
        $request->fixed_fee,
        ['test'=>"made"]
    );
    session()->flash('success', json_encode($id[0]));
        return redirect()->back();

    }
    public function holdTest(Request $request){
        $user_id=Auth::id();
        $apiUser_id=ApiUser::where("user_id",$user_id)->select("id")->first()->id;
        $apiKeyID=ApiKey::where("merchant_id",$request->merchant)->select("id")->first();
        $apiKeyID=($apiKeyID!=null)?$apiKeyID->id:0;
        $buyerIdentity=identities::makeBuyerIdentity($request->email,
        $user_id,
        $apiUser_id,
        $apiKeyID
    );
        if(!$buyerIdentity["worked"]){
            session()->flash('success', 'unable to make buyer identity '.$buyerIdentity["responce"]);
            return redirect()->back();
        }
        $buyerId=$buyerIdentity["ref"]->finix_id;
        $card=payment_ways::makeCard(
            $request->exp_month,$request->exp_year,$buyerId,$request->name,$request->card_number,$request->cvv,
            $user_id,
            $apiUser_id,
            $apiKeyID
        );
        if(!$card["worked"]){
            session()->flash('success', 'unable to make card object '.$card["responce"]);
            return redirect()->back();
        }
        $cardId=$card["ref"]->finix_id;
        $hold=Authorization::makeHold(
            $request->merchant,$request->currency,$request->amount_in_cents,$cardId,
            $user_id,
            $apiUser_id,
            $apiKeyID
        );
        if(!$hold["worked"]){
            session()->flash('success', 'unable to make hold '.$hold["responce"]);
            return redirect()->back();
        }
        session()->flash('success', json_encode($hold["responce"]));
        return redirect()->back();
    }
    public function makeReturn(Request $request){
        $payment=finix_payments::where('id',$request->id)->first();
        $user_id=Auth::id();
        $apiUser_id=ApiUser::where("user_id",$user_id)->select("id")->first()->id;
        $apiKeyID=ApiKey::where('merchant_id',$payment->merchant)->first();
        $apiKeyID=($apiKeyID!=null)?$apiKeyID->id:0;
        return json_encode(finix_payments::makeRefund($payment->finix_id,$request->amount,$apiUser_id,$apiKeyID));
    }
    public function captureHold(Request $request){
        $payment=Authorization::where('id',$request->id)->first();
        $user_id=Auth::id();
        $apiUser_id=ApiUser::where("user_id",$user_id)->select("id")->first()->id;
        return json_encode(Authorization::makeCapture($payment->finix_id,$request->amount,$apiUser_id));
    }
    public function returnHold(Request $request){
        $payment=Authorization::where('id',$request->id)->first();
        $user_id=Auth::id();
        $apiUser_id=ApiUser::where("user_id",$user_id)->select("id")->first()->id;
        return json_encode(Authorization::voidCapture($payment->finix_id,$apiUser_id));
    }
    public function checkoutTest(Request $request){
        $user_id=Auth::id();
        $apiUser_id=ApiUser::where("user_id",$user_id)->select("id")->first()->id;
        $apiKeyID=ApiKey::where("merchant_id",$request->merchant)->select("id")->first();
        $apiKeyID=($apiKeyID!=null)?$apiKeyID->id:0;
        $buyerIdentity=identities::makeBuyerIdentity($request->email,
        $user_id,
        $apiUser_id,
        $apiKeyID
    );
        if(!$buyerIdentity["worked"]){
            session()->flash('success', 'unable to make buyer identity '.$buyerIdentity["responce"]);
            return redirect()->back();
        }
        $checkout=finix_checkout_forms::makeCheckout(
            $request->amount_details_amount_type,
            $request->amount_details_total_amount,
            $request->amount_details_currency,
            null,null,
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
            $request->merchant,
            false,
            [$request->allowed_payment_methods_0],
            $request->nickname,
            ["primary_image_url" =>  $request->items_0_image_details_primary_image_url,
            "alternative_image_urls_0" => $request->items_0_image_details_alternative_image_urls_0,
            "alternative_image_urls_1" => $request->items_0_image_details_alternative_image_urls_1],
            $request->description,
            ["sale_amount" => $request->items_0_price_details_sale_amount,
            "currency" => $request->items_0_price_details_currency,
             "price_type" => $request->items_0_price_details_price_type,
            "regular_amount" => $request->items_0_price_details_regular_amount],
            1,$buyerIdentity, $user_id,
            $apiUser_id,
            $apiKeyID
        );
        if(!$checkout["worked"]){
            session()->flash('success', 'unable to make checkout '.$checkout["responce"]);
            return redirect()->back();
        }
        session()->flash('success', 'checkout made '.$checkout["responce"]);
         return redirect()->back();
    }
    public function paylinkTest(Request $request){
        $user_id=Auth::id();
        $apiUser_id=ApiUser::where("user_id",$user_id)->select("id")->first()->id;
        $apiKeyID=ApiKey::where("merchant_id",$request->merchant)->select("id")->first();
        $apiKeyID=($apiKeyID!=null)?$apiKeyID->id:0;
        $buyerIdentity=identities::makeBuyerIdentity($request->email,
        $user_id,
        $apiUser_id,
        $apiKeyID
    );
        if(!$buyerIdentity["worked"]){
            session()->flash('success', 'unable to make buyer identity '.$buyerIdentity["responce"]);
            return redirect()->back();
        }
        $paymentLink=finix_payment_links::makePaymentLink(
            $request->amount_details_amount_type,
            $request->amount_details_total_amount,
            $request->amount_details_currency,
            null,null,
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
            $request->merchant,
            false,
            [$request->allowed_payment_methods_0],
            $request->nickname,
            ["primary_image_url" =>  $request->items_0_image_details_primary_image_url,
            "alternative_image_urls_0" => $request->items_0_image_details_alternative_image_urls_0,
            "alternative_image_urls_1" => $request->items_0_image_details_alternative_image_urls_1],
            $request->description,
            ["sale_amount" => $request->items_0_price_details_sale_amount,
            "currency" => $request->items_0_price_details_currency,
             "price_type" => $request->items_0_price_details_price_type,
            "regular_amount" => $request->items_0_price_details_regular_amount],
            1,$buyerIdentity, $user_id,
            $apiUser_id,
            $apiKeyID
        );
        if(!$paymentLink["worked"]){
            session()->flash('success', 'unable to make payment link '.$paymentLink["responce"]);
            return redirect()->back();
        }
        session()->flash('success', 'payment link made '.$paymentLink["responce"]);
         return redirect()->back();
    //     return merchantsController::createPaymentLinkMinReq(config("app.api_username"),config("app.api_password"),
    //     $request->merchant,
    //     "ONE_TIME",
    //     $request->allowed_payment_methods_0,
    //     $request->nickname,
    //     ["primary_image_url" =>  $request->items_0_image_details_primary_image_url,
    //     "alternative_image_urls_0" => $request->items_0_image_details_alternative_image_urls_0,
    //     "alternative_image_urls_1" => $request->items_0_image_details_alternative_image_urls_1],
    //     $request->description,
    //     ["sale_amount" => $request->items_0_price_details_sale_amount,
    //     "currency" => $request->items_0_price_details_currency,
    //      "price_type" => $request->items_0_price_details_price_type,
    //     "regular_amount" => $request->items_0_price_details_regular_amount],
    //     1,
    //     $request->amount_details_amount_type,
    //     $request->amount_details_total_amount,
    //     $request->amount_details_currency,
    //     $request->amount_details_amount_breakdown_subtotal_amount,
    //     $request->amount_details_amount_breakdown_shipping_amount,
    //     $request->amount_details_amount_breakdown_estimated_tax_amount,
    //     $request->amount_details_amount_breakdown_discount_amount,
    //     $request->amount_details_amount_breakdown_tip_amount,
    //     $request->branding_brand_color,
    //   $request->branding_accent_color,
    //   $request->branding_logo,
    //   $request->branding_icon,
    //   $request->additional_details_collect_name??'false',
    //   $request->additional_details_collect_email??'false',
    //   $request->additional_details_collect_phone_number??'false',
    //   $request->additional_details_collect_billing_address??'false',
    //   $request->additional_details_collect_shipping_address??'false',
    //   $request->additional_details_success_return_url,
    //   $request->additional_details_cart_return_url,
    //   $request->additional_details_expired_session_url,
    //   $request->additional_details_terms_of_service_url,
    //   $request->additional_details_expiration_in_minutes
    //     )[0];//formController::createCheckoutForm(config("app.api_username"),config("app.api_password"),$request->id,true)[0];
    }
    public function signup(Request $request){
        $user_id=Auth::id();
        $apiUser_id=ApiUser::where("user_id",$user_id)->select("id")->first()->id;
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
        $request->entity_url,
        $user_id,
        $apiUser_id
    );
        if(!$merchantIdentity["worked"]){
            session()->flash('success', 'unable to make merchant identity '.$merchantIdentity["responce"]);
            return redirect()->back();
        }
        $identity=$merchantIdentity["ref"]->finix_id;

        $bank=payment_ways::makeBank(
            $request->bank_account_number,
            $request->bank_account_type,
            $request->bank_bank_code,
            $identity,
            $request->bank_name,
            $request->bank_type,
            $user_id,
            $apiUser_id
        );
        if(!$bank["worked"]){
            session()->flash('success', 'unable to make bank '.$bank["responce"]);
            return redirect()->back();
        }
        $merchant=Finix_Merchant::makeMerchant($identity,
        $user_id,
        $apiUser_id
    );
    if(!$merchant["worked"]){
        session()->flash('success', 'unable to make merchant '.$merchant["responce"]);
        return redirect()->back();
    }
        if(!Auth::user()->hasID){
            $awaiting=awaiting_users::create([
                'identity'=>$identity,
                'user_id'=>Auth::id()
            ]);
            $awaiting->save();
            $awaiting->refresh();
            session()->flash('success', 'working on it please wait for the merchant to verify... check back later');
        }
        $browser = new Browser();
        $awaiting=awaiting_PCI::create([
            'name'=>$request->entity_first_name." ".$request->entity_last_name,
            'ip'=>$this->getIp(),
            'user_id'=>Auth::id(),
            'merchant_id'=>$merchant["ref"]->finix_id,
            'pci_title'=>$request->PCI_title,
            'browser'=>$browser->getUserAgent()
        ]);
        $awaiting->save();
        $awaiting->refresh();
        session()->flash('success', 'working on it please wait for the merchant to verify... check back later');
        return redirect()->back();
    }
    public function getLive(){
        // if(Auth::user()->hasID){
            $this->loadUserSession();
            return view('frontend.pages.portal.merchantSignUp');
        // }else{
            return view('frontend.pages.portal.organizationSignUp');
        // }
    }

    public function getFeeFormLive(){
        return view('frontend.pages.portal.feeProfileAdminLive');
    }
    public function getPaymentLive(){
        $array['data']=Finix_Merchant_live::accessible()->get()->toArray();
        $array['data']=isset($array['data'])?$array['data']:null;
        return view('frontend.pages.portal.livePayment',['merchantJson'=>str_replace(['\\','`'],['\\\\','｀'],json_encode((object)[$array['data']], JSON_PRETTY_PRINT))]);
    }
    public function getHoldLive(){
        $array['data']=Finix_Merchant_live::accessible()->get()->toArray();
        $array['data']=isset($array['data'])?$array['data']:null;
        return view('frontend.pages.portal.liveHold',['merchantJson'=>str_replace(['\\','`'],['\\\\','｀'],json_encode((object)[$array['data']], JSON_PRETTY_PRINT))]);
    }
    public function getCheckoutLive(){
        $array['data']=Finix_Merchant_live::accessible()->get()->toArray();
        $array['data']=isset($array['data'])?$array['data']:null;
        return view('frontend.pages.portal.liveCheckout',['merchantJson'=>str_replace(['\\','`'],['\\\\','｀'],json_encode((object)[$array['data']], JSON_PRETTY_PRINT))]);
    }
    public function paymentLive(Request $request){
        $user_id=Auth::id();
        $apiUser_id=ApiUser::where("user_id",$user_id)->select("id")->first()->id;
        $apiKeyID=ApiKey::where('live',1)->where("merchant_id",$request->merchant)->select("id")->first();
        $apiKeyID=($apiKeyID!=null)?$apiKeyID->id:0;
        $buyerIdentity=identities_live::makeBuyerIdentity($request->email,
        $user_id,
        $apiUser_id,
        $apiKeyID
    );
        if(!$buyerIdentity["worked"]){
            session()->flash('success', 'unable to make buyer identity '.$buyerIdentity["responce"]);
            return redirect()->back();
        }
        $buyerId=$buyerIdentity["ref"]->finix_id;
        $card=payment_ways_live::makeCard(
            $request->exp_month,$request->exp_year,$buyerId,$request->name,$request->card_number,$request->cvv,
            $user_id,
            $apiUser_id,
            $apiKeyID
        );
        if(!$card["worked"]){
            session()->flash('success', 'unable to make card object '.$card["responce"]);
            return redirect()->back();
        }
        $cardId=$card["ref"]->finix_id;
        $payment=finix_payments_live::makePayment(
            $request->merchant,$request->currency,$request->amount_in_cents,$cardId,
            $user_id,
            $apiUser_id,
            $apiKeyID
        );
        if(!$payment["worked"]){
            session()->flash('success', 'unable to make payment '.$payment["responce"]);
            return redirect()->back();
        }
        session()->flash('success', json_encode($payment["responce"]));
        return redirect()->back();
    }
    public function feeProfileLive(Request $request){
        $application=json_decode(payfacController::listApplications(config("app.api_username"),config("app.api_password"))[0])->_embedded->applications[0]->id;
        $id=merchantsController::createFeeProfile(config("app.api_username"),config("app.api_password"),
        $request->ach_basis_points,
        $request->ach_fixed_fee,
        $application,
        $request->basis_points,
        $request->card_cross_border_basis_points,
        $request->card_cross_border_fixed_fee,
        $request->charge_interchange??false,
        $request->fixed_fee,
        ['test'=>"made"],

    );
    session()->flash('success', json_encode($id[0]));
        return redirect()->back();

    }
    public function holdLive(Request $request){
        $user_id=Auth::id();
        $apiUser_id=ApiUser::where("user_id",$user_id)->select("id")->first()->id;
        $apiKeyID=ApiKey::where('live',1)->where("merchant_id",$request->merchant)->select("id")->first();
        $apiKeyID=($apiKeyID!=null)?$apiKeyID->id:0;
        $buyerIdentity=identities_live::makeBuyerIdentity($request->email,
        $user_id,
        $apiUser_id,
        $apiKeyID
    );
        if(!$buyerIdentity["worked"]){
            session()->flash('success', 'unable to make buyer identity '.$buyerIdentity["responce"]);
            return redirect()->back();
        }
        $buyerId=$buyerIdentity["ref"]->finix_id;
        $card=payment_ways::makeCard(
            $request->exp_month,$request->exp_year,$buyerId,$request->name,$request->card_number,$request->cvv,
            $user_id,
            $apiUser_id,
            $apiKeyID
        );
        if(!$card["worked"]){
            session()->flash('success', 'unable to make card object '.$card["responce"]);
            return redirect()->back();
        }
        $cardId=$card["ref"]->finix_id;
        $hold=Authorization::makeHold(
            $request->merchant,$request->currency,$request->amount_in_cents,$cardId,
            $user_id,
            $apiUser_id,
            $apiKeyID
        );
        if(!$hold["worked"]){
            session()->flash('success', 'unable to make hold '.$hold["responce"]);
            return redirect()->back();
        }
        session()->flash('success', json_encode($hold["responce"]));
        return redirect()->back();
    }
    public function makeReturnLive(Request $request){
        $payment=finix_payments_live::where('id',$request->id)->first();
        $user_id=Auth::id();
        $apiUser_id=ApiUser::where("user_id",$user_id)->select("id")->first()->id;
        $apiKeyID=ApiKey::where('live',1)->where('merchant_id',$payment->merchant)->first();
        $apiKeyID=($apiKeyID!=null)?$apiKeyID->id:0;
        return json_encode(finix_payments_live::makeRefund($payment->finix_id,$request->amount,$apiUser_id,$apiKeyID));
    }
    public function captureHoldLive(Request $request){
        $payment=Authorization_live::where('id',$request->id)->first();
        $user_id=Auth::id();
        $apiUser_id=ApiUser::where("user_id",$user_id)->select("id")->first()->id;
        return json_encode(Authorization_live::makeCapture($payment->finix_id,$request->amount,$apiUser_id));
    }
    public function returnHoldLive(Request $request){
        $payment=Authorization_live::where('id',$request->id)->first();
        $user_id=Auth::id();
        $apiUser_id=ApiUser::where("user_id",$user_id)->select("id")->first()->id;
        return json_encode(Authorization_live::voidCapture($payment->finix_id,$apiUser_id));
    }
    public function checkoutLive(Request $request){
        $user_id=Auth::id();
        $apiUser_id=ApiUser::where("user_id",$user_id)->select("id")->first()->id;
        $apiKeyID=ApiKey::where('live',1)->where("merchant_id",$request->merchant)->select("id")->first();
        $apiKeyID=($apiKeyID!=null)?$apiKeyID->id:0;
        $buyerIdentity=identities_live::makeBuyerIdentity($request->email,
        $user_id,
        $apiUser_id,
        $apiKeyID
    );
        if(!$buyerIdentity["worked"]){
            session()->flash('success', 'unable to make buyer identity '.$buyerIdentity["responce"]);
            return redirect()->back();
        }
        $checkout=finix_checkout_forms_live::makeCheckout(
            $request->amount_details_amount_type,
            $request->amount_details_total_amount,
            $request->amount_details_currency,
            null,null,
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
            $request->merchant,
            false,
            [$request->allowed_payment_methods_0],
            $request->nickname,
            ["primary_image_url" =>  $request->items_0_image_details_primary_image_url,
            "alternative_image_urls_0" => $request->items_0_image_details_alternative_image_urls_0,
            "alternative_image_urls_1" => $request->items_0_image_details_alternative_image_urls_1],
            $request->description,
            ["sale_amount" => $request->items_0_price_details_sale_amount,
            "currency" => $request->items_0_price_details_currency,
             "price_type" => $request->items_0_price_details_price_type,
            "regular_amount" => $request->items_0_price_details_regular_amount],
            1,$buyerIdentity, $user_id,
            $apiUser_id,
            $apiKeyID
        );
        if(!$checkout["worked"]){
            session()->flash('success', 'unable to make checkout '.$checkout["responce"]);
            return redirect()->back();
        }
        session()->flash('success', 'checkout made '.$checkout["responce"]);
         return redirect()->back();
    }
    public function paylinkLive(Request $request){
        $user_id=Auth::id();
        $apiUser_id=ApiUser::where("user_id",$user_id)->select("id")->first()->id;
        $apiKeyID=ApiKey::where('live',1)->where("merchant_id",$request->merchant)->select("id")->first();
        $apiKeyID=($apiKeyID!=null)?$apiKeyID->id:0;
        $buyerIdentity=identities_live::makeBuyerIdentity($request->email,
        $user_id,
        $apiUser_id,
        $apiKeyID
    );
        if(!$buyerIdentity["worked"]){
            session()->flash('success', 'unable to make buyer identity '.$buyerIdentity["responce"]);
            return redirect()->back();
        }
        $paymentLink=finix_payment_links_live::makePaymentLink(
            $request->amount_details_amount_type,
            $request->amount_details_total_amount,
            $request->amount_details_currency,
            null,null,
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
            $request->merchant,
            false,
            [$request->allowed_payment_methods_0],
            $request->nickname,
            ["primary_image_url" =>  $request->items_0_image_details_primary_image_url,
            "alternative_image_urls_0" => $request->items_0_image_details_alternative_image_urls_0,
            "alternative_image_urls_1" => $request->items_0_image_details_alternative_image_urls_1],
            $request->description,
            ["sale_amount" => $request->items_0_price_details_sale_amount,
            "currency" => $request->items_0_price_details_currency,
             "price_type" => $request->items_0_price_details_price_type,
            "regular_amount" => $request->items_0_price_details_regular_amount],
            1,$buyerIdentity, $user_id,
            $apiUser_id,
            $apiKeyID
        );
        if(!$paymentLink["worked"]){
            session()->flash('success', 'unable to make payment link '.$paymentLink["responce"]);
            return redirect()->back();
        }
        session()->flash('success', 'payment link made '.$paymentLink["responce"]);
         return redirect()->back();
    //     return merchantsController::createPaymentLinkMinReq(config("app.api_username"),config("app.api_password"),
    //     $request->merchant,
    //     "ONE_TIME",
    //     $request->allowed_payment_methods_0,
    //     $request->nickname,
    //     ["primary_image_url" =>  $request->items_0_image_details_primary_image_url,
    //     "alternative_image_urls_0" => $request->items_0_image_details_alternative_image_urls_0,
    //     "alternative_image_urls_1" => $request->items_0_image_details_alternative_image_urls_1],
    //     $request->description,
    //     ["sale_amount" => $request->items_0_price_details_sale_amount,
    //     "currency" => $request->items_0_price_details_currency,
    //      "price_type" => $request->items_0_price_details_price_type,
    //     "regular_amount" => $request->items_0_price_details_regular_amount],
    //     1,
    //     $request->amount_details_amount_type,
    //     $request->amount_details_total_amount,
    //     $request->amount_details_currency,
    //     $request->amount_details_amount_breakdown_subtotal_amount,
    //     $request->amount_details_amount_breakdown_shipping_amount,
    //     $request->amount_details_amount_breakdown_estimated_tax_amount,
    //     $request->amount_details_amount_breakdown_discount_amount,
    //     $request->amount_details_amount_breakdown_tip_amount,
    //     $request->branding_brand_color,
    //   $request->branding_accent_color,
    //   $request->branding_logo,
    //   $request->branding_icon,
    //   $request->additional_details_collect_name??'false',
    //   $request->additional_details_collect_email??'false',
    //   $request->additional_details_collect_phone_number??'false',
    //   $request->additional_details_collect_billing_address??'false',
    //   $request->additional_details_collect_shipping_address??'false',
    //   $request->additional_details_success_return_url,
    //   $request->additional_details_cart_return_url,
    //   $request->additional_details_expired_session_url,
    //   $request->additional_details_terms_of_service_url,
    //   $request->additional_details_expiration_in_minutes
    //     )[0];//formController::createCheckoutForm(config("app.api_username"),config("app.api_password"),$request->id,true)[0];
    }
    public function signupLive(Request $request){
        $user_id=Auth::id();
        $apiUser_id=ApiUser::where("user_id",$user_id)->select("id")->first()->id;
        $merchantIdentity=identities_live::makeMerchantIdentity( $request->entity_annual_card_volume,
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
        $request->entity_url,
        $user_id,
        $apiUser_id
    );
        if(!$merchantIdentity["worked"]){
            session()->flash('success', 'unable to make merchant identity '.$merchantIdentity["responce"]);
            return redirect()->back();
        }
        $identity=$merchantIdentity["ref"]->finix_id;

        $bank=payment_ways_live::makeBank(
            $request->bank_account_number,
            $request->bank_account_type,
            $request->bank_bank_code,
            $identity,
            $request->bank_name,
            $request->bank_type,
            $user_id,
            $apiUser_id
        );
        if(!$bank["worked"]){
            session()->flash('success', 'unable to make bank '.$bank["responce"]);
            return redirect()->back();
        }
        $merchant=Finix_Merchant_live::makeMerchant($identity,
        $user_id,
        $apiUser_id
    );
    if(!$merchant["worked"]){
        session()->flash('success', 'unable to make merchant '.$merchant["responce"]);
        return redirect()->back();
    }
        if(!Auth::user()->hasID){
            $awaiting=awaiting_users_live::create([
                'identity'=>$identity,
                'user_id'=>Auth::id()
            ]);
            $awaiting->save();
            $awaiting->refresh();
            session()->flash('success', 'working on it please wait for the merchant to verify... check back later');
        }
        $browser = new Browser();
        $awaiting=awaiting_PCI_live::create([
            'name'=>$request->entity_first_name." ".$request->entity_last_name,
            'ip'=>$this->getIp(),
            'user_id'=>Auth::id(),
            'merchant_id'=>$merchant["ref"]->finix_id,
            'pci_title'=>$request->PCI_title,
            'browser'=>$browser->getUserAgent()
        ]);
        $awaiting->save();
        $awaiting->refresh();
        session()->flash('success', 'working on it please wait for the merchant to verify... check back later');
        return redirect()->back();
    }
    public function getIp(){
        foreach (array('HTTP_CLIENT_IP', 'HTTP_X_FORWARDED_FOR', 'HTTP_X_FORWARDED', 'HTTP_X_CLUSTER_CLIENT_IP', 'HTTP_FORWARDED_FOR', 'HTTP_FORWARDED', 'REMOTE_ADDR') as $key){
            if (array_key_exists($key, $_SERVER) === true){
                foreach (explode(',', $_SERVER[$key]) as $ip){
                    $ip = trim($ip); // just to be safe
                    if (filter_var($ip, FILTER_VALIDATE_IP, FILTER_FLAG_NO_PRIV_RANGE | FILTER_FLAG_NO_RES_RANGE) !== false){
                        return $ip;
                    }
                }
            }
        }
        return request()->ip(); // it will return the server IP if the client IP is not found using this method.
    }
    function loadUserSession(){
        $apiUser=ApiUser::where('user_id',Auth::id())->first();
        Session::put('api_username',$apiUser->username);
        Session::put('api_password',$apiUser->password);
        Session::put('api_username_live',$apiUser->username_live);
        Session::put('api_password_live',$apiUser->password_live);
    }
    public function identities(){
        $title=ucwords('identities');
        $array['data']=identities::accessible()->get()->toArray();
        $array['next_page_url']=isset($array['next_page_url'])?$array['next_page_url']:null;
        $array['prev_page_url']=isset($array['prev_page_url'])?$array['prev_page_url']:null;
        $array['data']=isset($array['data'])?$array['data']:null;
        return view("frontend.pages.portal.jsonViewer",["json"=>str_replace(['\\','`'],['\\\\','｀'],json_encode((object)[$array['data']], JSON_PRETTY_PRINT)),'next'=>$array['next_page_url'],'prev'=>$array['prev_page_url'],'title'=>$title]);
    }
    public function apiusers(){
        $title=ucwords('apiusers');
        $array['data']=ApiUser::accessible()->get()->toArray();
        $array['next_page_url']=isset($array['next_page_url'])?$array['next_page_url']:null;
        $array['prev_page_url']=isset($array['prev_page_url'])?$array['prev_page_url']:null;
        $array['data']=isset($array['data'])?$array['data']:null;
        return view("frontend.pages.portal.jsonViewer",["json"=>str_replace(['\\','`'],['\\\\','｀'],json_encode((object)[$array['data']], JSON_PRETTY_PRINT)),'next'=>$array['next_page_url'],'prev'=>$array['prev_page_url'],'title'=>$title]);
    }
    public function fee_profiles(){
        $title=ucwords('fee profiles');
        $array['data']=finix_fee_profiles::accessible()->get()->toArray();
        $array['next_page_url']=isset($array['next_page_url'])?$array['next_page_url']:null;
        $array['prev_page_url']=isset($array['prev_page_url'])?$array['prev_page_url']:null;
        $array['data']=isset($array['data'])?$array['data']:null;
        return view("frontend.pages.portal.jsonViewer",["json"=>str_replace(['\\','`'],['\\\\','｀'],json_encode((object)[$array['data']], JSON_PRETTY_PRINT)),'next'=>$array['next_page_url'],'prev'=>$array['prev_page_url'],'title'=>$title]);
    }
    public function fee_profile($id){
        $title=ucwords('fee profile');
        $array['data']=finix_fee_profiles::where('id',$id)->accessible()->get()->toArray();
        $array['next_page_url']=isset($array['next_page_url'])?$array['next_page_url']:null;
        $array['prev_page_url']=isset($array['prev_page_url'])?$array['prev_page_url']:null;
        $array['data']=isset($array['data'])?$array['data']:null;
        return view("frontend.pages.portal.jsonViewer",["json"=>str_replace(['\\','`'],['\\\\','｀'],json_encode((object)[$array['data']], JSON_PRETTY_PRINT)),'next'=>$array['next_page_url'],'prev'=>$array['prev_page_url'],'title'=>$title]);
    }
    public function settlements(){
        $title=ucwords('settlements');
        $array['data']=settlements::accessible()->get()->toArray();
        $array['next_page_url']=isset($array['next_page_url'])?$array['next_page_url']:null;
        $array['prev_page_url']=isset($array['prev_page_url'])?$array['prev_page_url']:null;
        $array['data']=isset($array['data'])?$array['data']:null;
        return view("frontend.pages.portal.jsonViewer",["json"=>str_replace(['\\','`'],['\\\\','｀'],json_encode((object)[$array['data']], JSON_PRETTY_PRINT)),'next'=>$array['next_page_url'],'prev'=>$array['prev_page_url'],'title'=>$title]);
    }
    public function settlement($id){
        $title=ucwords('settlement');
        $array['data']=settlements::where('id',$id)->accessible()->get()->toArray();
        $array['next_page_url']=isset($array['next_page_url'])?$array['next_page_url']:null;
        $array['prev_page_url']=isset($array['prev_page_url'])?$array['prev_page_url']:null;
        $array['data']=isset($array['data'])?$array['data']:null;
        return view("frontend.pages.portal.jsonViewer",["json"=>str_replace(['\\','`'],['\\\\','｀'],json_encode((object)[$array['data']], JSON_PRETTY_PRINT)),'next'=>$array['next_page_url'],'prev'=>$array['prev_page_url'],'title'=>$title]);
    }
    public function identity($id){
        $title=ucwords('identity');
        $array['data']=identities::where('id',$id)->accessible()->get()->toArray();
        $array['next_page_url']=isset($array['next_page_url'])?$array['next_page_url']:null;
        $array['prev_page_url']=isset($array['prev_page_url'])?$array['prev_page_url']:null;
        $array['data']=isset($array['data'])?$array['data']:null;
        return view("frontend.pages.portal.jsonViewer",["json"=>str_replace(['\\','`'],['\\\\','｀'],json_encode((object)[$array['data']], JSON_PRETTY_PRINT)),'next'=>$array['next_page_url'],'prev'=>$array['prev_page_url'],'title'=>$title]);
    }
    public function payments(){
        $title=ucwords('payments');
        // dd( request()->header('User-Agent'));
        $array['data']=finix_payments::accessible()->get()->toArray();
        $array['next_page_url']=isset($array['next_page_url'])?$array['next_page_url']:null;
        $array['prev_page_url']=isset($array['prev_page_url'])?$array['prev_page_url']:null;
        $array['data']=isset($array['data'])?$array['data']:null;
        return view("frontend.pages.portal.paymentsViewer",["json"=>str_replace(['\\','`'],['\\\\','｀'],json_encode((object)[$array['data']], JSON_PRETTY_PRINT)),'next'=>$array['next_page_url'],'prev'=>$array['prev_page_url'],'title'=>$title]);
    }
    public function payment($id){
        $title=ucwords('payment');
        $array['data']=finix_payments::where('id',$id)->accessible()->get()->toArray();
        $array['next_page_url']=isset($array['next_page_url'])?$array['next_page_url']:null;
        $array['prev_page_url']=isset($array['prev_page_url'])?$array['prev_page_url']:null;
        $array['data']=isset($array['data'])?$array['data']:null;
        return view("frontend.pages.portal.paymentsViewer",["json"=>str_replace(['\\','`'],['\\\\','｀'],json_encode((object)[$array['data']], JSON_PRETTY_PRINT)),'next'=>$array['next_page_url'],'prev'=>$array['prev_page_url'],'title'=>$title]);
    }
    public function payment_instraments(){
        $title=ucwords('payment instraments');
        $array['data']=payment_ways::accessible()->get()->toArray();
        $array['next_page_url']=isset($array['next_page_url'])?$array['next_page_url']:null;
        $array['prev_page_url']=isset($array['prev_page_url'])?$array['prev_page_url']:null;
        $array['data']=isset($array['data'])?$array['data']:null;
        return view("frontend.pages.portal.jsonViewer",["json"=>str_replace(['\\','`'],['\\\\','｀'],json_encode((object)[$array['data']], JSON_PRETTY_PRINT)),'next'=>$array['next_page_url'],'prev'=>$array['prev_page_url'],'title'=>$title]);
    }
    public function payment_instrament($id){
        $title=ucwords('payment instrament');
        $array['data']=payment_ways::where('id',$id)->accessible()->get()->toArray();
        $array['next_page_url']=isset($array['next_page_url'])?$array['next_page_url']:null;
        $array['prev_page_url']=isset($array['prev_page_url'])?$array['prev_page_url']:null;
        $array['data']=isset($array['data'])?$array['data']:null;
        return view("frontend.pages.portal.jsonViewer",["json"=>str_replace(['\\','`'],['\\\\','｀'],json_encode((object)[$array['data']], JSON_PRETTY_PRINT)),'next'=>$array['next_page_url'],'prev'=>$array['prev_page_url'],'title'=>$title]);
    }
    public function merchants(){
        $title=ucwords('merchants');
        $array['data']=Finix_Merchant::accessible()->get()->toArray();
        $array['next_page_url']=isset($array['next_page_url'])?$array['next_page_url']:null;
        $array['prev_page_url']=isset($array['prev_page_url'])?$array['prev_page_url']:null;
        $array['data']=isset($array['data'])?$array['data']:null;
        return view("frontend.pages.portal.jsonViewer",["json"=>str_replace(['\\','`'],['\\\\','｀'],json_encode((object)[$array['data']], JSON_PRETTY_PRINT)),'next'=>$array['next_page_url'],'prev'=>$array['prev_page_url'],'title'=>$title]);
    }
    public function merchant($id){
        $title=ucwords('merchant');
        $array['data']=Finix_Merchant::where('id',$id)->accessible()->get()->toArray();
        $array['next_page_url']=isset($array['next_page_url'])?$array['next_page_url']:null;
        $array['prev_page_url']=isset($array['prev_page_url'])?$array['prev_page_url']:null;
        $array['data']=isset($array['data'])?$array['data']:null;
        return view("frontend.pages.portal.jsonViewer",["json"=>str_replace(['\\','`'],['\\\\','｀'],json_encode((object)[$array['data']], JSON_PRETTY_PRINT)),'next'=>$array['next_page_url'],'prev'=>$array['prev_page_url'],'title'=>$title]);
    }
    public function identities_live(){
        $title=ucwords('identities live');
        $array['data']=identities_live::accessible()->get()->toArray();
        $array['next_page_url']=isset($array['next_page_url'])?$array['next_page_url']:null;
        $array['prev_page_url']=isset($array['prev_page_url'])?$array['prev_page_url']:null;
        $array['data']=isset($array['data'])?$array['data']:null;
        return view("frontend.pages.portal.jsonViewer",["json"=>str_replace(['\\','`'],['\\\\','｀'],json_encode((object)[$array['data']], JSON_PRETTY_PRINT)),'next'=>$array['next_page_url'],'prev'=>$array['prev_page_url'],'title'=>$title]);
    }
    public function apiusers_live(){
        $title=ucwords('apiusers live');
        $array['data']=Authorization::accessible()->get()->toArray();
        $array['next_page_url']=isset($array['next_page_url'])?$array['next_page_url']:null;
        $array['prev_page_url']=isset($array['prev_page_url'])?$array['prev_page_url']:null;
        $array['data']=isset($array['data'])?$array['data']:null;
        return view("frontend.pages.portal.jsonViewer",["json"=>str_replace(['\\','`'],['\\\\','｀'],json_encode((object)[$array['data']], JSON_PRETTY_PRINT)),'next'=>$array['next_page_url'],'prev'=>$array['prev_page_url'],'title'=>$title]);
    }
    public function apiuser_live($id){
        $title=ucwords('apiuser live');
        $array['data']=identities_live::where('id',$id)->accessible()->get()->toArray();
        $array['next_page_url']=isset($array['next_page_url'])?$array['next_page_url']:null;
        $array['prev_page_url']=isset($array['prev_page_url'])?$array['prev_page_url']:null;
        $array['data']=isset($array['data'])?$array['data']:null;
        return view("frontend.pages.portal.jsonViewer",["json"=>str_replace(['\\','`'],['\\\\','｀'],json_encode((object)[$array['data']], JSON_PRETTY_PRINT)),'next'=>$array['next_page_url'],'prev'=>$array['prev_page_url'],'title'=>$title]);
    }
    public function identity_live($id){
        $title=ucwords('identity live');
        $array['data']=identities_live::where('id',$id)->accessible()->get()->toArray();
        $array['next_page_url']=isset($array['next_page_url'])?$array['next_page_url']:null;
        $array['prev_page_url']=isset($array['prev_page_url'])?$array['prev_page_url']:null;
        $array['data']=isset($array['data'])?$array['data']:null;
        return view("frontend.pages.portal.jsonViewer",["json"=>str_replace(['\\','`'],['\\\\','｀'],json_encode((object)[$array['data']], JSON_PRETTY_PRINT)),'next'=>$array['next_page_url'],'prev'=>$array['prev_page_url'],'title'=>$title]);
    }
    public function payments_live(){
        $title=ucwords('payments live');
        $array['data']=finix_payments_live::accessible()->get()->toArray();
        $array['next_page_url']=isset($array['next_page_url'])?$array['next_page_url']:null;
        $array['prev_page_url']=isset($array['prev_page_url'])?$array['prev_page_url']:null;
        $array['data']=isset($array['data'])?$array['data']:null;
        return view("frontend.pages.portal.paymentsViewerLive",["json"=>str_replace(['\\','`'],['\\\\','｀'],json_encode((object)[$array['data']], JSON_PRETTY_PRINT)),'next'=>$array['next_page_url'],'prev'=>$array['prev_page_url'],'title'=>$title]);
    }
    public function payment_live($id){
        $title=ucwords('payment live');
        $array['data']=finix_payments_live::where('id',$id)->accessible()->get()->toArray();
        $array['next_page_url']=isset($array['next_page_url'])?$array['next_page_url']:null;
        $array['prev_page_url']=isset($array['prev_page_url'])?$array['prev_page_url']:null;
        $array['data']=isset($array['data'])?$array['data']:null;
        return view("frontend.pages.portal.paymentsViewerLive",["json"=>str_replace(['\\','`'],['\\\\','｀'],json_encode((object)[$array['data']], JSON_PRETTY_PRINT)),'next'=>$array['next_page_url'],'prev'=>$array['prev_page_url'],'title'=>$title]);
    }
    public function payment_instraments_live(){
        $title=ucwords('payment instraments live');
        $array['data']=payment_ways_live::accessible()->get()->toArray();
        $array['next_page_url']=isset($array['next_page_url'])?$array['next_page_url']:null;
        $array['prev_page_url']=isset($array['prev_page_url'])?$array['prev_page_url']:null;
        $array['data']=isset($array['data'])?$array['data']:null;
        return view("frontend.pages.portal.jsonViewer",["json"=>str_replace(['\\','`'],['\\\\','｀'],json_encode((object)[$array['data']], JSON_PRETTY_PRINT)),'next'=>$array['next_page_url'],'prev'=>$array['prev_page_url'],'title'=>$title]);
    }
    public function payment_instrament_live($id){
        $title=ucwords('payment instrament live');
        $array['data']=payment_ways_live::where('id',$id)->accessible()->get()->toArray();
        $array['next_page_url']=isset($array['next_page_url'])?$array['next_page_url']:null;
        $array['prev_page_url']=isset($array['prev_page_url'])?$array['prev_page_url']:null;
        $array['data']=isset($array['data'])?$array['data']:null;
        return view("frontend.pages.portal.jsonViewer",["json"=>str_replace(['\\','`'],['\\\\','｀'],json_encode((object)[$array['data']], JSON_PRETTY_PRINT)),'next'=>$array['next_page_url'],'prev'=>$array['prev_page_url'],'title'=>$title]);
    }
    public function merchants_live(){
        $title=ucwords('merchants live');
        $array['data']=Finix_Merchant_live::accessible()->get()->toArray();
        $array['next_page_url']=isset($array['next_page_url'])?$array['next_page_url']:null;
        $array['prev_page_url']=isset($array['prev_page_url'])?$array['prev_page_url']:null;
        $array['data']=isset($array['data'])?$array['data']:null;
        return view("frontend.pages.portal.jsonViewer",["json"=>str_replace(['\\','`'],['\\\\','｀'],json_encode((object)[$array['data']], JSON_PRETTY_PRINT)),'next'=>$array['next_page_url'],'prev'=>$array['prev_page_url'],'title'=>$title]);
    }
    public function merchant_live($id){
        $title=ucwords('merchant live');
        $array['data']=Finix_Merchant_live::where('id',$id)->accessible()->get()->toArray();
        $array['next_page_url']=isset($array['next_page_url'])?$array['next_page_url']:null;
        $array['prev_page_url']=isset($array['prev_page_url'])?$array['prev_page_url']:null;
        $array['data']=isset($array['data'])?$array['data']:null;
        return view("frontend.pages.portal.jsonViewer",["json"=>str_replace(['\\','`'],['\\\\','｀'],json_encode((object)[$array['data']], JSON_PRETTY_PRINT)),'next'=>$array['next_page_url'],'prev'=>$array['prev_page_url'],'title'=>$title]);
    }
    public function settlements_live(){
        $title=ucwords('settlements live');
        $array['data']=settlements_live::accessible()->get()->toArray();
        $array['next_page_url']=isset($array['next_page_url'])?$array['next_page_url']:null;
        $array['prev_page_url']=isset($array['prev_page_url'])?$array['prev_page_url']:null;
        $array['data']=isset($array['data'])?$array['data']:null;
        return view("frontend.pages.portal.jsonViewer",["json"=>str_replace(['\\','`'],['\\\\','｀'],json_encode((object)[$array['data']], JSON_PRETTY_PRINT)),'next'=>$array['next_page_url'],'prev'=>$array['prev_page_url'],'title'=>$title]);
    }
    public function settlement_live($id){
        $title=ucwords('settlement live');
        $array['data']=settlements_live::where('id',$id)->accessible()->get()->toArray();
        $array['next_page_url']=isset($array['next_page_url'])?$array['next_page_url']:null;
        $array['prev_page_url']=isset($array['prev_page_url'])?$array['prev_page_url']:null;
        $array['data']=isset($array['data'])?$array['data']:null;
        return view("frontend.pages.portal.jsonViewer",["json"=>str_replace(['\\','`'],['\\\\','｀'],json_encode((object)[$array['data']], JSON_PRETTY_PRINT)),'next'=>$array['next_page_url'],'prev'=>$array['prev_page_url'],'title'=>$title]);
    }
    public function fee_profiles_live(){
        $title=ucwords('fee profiles live');
        $array['data']=finix_fee_profiles_live::accessible()->get()->toArray();
        $array['next_page_url']=isset($array['next_page_url'])?$array['next_page_url']:null;
        $array['prev_page_url']=isset($array['prev_page_url'])?$array['prev_page_url']:null;
        $array['data']=isset($array['data'])?$array['data']:null;
        return view("frontend.pages.portal.jsonViewer",["json"=>str_replace(['\\','`'],['\\\\','｀'],json_encode((object)[$array['data']], JSON_PRETTY_PRINT)),'next'=>$array['next_page_url'],'prev'=>$array['prev_page_url'],'title'=>$title]);
    }
    public function fee_profile_live($id){
        $title=ucwords('fee profile live');
        $array['data']=finix_fee_profiles_live::where('id',$id)->accessible()->get()->toArray();
        $array['next_page_url']=isset($array['next_page_url'])?$array['next_page_url']:null;
        $array['prev_page_url']=isset($array['prev_page_url'])?$array['prev_page_url']:null;
        $array['data']=isset($array['data'])?$array['data']:null;
        return view("frontend.pages.portal.jsonViewer",["json"=>str_replace(['\\','`'],['\\\\','｀'],json_encode((object)[$array['data']], JSON_PRETTY_PRINT)),'next'=>$array['next_page_url'],'prev'=>$array['prev_page_url'],'title'=>$title]);
    }
    public function disputes(){
        $title=ucwords('disputes');
        $array['data']=Finix_Disputes::accessible()->get()->toArray();
        $array['next_page_url']=isset($array['next_page_url'])?$array['next_page_url']:null;
        $array['prev_page_url']=isset($array['prev_page_url'])?$array['prev_page_url']:null;
        $array['data']=isset($array['data'])?$array['data']:null;
        return view("frontend.pages.portal.jsonViewer",["json"=>str_replace(['\\','`'],['\\\\','｀'],json_encode((object)[$array['data']], JSON_PRETTY_PRINT)),'next'=>$array['next_page_url'],'prev'=>$array['prev_page_url'],'title'=>$title]);
    }
    public function dispute($id){
        $title=ucwords('dispute');
        $array['data']=Finix_Disputes::where('id',$id)->accessible()->get()->toArray();
        $array['next_page_url']=isset($array['next_page_url'])?$array['next_page_url']:null;
        $array['prev_page_url']=isset($array['prev_page_url'])?$array['prev_page_url']:null;
        $array['data']=isset($array['data'])?$array['data']:null;
        return view("frontend.pages.portal.jsonViewer",["json"=>str_replace(['\\','`'],['\\\\','｀'],json_encode((object)[$array['data']], JSON_PRETTY_PRINT)),'next'=>$array['next_page_url'],'prev'=>$array['prev_page_url'],'title'=>$title]);
    }
    public function disputes_live(){
        $title=ucwords('disputes live');
        $array['data']=Finix_Disputes_live::accessible()->get()->toArray();
        $array['next_page_url']=isset($array['next_page_url'])?$array['next_page_url']:null;
        $array['prev_page_url']=isset($array['prev_page_url'])?$array['prev_page_url']:null;
        $array['data']=isset($array['data'])?$array['data']:null;
        return view("frontend.pages.portal.jsonViewer",["json"=>str_replace(['\\','`'],['\\\\','｀'],json_encode((object)[$array['data']], JSON_PRETTY_PRINT)),'next'=>$array['next_page_url'],'prev'=>$array['prev_page_url'],'title'=>$title]);
    }
    public function dispute_live($id){
        $title=ucwords('dispute live');
        $array['data']=Finix_Disputes_live::where('id',$id)->accessible()->get()->toArray();
        $array['next_page_url']=isset($array['next_page_url'])?$array['next_page_url']:null;
        $array['prev_page_url']=isset($array['prev_page_url'])?$array['prev_page_url']:null;
        $array['data']=isset($array['data'])?$array['data']:null;
        return view("frontend.pages.portal.jsonViewer",["json"=>str_replace(['\\','`'],['\\\\','｀'],json_encode((object)[$array['data']], JSON_PRETTY_PRINT)),'next'=>$array['next_page_url'],'prev'=>$array['prev_page_url'],'title'=>$title]);
    }
    public function compliances(){
        $title=ucwords('compliances');
        $array['data']=pci_forms::accessible()->get()->toArray();
        $array['next_page_url']=isset($array['next_page_url'])?$array['next_page_url']:null;
        $array['prev_page_url']=isset($array['prev_page_url'])?$array['prev_page_url']:null;
        $array['data']=isset($array['data'])?$array['data']:null;
        return view("frontend.pages.portal.jsonViewer",["json"=>str_replace(['\\','`'],['\\\\','｀'],json_encode((object)[$array['data']], JSON_PRETTY_PRINT)),'next'=>$array['next_page_url'],'prev'=>$array['prev_page_url'],'title'=>$title]);
    }
    public function compliance($id){
        $title=ucwords('compliance');
        $array['data']=pci_forms::where('id',$id)->accessible()->get()->toArray();
        $array['next_page_url']=isset($array['next_page_url'])?$array['next_page_url']:null;
        $array['prev_page_url']=isset($array['prev_page_url'])?$array['prev_page_url']:null;
        $array['data']=isset($array['data'])?$array['data']:null;
        return view("frontend.pages.portal.jsonViewer",["json"=>str_replace(['\\','`'],['\\\\','｀'],json_encode((object)[$array['data']], JSON_PRETTY_PRINT)),'next'=>$array['next_page_url'],'prev'=>$array['prev_page_url'],'title'=>$title]);
    }
    public function compliances_live(){
        $title=ucwords('compliances live');
        $array['data']=pci_forms_live::accessible()->get()->toArray();
        $array['next_page_url']=isset($array['next_page_url'])?$array['next_page_url']:null;
        $array['prev_page_url']=isset($array['prev_page_url'])?$array['prev_page_url']:null;
        $array['data']=isset($array['data'])?$array['data']:null;
        return view("frontend.pages.portal.jsonViewer",["json"=>str_replace(['\\','`'],['\\\\','｀'],json_encode((object)[$array['data']], JSON_PRETTY_PRINT)),'next'=>$array['next_page_url'],'prev'=>$array['prev_page_url'],'title'=>$title]);
    }
    public function compliance_live($id){
        $title=ucwords('compliance live');
        $array['data']=pci_forms_live::where('id',$id)->accessible()->get()->toArray();
        $array['next_page_url']=isset($array['next_page_url'])?$array['next_page_url']:null;
        $array['prev_page_url']=isset($array['prev_page_url'])?$array['prev_page_url']:null;
        $array['data']=isset($array['data'])?$array['data']:null;
        return view("frontend.pages.portal.jsonViewer",["json"=>str_replace(['\\','`'],['\\\\','｀'],json_encode((object)[$array['data']], JSON_PRETTY_PRINT)),'next'=>$array['next_page_url'],'prev'=>$array['prev_page_url'],'title'=>$title]);
    }
    public function holds(){
        $title=ucwords('holds');
        $array['data']=Authorization::accessible()->get()->toArray();
        $array['next_page_url']=isset($array['next_page_url'])?$array['next_page_url']:null;
        $array['prev_page_url']=isset($array['prev_page_url'])?$array['prev_page_url']:null;
        $array['data']=isset($array['data'])?$array['data']:null;
        return view("frontend.pages.portal.holdsViewer",["json"=>str_replace(['\\','`'],['\\\\','｀'],json_encode((object)[$array['data']], JSON_PRETTY_PRINT)),'next'=>$array['next_page_url'],'prev'=>$array['prev_page_url'],'title'=>$title]);
    }
    public function hold($id){
        $title=ucwords('hold');
        $array['data']=Authorization::where('id',$id)->accessible()->get()->toArray();
        $array['next_page_url']=isset($array['next_page_url'])?$array['next_page_url']:null;
        $array['prev_page_url']=isset($array['prev_page_url'])?$array['prev_page_url']:null;
        $array['data']=isset($array['data'])?$array['data']:null;
        return view("frontend.pages.portal.holdsViewer",["json"=>str_replace(['\\','`'],['\\\\','｀'],json_encode((object)[$array['data']], JSON_PRETTY_PRINT)),'next'=>$array['next_page_url'],'prev'=>$array['prev_page_url'],'title'=>$title]);
    }
    public function holds_live(){
        $title=ucwords('holds live');
        $array['data']=Authorization_live::accessible()->get()->toArray();
        $array['next_page_url']=isset($array['next_page_url'])?$array['next_page_url']:null;
        $array['prev_page_url']=isset($array['prev_page_url'])?$array['prev_page_url']:null;
        $array['data']=isset($array['data'])?$array['data']:null;
        return view("frontend.pages.portal.holdsViewerLive",["json"=>str_replace(['\\','`'],['\\\\','｀'],json_encode((object)[$array['data']], JSON_PRETTY_PRINT)),'next'=>$array['next_page_url'],'prev'=>$array['prev_page_url'],'title'=>$title]);
    }
    public function hold_live($id){
        $title=ucwords('hold live');
        $array['data']=Authorization_live::where('id',$id)->accessible()->get()->toArray();
        $array['next_page_url']=isset($array['next_page_url'])?$array['next_page_url']:null;
        $array['prev_page_url']=isset($array['prev_page_url'])?$array['prev_page_url']:null;
        $array['data']=isset($array['data'])?$array['data']:null;
        return view("frontend.pages.portal.holdsViewerLive",["json"=>str_replace(['\\','`'],['\\\\','｀'],json_encode((object)[$array['data']], JSON_PRETTY_PRINT)),'next'=>$array['next_page_url'],'prev'=>$array['prev_page_url'],'title'=>$title]);
    }
    public function checkouts(){
        $title=ucwords('checkouts');
        $array['data']=finix_checkout_forms::accessible()->get()->toArray();
        $array['next_page_url']=isset($array['next_page_url'])?$array['next_page_url']:null;
        $array['prev_page_url']=isset($array['prev_page_url'])?$array['prev_page_url']:null;
        $array['data']=isset($array['data'])?$array['data']:null;
        return view("frontend.pages.portal.jsonViewer",["json"=>str_replace(['\\','`'],['\\\\','｀'],json_encode((object)[$array['data']], JSON_PRETTY_PRINT)),'next'=>$array['next_page_url'],'prev'=>$array['prev_page_url'],'title'=>$title]);
    }
    public function checkout($id){
        $title=ucwords('checkout');
        $array['data']=finix_checkout_forms::where('id',$id)->accessible()->get()->toArray();
        $array['next_page_url']=isset($array['next_page_url'])?$array['next_page_url']:null;
        $array['prev_page_url']=isset($array['prev_page_url'])?$array['prev_page_url']:null;
        $array['data']=isset($array['data'])?$array['data']:null;
        return view("frontend.pages.portal.jsonViewer",["json"=>str_replace(['\\','`'],['\\\\','｀'],json_encode((object)[$array['data']], JSON_PRETTY_PRINT)),'next'=>$array['next_page_url'],'prev'=>$array['prev_page_url'],'title'=>$title]);
    }
    public function checkouts_live(){
        $title=ucwords('checkouts live');
        $array['data']=finix_checkout_forms_live::accessible()->get()->toArray();
        $array['next_page_url']=isset($array['next_page_url'])?$array['next_page_url']:null;
        $array['prev_page_url']=isset($array['prev_page_url'])?$array['prev_page_url']:null;
        $array['data']=isset($array['data'])?$array['data']:null;
        return view("frontend.pages.portal.jsonViewer",["json"=>str_replace(['\\','`'],['\\\\','｀'],json_encode((object)[$array['data']], JSON_PRETTY_PRINT)),'next'=>$array['next_page_url'],'prev'=>$array['prev_page_url'],'title'=>$title]);
    }
    public function checkout_live($id){
        $title=ucwords('checkout live');
        $array['data']=finix_checkout_forms_live::where('id',$id)->accessible()->get()->toArray();
        $array['next_page_url']=isset($array['next_page_url'])?$array['next_page_url']:null;
        $array['prev_page_url']=isset($array['prev_page_url'])?$array['prev_page_url']:null;
        $array['data']=isset($array['data'])?$array['data']:null;
        return view("frontend.pages.portal.jsonViewer",["json"=>str_replace(['\\','`'],['\\\\','｀'],json_encode((object)[$array['data']], JSON_PRETTY_PRINT)),'next'=>$array['next_page_url'],'prev'=>$array['prev_page_url'],'title'=>$title]);
    }
    public function paymentLinks(){
        $title=ucwords('payment links');
        $array['data']=finix_payment_links::accessible()->get()->toArray();
        $array['next_page_url']=isset($array['next_page_url'])?$array['next_page_url']:null;
        $array['prev_page_url']=isset($array['prev_page_url'])?$array['prev_page_url']:null;
        $array['data']=isset($array['data'])?$array['data']:null;
        return view("frontend.pages.portal.jsonViewer",["json"=>str_replace(['\\','`'],['\\\\','｀'],json_encode((object)[$array['data']], JSON_PRETTY_PRINT)),'next'=>$array['next_page_url'],'prev'=>$array['prev_page_url'],'title'=>$title]);
    }
    public function paymentLink($id){
        $title=ucwords('payment link');
        $array['data']=finix_payment_links::where('id',$id)->accessible()->get()->toArray();
        $array['next_page_url']=isset($array['next_page_url'])?$array['next_page_url']:null;
        $array['prev_page_url']=isset($array['prev_page_url'])?$array['prev_page_url']:null;
        $array['data']=isset($array['data'])?$array['data']:null;
        return view("frontend.pages.portal.jsonViewer",["json"=>str_replace(['\\','`'],['\\\\','｀'],json_encode((object)[$array['data']], JSON_PRETTY_PRINT)),'next'=>$array['next_page_url'],'prev'=>$array['prev_page_url'],'title'=>$title]);
    }
    public function paymentLinks_live(){
        $title=ucwords('payment links live');
        $array['data']=finix_payment_links_live::accessible()->get()->toArray();
        $array['next_page_url']=isset($array['next_page_url'])?$array['next_page_url']:null;
        $array['prev_page_url']=isset($array['prev_page_url'])?$array['prev_page_url']:null;
        $array['data']=isset($array['data'])?$array['data']:null;
        return view("frontend.pages.portal.jsonViewer",["json"=>str_replace(['\\','`'],['\\\\','｀'],json_encode((object)[$array['data']], JSON_PRETTY_PRINT)),'next'=>$array['next_page_url'],'prev'=>$array['prev_page_url'],'title'=>$title]);
    }
    public function paymentLink_live($id){
        $title=ucwords('payment link live');
        $array['data']=finix_payment_links_live::where('id',$id)->accessible()->get()->toArray();
        $array['next_page_url']=isset($array['next_page_url'])?$array['next_page_url']:null;
        $array['prev_page_url']=isset($array['prev_page_url'])?$array['prev_page_url']:null;
        $array['data']=isset($array['data'])?$array['data']:null;
        return view("frontend.pages.portal.jsonViewer",["json"=>str_replace(['\\','`'],['\\\\','｀'],json_encode((object)[$array['data']], JSON_PRETTY_PRINT)),'next'=>$array['next_page_url'],'prev'=>$array['prev_page_url'],'title'=>$title]);
    }
    public function balanceTransfers(){
        $title=ucwords('balance transfers');
        $array['data']=BalanceTransfer::accessible()->get()->toArray();
        $array['next_page_url']=isset($array['next_page_url'])?$array['next_page_url']:null;
        $array['prev_page_url']=isset($array['prev_page_url'])?$array['prev_page_url']:null;
        $array['data']=isset($array['data'])?$array['data']:null;
        return view("frontend.pages.portal.jsonViewer",["json"=>str_replace(['\\','`'],['\\\\','｀'],json_encode((object)[$array['data']], JSON_PRETTY_PRINT)),'next'=>$array['next_page_url'],'prev'=>$array['prev_page_url'],'title'=>$title]);
    }
    public function balanceTransfer($id){
        $title=ucwords('balance transfer');
        $array['data']=balanceTransfer::where('id',$id)->accessible()->get()->toArray();
        $array['next_page_url']=isset($array['next_page_url'])?$array['next_page_url']:null;
        $array['prev_page_url']=isset($array['prev_page_url'])?$array['prev_page_url']:null;
        $array['data']=isset($array['data'])?$array['data']:null;
        return view("frontend.pages.portal.jsonViewer",["json"=>str_replace(['\\','`'],['\\\\','｀'],json_encode((object)[$array['data']], JSON_PRETTY_PRINT)),'next'=>$array['next_page_url'],'prev'=>$array['prev_page_url'],'title'=>$title]);
    }
    public function balanceTransfers_live(){
        $title=ucwords('balance transfers live');
        $array['data']=BalanceTransfer_live::accessible()->get()->toArray();
        $array['next_page_url']=isset($array['next_page_url'])?$array['next_page_url']:null;
        $array['prev_page_url']=isset($array['prev_page_url'])?$array['prev_page_url']:null;
        $array['data']=isset($array['data'])?$array['data']:null;
        return view("frontend.pages.portal.jsonViewer",["json"=>str_replace(['\\','`'],['\\\\','｀'],json_encode((object)[$array['data']], JSON_PRETTY_PRINT)),'next'=>$array['next_page_url'],'prev'=>$array['prev_page_url'],'title'=>$title]);
    }
    public function balanceTransfer_live($id){
        $title=ucwords('balance transfer live');
        $array['data']=balanceTransfer_live::where('id',$id)->accessible()->get()->toArray();
        $array['next_page_url']=isset($array['next_page_url'])?$array['next_page_url']:null;
        $array['prev_page_url']=isset($array['prev_page_url'])?$array['prev_page_url']:null;
        $array['data']=isset($array['data'])?$array['data']:null;
        return view("frontend.pages.portal.jsonViewer",["json"=>str_replace(['\\','`'],['\\\\','｀'],json_encode((object)[$array['data']], JSON_PRETTY_PRINT)),'next'=>$array['next_page_url'],'prev'=>$array['prev_page_url'],'title'=>$title]);
    }
    public function verifications(){
        $title=ucwords('verifications');
        $array['data']=verifications::accessible()->get()->toArray();
        $array['next_page_url']=isset($array['next_page_url'])?$array['next_page_url']:null;
        $array['prev_page_url']=isset($array['prev_page_url'])?$array['prev_page_url']:null;
        $array['data']=isset($array['data'])?$array['data']:null;
        return view("frontend.pages.portal.jsonViewer",["json"=>str_replace(['\\','`'],['\\\\','｀'],json_encode((object)[$array['data']], JSON_PRETTY_PRINT)),'next'=>$array['next_page_url'],'prev'=>$array['prev_page_url'],'title'=>$title]);
    }
    public function verification($id){
        $title=ucwords('verification');
        $array['data']=verifications::where('id',$id)->accessible()->get()->toArray();
        $array['next_page_url']=isset($array['next_page_url'])?$array['next_page_url']:null;
        $array['prev_page_url']=isset($array['prev_page_url'])?$array['prev_page_url']:null;
        $array['data']=isset($array['data'])?$array['data']:null;
        return view("frontend.pages.portal.jsonViewer",["json"=>str_replace(['\\','`'],['\\\\','｀'],json_encode((object)[$array['data']], JSON_PRETTY_PRINT)),'next'=>$array['next_page_url'],'prev'=>$array['prev_page_url'],'title'=>$title]);
    }
    public function verifications_live(){
        $title=ucwords('verifications live');
        $array['data']=verifications_live::accessible()->get()->toArray();
        $array['next_page_url']=isset($array['next_page_url'])?$array['next_page_url']:null;
        $array['prev_page_url']=isset($array['prev_page_url'])?$array['prev_page_url']:null;
        $array['data']=isset($array['data'])?$array['data']:null;
        return view("frontend.pages.portal.jsonViewer",["json"=>str_replace(['\\','`'],['\\\\','｀'],json_encode((object)[$array['data']], JSON_PRETTY_PRINT)),'next'=>$array['next_page_url'],'prev'=>$array['prev_page_url'],'title'=>$title]);
    }
    public function verification_live($id){
        $title=ucwords('verification live');
        $array['data']=verifications_live::where('id',$id)->accessible()->get()->toArray();
        $array['next_page_url']=isset($array['next_page_url'])?$array['next_page_url']:null;
        $array['prev_page_url']=isset($array['prev_page_url'])?$array['prev_page_url']:null;
        $array['data']=isset($array['data'])?$array['data']:null;
        return view("frontend.pages.portal.jsonViewer",["json"=>str_replace(['\\','`'],['\\\\','｀'],json_encode((object)[$array['data']], JSON_PRETTY_PRINT)),'next'=>$array['next_page_url'],'prev'=>$array['prev_page_url'],'title'=>$title]);
    }
    public function subscriptionSchedules(){
        $title=ucwords('subscription schedules');
        $array['data']=subscription_schedules::accessible()->get()->toArray();
        $array['next_page_url']=isset($array['next_page_url'])?$array['next_page_url']:null;
        $array['prev_page_url']=isset($array['prev_page_url'])?$array['prev_page_url']:null;
        $array['data']=isset($array['data'])?$array['data']:null;
        return view("frontend.pages.portal.jsonViewer",["json"=>str_replace(['\\','`'],['\\\\','｀'],json_encode((object)[$array['data']], JSON_PRETTY_PRINT)),'next'=>$array['next_page_url'],'prev'=>$array['prev_page_url'],'title'=>$title]);
    }
    public function subscriptionSchedule($id){
        $title=ucwords('subscription schedule');
        $array['data']=subscription_schedules::where('id',$id)->accessible()->get()->toArray();
        $array['next_page_url']=isset($array['next_page_url'])?$array['next_page_url']:null;
        $array['prev_page_url']=isset($array['prev_page_url'])?$array['prev_page_url']:null;
        $array['data']=isset($array['data'])?$array['data']:null;
        return view("frontend.pages.portal.jsonViewer",["json"=>str_replace(['\\','`'],['\\\\','｀'],json_encode((object)[$array['data']], JSON_PRETTY_PRINT)),'next'=>$array['next_page_url'],'prev'=>$array['prev_page_url'],'title'=>$title]);
    }
    public function subscriptionSchedules_live(){
        $title=ucwords('subscription schedules live');
        $array['data']=subscription_schedules_live::accessible()->get()->toArray();
        $array['next_page_url']=isset($array['next_page_url'])?$array['next_page_url']:null;
        $array['prev_page_url']=isset($array['prev_page_url'])?$array['prev_page_url']:null;
        $array['data']=isset($array['data'])?$array['data']:null;
        return view("frontend.pages.portal.jsonViewer",["json"=>str_replace(['\\','`'],['\\\\','｀'],json_encode((object)[$array['data']], JSON_PRETTY_PRINT)),'next'=>$array['next_page_url'],'prev'=>$array['prev_page_url'],'title'=>$title]);
    }
    public function subscriptionSchedule_live($id){
        $title=ucwords('subscription schedule live');
        $array['data']=subscription_schedules_live::where('id',$id)->accessible()->get()->toArray();
        $array['next_page_url']=isset($array['next_page_url'])?$array['next_page_url']:null;
        $array['prev_page_url']=isset($array['prev_page_url'])?$array['prev_page_url']:null;
        $array['data']=isset($array['data'])?$array['data']:null;
        return view("frontend.pages.portal.jsonViewer",["json"=>str_replace(['\\','`'],['\\\\','｀'],json_encode((object)[$array['data']], JSON_PRETTY_PRINT)),'next'=>$array['next_page_url'],'prev'=>$array['prev_page_url'],'title'=>$title]);
    }
    public function subscriptionAmounts(){
        $title=ucwords('subscription amounts');
        $array['data']=subscription_amounts::accessible()->get()->toArray();
        $array['next_page_url']=isset($array['next_page_url'])?$array['next_page_url']:null;
        $array['prev_page_url']=isset($array['prev_page_url'])?$array['prev_page_url']:null;
        $array['data']=isset($array['data'])?$array['data']:null;
        return view("frontend.pages.portal.jsonViewer",["json"=>str_replace(['\\','`'],['\\\\','｀'],json_encode((object)[$array['data']], JSON_PRETTY_PRINT)),'next'=>$array['next_page_url'],'prev'=>$array['prev_page_url'],'title'=>$title]);
    }
    public function subscriptionAmount($id){
        $title=ucwords('subscription amount');
        $array['data']=subscription_amounts::where('id',$id)->accessible()->get()->toArray();
        $array['next_page_url']=isset($array['next_page_url'])?$array['next_page_url']:null;
        $array['prev_page_url']=isset($array['prev_page_url'])?$array['prev_page_url']:null;
        $array['data']=isset($array['data'])?$array['data']:null;
        return view("frontend.pages.portal.jsonViewer",["json"=>str_replace(['\\','`'],['\\\\','｀'],json_encode((object)[$array['data']], JSON_PRETTY_PRINT)),'next'=>$array['next_page_url'],'prev'=>$array['prev_page_url'],'title'=>$title]);
    }
    public function subscriptionAmounts_live(){
        $title=ucwords('subscription amounts live');
        $array['data']=subscription_amounts_live::accessible()->get()->toArray();
        $array['next_page_url']=isset($array['next_page_url'])?$array['next_page_url']:null;
        $array['prev_page_url']=isset($array['prev_page_url'])?$array['prev_page_url']:null;
        $array['data']=isset($array['data'])?$array['data']:null;
        return view("frontend.pages.portal.jsonViewer",["json"=>str_replace(['\\','`'],['\\\\','｀'],json_encode((object)[$array['data']], JSON_PRETTY_PRINT)),'next'=>$array['next_page_url'],'prev'=>$array['prev_page_url'],'title'=>$title]);
    }
    public function subscriptionAmount_live($id){
        $title=ucwords('subscription amount live');
        $array['data']=subscription_amounts_live::where('id',$id)->accessible()->get()->toArray();
        $array['next_page_url']=isset($array['next_page_url'])?$array['next_page_url']:null;
        $array['prev_page_url']=isset($array['prev_page_url'])?$array['prev_page_url']:null;
        $array['data']=isset($array['data'])?$array['data']:null;
        return view("frontend.pages.portal.jsonViewer",["json"=>str_replace(['\\','`'],['\\\\','｀'],json_encode((object)[$array['data']], JSON_PRETTY_PRINT)),'next'=>$array['next_page_url'],'prev'=>$array['prev_page_url'],'title'=>$title]);
    }
    public function subscriptionEnrollments(){
        $title=ucwords('subscription enrollments');
        $array['data']=subscription_enrollments::accessible()->get()->toArray();
        $array['next_page_url']=isset($array['next_page_url'])?$array['next_page_url']:null;
        $array['prev_page_url']=isset($array['prev_page_url'])?$array['prev_page_url']:null;
        $array['data']=isset($array['data'])?$array['data']:null;
        return view("frontend.pages.portal.jsonViewer",["json"=>str_replace(['\\','`'],['\\\\','｀'],json_encode((object)[$array['data']], JSON_PRETTY_PRINT)),'next'=>$array['next_page_url'],'prev'=>$array['prev_page_url'],'title'=>$title]);
    }
    public function subscriptionEnrollment($id){
        $title=ucwords('subscription enrollment');
        $array['data']=subscription_enrollments::where('id',$id)->accessible()->get()->toArray();
        $array['next_page_url']=isset($array['next_page_url'])?$array['next_page_url']:null;
        $array['prev_page_url']=isset($array['prev_page_url'])?$array['prev_page_url']:null;
        $array['data']=isset($array['data'])?$array['data']:null;
        return view("frontend.pages.portal.jsonViewer",["json"=>str_replace(['\\','`'],['\\\\','｀'],json_encode((object)[$array['data']], JSON_PRETTY_PRINT)),'next'=>$array['next_page_url'],'prev'=>$array['prev_page_url'],'title'=>$title]);
    }
    public function subscriptionEnrollments_live(){
        $title=ucwords('subscription enrollments live');
        $array['data']=subscription_enrollments_live::accessible()->get()->toArray();
        $array['next_page_url']=isset($array['next_page_url'])?$array['next_page_url']:null;
        $array['prev_page_url']=isset($array['prev_page_url'])?$array['prev_page_url']:null;
        $array['data']=isset($array['data'])?$array['data']:null;
        return view("frontend.pages.portal.jsonViewer",["json"=>str_replace(['\\','`'],['\\\\','｀'],json_encode((object)[$array['data']], JSON_PRETTY_PRINT)),'next'=>$array['next_page_url'],'prev'=>$array['prev_page_url'],'title'=>$title]);
    }
    public function subscriptionEnrollment_live($id){
        $title=ucwords('subscription enrollment live');
        $array['data']=subscription_enrollments_live::where('id',$id)->accessible()->get()->toArray();
        $array['next_page_url']=isset($array['next_page_url'])?$array['next_page_url']:null;
        $array['prev_page_url']=isset($array['prev_page_url'])?$array['prev_page_url']:null;
        $array['data']=isset($array['data'])?$array['data']:null;
        return view("frontend.pages.portal.jsonViewer",["json"=>str_replace(['\\','`'],['\\\\','｀'],json_encode((object)[$array['data']], JSON_PRETTY_PRINT)),'next'=>$array['next_page_url'],'prev'=>$array['prev_page_url'],'title'=>$title]);
    }


}
