<?php

namespace App\Models;

use App\Http\Controllers\API\merchantsController;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Finix_Merchant extends Model
{
    use HasFactory;
    protected $table="finix_merchants";
    protected $guarded=['id'];
    public static function runUpdate(){
        $result= merchantsController::listMerchants(config("app.api_username"),config("app.api_password"));
        $object=json_decode($result[0]);
        while(isset($object->_embedded)&&isset($object->_embedded->merchants)&&isset($object->page)&&isset($object->page->next_cursor)&&count($object->_embedded->merchants)>0){
            self::fromArray($object->_embedded->merchants);
         $nextArray=['after_cursor'=>$object->page->next_cursor];
         $result= merchantsController::listMerchants(config("app.api_username"),config("app.api_password"),'https://finix.sandbox-payments-api.com',$nextArray);
         $object=json_decode($result[0]);
        }
     }
public static function fromArray(array $array)
{
    foreach ($array as $data) {
        $data = (object)$data;

        $found = self::where('finix_id', $data->id)->first();

        if ($found == null) {
            $found = self::create([
                'finix_id' => $data->id ?? null,
                'application' => $data->application ?? null,
                'card_cvv_required' => $data->card_cvv_required ?? null,
                'card_expiration_date_required' => $data->card_expiration_date_required ?? null,
                'convenience_charges_enabled' => $data->convenience_charges_enabled ?? null,
                'country' => $data->country ?? null,
                'creating_transfer_from_report_enabled' => $data->creating_transfer_from_report_enabled ?? null,
                'currencies' => json_encode($data->currencies??[]) ?? null,
                'default_partial_authorization_enabled' => $data->default_partial_authorization_enabled ?? null,
                'disbursements_ach_pull_enabled' => $data->disbursements_ach_pull_enabled ?? null,
                'disbursements_ach_push_enabled' => $data->disbursements_ach_push_enabled ?? null,
                'disbursements_card_pull_enabled' => $data->disbursements_card_pull_enabled ?? null,
                'disbursements_card_push_enabled' => $data->disbursements_card_push_enabled ?? null,
                'fee_ready_to_settle_upon' => $data->fee_ready_to_settle_upon ?? null,
                'gateway' => $data->gateway ?? null,
                'gross_settlement_enabled' => $data->gross_settlement_enabled ?? null,
                'identity' => $data->identity ?? null,
                'level_two_level_three_data_enabled' => $data->level_two_level_three_data_enabled ?? null,
                'mcc' => $data->mcc ?? null,
                'merchant_name' => $data->merchant_name ?? null,
                'merchant_profile' => $data->merchant_profile ?? null,
                'mid' => $data->mid ?? null,
                'onboarding_state' => $data->onboarding_state ?? null,
                'processing_enabled' => $data->processing_enabled ?? null,
                'processor' => $data->processor ?? null,
                'processor_details' => json_encode($data->processor_details??[]) ?? null,
                'ready_to_settle_upon' => $data->ready_to_settle_upon ?? null,
                'rent_surcharges_enabled' => $data->rent_surcharges_enabled ?? null,
                'settlement_enabled' => $data->settlement_enabled ?? null,
                'settlement_funding_identifier' => $data->settlement_funding_identifier ?? null,
                'surcharges_enabled' => $data->surcharges_enabled ?? null,
                'tags' => json_encode($data->tags??[]) ?? null,
                'verification' => $data->verification ?? null,
                '_links' => $data->_links ?? null,
            ]);
        } else {
            $found->update([
                'finix_id' => $data->id ?? null,
                'application' => $data->application ?? null,
                'card_cvv_required' => $data->card_cvv_required ?? null,
                'card_expiration_date_required' => $data->card_expiration_date_required ?? null,
                'convenience_charges_enabled' => $data->convenience_charges_enabled ?? null,
                'country' => $data->country ?? null,
                'creating_transfer_from_report_enabled' => $data->creating_transfer_from_report_enabled ?? null,
                'currencies' => json_encode($data->currencies??[]) ?? null,
                'default_partial_authorization_enabled' => $data->default_partial_authorization_enabled ?? null,
                'disbursements_ach_pull_enabled' => $data->disbursements_ach_pull_enabled ?? null,
                'disbursements_ach_push_enabled' => $data->disbursements_ach_push_enabled ?? null,
                'disbursements_card_pull_enabled' => $data->disbursements_card_pull_enabled ?? null,
                'disbursements_card_push_enabled' => $data->disbursements_card_push_enabled ?? null,
                'fee_ready_to_settle_upon' => $data->fee_ready_to_settle_upon ?? null,
                'gateway' => $data->gateway ?? null,
                'gross_settlement_enabled' => $data->gross_settlement_enabled ?? null,
                'identity' => $data->identity ?? null,
                'level_two_level_three_data_enabled' => $data->level_two_level_three_data_enabled ?? null,
                'mcc' => $data->mcc ?? null,
                'merchant_name' => $data->merchant_name ?? null,
                'merchant_profile' => $data->merchant_profile ?? null,
                'mid' => $data->mid ?? null,
                'onboarding_state' => $data->onboarding_state ?? null,
                'processing_enabled' => $data->processing_enabled ?? null,
                'processor' => $data->processor ?? null,
                'processor_details' => json_encode($data->processor_details??[]) ?? null,
                'ready_to_settle_upon' => $data->ready_to_settle_upon ?? null,
                'rent_surcharges_enabled' => $data->rent_surcharges_enabled ?? null,
                'settlement_enabled' => $data->settlement_enabled ?? null,
                'settlement_funding_identifier' => $data->settlement_funding_identifier ?? null,
                'surcharges_enabled' => $data->surcharges_enabled ?? null,
                'tags' => json_encode($data->tags??[]) ?? null,
                'verification' => $data->verification ?? null,
                '_links' => $data->_links ?? null,
            ]);
        }

        // Save and refresh the model
        $found->save();
        $found->refresh();
    }
}
public static function makeMerchant($merchantIdentity,$userID,$api_userID,$islive=false,$apikeyID=0){
    $endpoint=$islive?'https://finix.live-payments-api.com':'https://finix.sandbox-payments-api.com';
    $processor=$islive?merchantsController::$processors[0]:merchantsController::$processors[1];
    $merchant=merchantsController::createAMerchantMinReq(config("app.api_username"),config("app.api_password"), $merchantIdentity,$processor,$endpoint,[],['tags'=>["userID"=>"userID_".$userID,"api_userID"=>"api_userID_".$api_userID,"apikeyID"=>"apikeyID_".$apikeyID]]);
    if($merchant[1]>=200&&$merchant[1]<300){
    $value=(object)json_decode($merchant[0]);
    $merchantMade=self::create([
        'finix_id' => $value->id ?? null,
        'application' => $value->application ?? null,
        'card_cvv_required' => $value->card_cvv_required ?? null,
        'card_expiration_date_required' => $value->card_expiration_date_required ?? null,
        'convenience_charges_enabled' => $value->convenience_charges_enabled ?? null,
        'country' => $value->country ?? null,
        'creating_transfer_from_report_enabled' => $value->creating_transfer_from_report_enabled ?? null,
        'currencies' => json_encode($value->currencies??[]) ?? null,
        'default_partial_authorization_enabled' => $value->default_partial_authorization_enabled ?? null,
        'disbursements_ach_pull_enabled' => $value->disbursements_ach_pull_enabled ?? null,
        'disbursements_ach_push_enabled' => $value->disbursements_ach_push_enabled ?? null,
        'disbursements_card_pull_enabled' => $value->disbursements_card_pull_enabled ?? null,
        'disbursements_card_push_enabled' => $value->disbursements_card_push_enabled ?? null,
        'fee_ready_to_settle_upon' => $value->fee_ready_to_settle_upon ?? null,
        'gateway' => $value->gateway ?? null,
        'gross_settlement_enabled' => $value->gross_settlement_enabled ?? null,
        'identity' => $value->identity ?? null,
        'level_two_level_three_value_enabled' => $value->level_two_level_three_value_enabled ?? null,
        'mcc' => $value->mcc ?? null,
        'merchant_name' => $value->merchant_name ?? null,
        'merchant_profile' => $value->merchant_profile ?? null,
        'mid' => $value->mid ?? null,
        'onboarding_state' => $value->onboarding_state ?? null,
        'processing_enabled' => $value->processing_enabled ?? null,
        'processor' => $value->processor ?? null,
        'processor_details' => json_encode($value->processor_details??[]) ?? null,
        'ready_to_settle_upon' => $value->ready_to_settle_upon ?? null,
        'rent_surcharges_enabled' => $value->rent_surcharges_enabled ?? null,
        'settlement_enabled' => $value->settlement_enabled ?? null,
        'settlement_funding_identifier' => $value->settlement_funding_identifier ?? null,
        'surcharges_enabled' => $value->surcharges_enabled ?? null,
        'tags' => json_encode($value->tags??[]) ?? null,
        'verification' => $value->verification ?? null,
        '_links' => $value->_links ?? null,
        'api_user'=>$api_userID??null,
        'is_live'=>$islive??null,
        'api_key'=>''.$apikeyID??null
    ]);
    $merchantMade->save();
    $merchantMade->refresh();
    $key=ApiKey::create(['api_key'=>"Api_key".$merchantMade->id.self::generateApiKey(),
'live'=>$islive,
'merchant_id'=>$merchantMade->id,
'balance'=>0,
]);
$key->save();
$key->refresh();
        return ['worked'=>true,"responce"=>$merchant[0],"ref"=>$merchantMade,'key'=>$key];
    }else{
        return ['worked'=>false,"responce"=>$merchant[0]];
    }
}
public static function generateApiKey($length = 32)
{
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $apiKey = '';

    for ($i = 0; $i < $length; $i++) {
        $apiKey .= $characters[rand(0, strlen($characters) - 1)];
    }

    return $apiKey;
}
}
