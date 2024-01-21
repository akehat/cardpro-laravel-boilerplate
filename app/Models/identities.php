<?php

namespace App\Models;

use App\Http\Controllers\API\merchantsController;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class identities extends Model
{
    use HasFactory;
    protected $table="identities";
    protected $guarded=['id'];
    public static function runUpdate(){
        $result= merchantsController::listIdentities(config("app.api_username"),config("app.api_password"));
        $object=json_decode($result[0]);
        while(isset($object->_embedded)&&isset($object->_embedded->identities)&&isset($object->page)&&isset($object->page->next_cursor)&&count($object->_embedded->identities)>0){
            identities::fromArray($object->_embedded->identities);
         $nextArray=['after_cursor'=>$object->page->next_cursor];
         $result= merchantsController::listIdentities(config("app.api_username"),config("app.api_password"),'https://finix.sandbox-payments-api.com',$nextArray);
         $object=json_decode($result[0]);
        }
     }
    public static function fromArray($array){
        foreach ($array as $value) {
            $value=(object)$value;
            $found=identities::where('finix_id',$value->id)->first();
            if($found==null){
               $found=identities::create([
                'application'=>$value->application??null,
                'entity'=>json_encode($value->entity??[])??null,
                'identity_roles'=>json_encode($value->identity_roles??[])??null,
                'tags'=>json_encode($value->tags??[])??null,
                'finix_id'=>$value->id??null
                ]);
            }else{
                $found->update([
                    'application'=>$value->application??null,
                    'entity'=>json_encode($value->entity??[])??null,
                    'identity_roles'=>json_encode($value->identity_roles??[])??null,
                    'tags'=>json_encode($value->tags??[])??null,
                    'finix_id'=>$value->id??null
                    ]);
            }
            $found->save();
            $found->refresh();
        }
    }
    public static function makeMerchantIdentity($entity_annual_card_volume,
    $entity_business_address_city,
    $entity_business_address_country,
    $entity_business_address_region,
    $entity_business_address_line2,
    $entity_business_address_line1,
    $entity_business_address_postal_code,
    $entity_business_name,
    $entity_business_phone,
    $entity_business_tax_id,
    $entity_business_type,
    $entity_default_statement_descriptor,
    $entity_dob_year,
    $entity_dob_day,
    $entity_dob_month,
    $entity_doing_business_as,
    $entity_email,
    $entity_first_name,
    $entity_has_accepted_credit_cards_previously,
    $entity_incorporation_date_year,
    $entity_incorporation_date_day,
    $entity_incorporation_date_month,
    $entity_last_name,
    $entity_max_transaction_amount,
    $entity_ach_max_transaction_amount,
    $entity_mcc,
    $entity_ownership_type,
    $entity_personal_address_city,
    $entity_personal_address_country,
    $entity_personal_address_region,
    $entity_personal_address_line2,
    $entity_personal_address_line1,
    $entity_personal_address_postal_code,
    $entity_phone,
    $entity_principal_percentage_ownership,
    $entity_tax_id,
    $entity_title,
    $entity_url,$userID,$api_userID,$islive=false){
        $endpoint=$islive?'https://finix.live-payments-api.com':'https://finix.sandbox-payments-api.com';
        $merchant=merchantsController::createIdentityMerchantMinReq(config("app.api_username"),config("app.api_password"),
        $entity_annual_card_volume,
        $entity_business_address_city,
        $entity_business_address_country,
        $entity_business_address_region,
        $entity_business_address_line2,
        $entity_business_address_line1,
        $entity_business_address_postal_code,
        $entity_business_name,
        $entity_business_phone,
        $entity_business_tax_id,
        $entity_business_type,
        $entity_default_statement_descriptor,
        $entity_dob_year,
        $entity_dob_day,
        $entity_dob_month,
        $entity_doing_business_as,
        $entity_email,
        $entity_first_name,
        $entity_has_accepted_credit_cards_previously??'false',
        $entity_incorporation_date_year,
        $entity_incorporation_date_day,
        $entity_incorporation_date_month,
        $entity_last_name,
        $entity_max_transaction_amount,
        $entity_ach_max_transaction_amount,
        $entity_mcc,
        $entity_ownership_type,
        $entity_personal_address_city,
        $entity_personal_address_country,
        $entity_personal_address_region,
        $entity_personal_address_line2,
        $entity_personal_address_line1,
        $entity_personal_address_postal_code,
        $entity_phone,
        $entity_principal_percentage_ownership,
        $entity_tax_id,
        $entity_title,
        $entity_url,$endpoint,[],['tags'=>["userID"=>"userID_".$userID,"api_userID"=>"api_userID_".$api_userID]]);
        if($merchant[1]>=200&&$merchant[1]<300){
        $value=(object)json_decode($merchant[0]);
        $merchantMade=self::create([
            'application'=>$value->application??null,
            'entity'=>json_encode($value->entity??[])??null,
            'identity_roles'=>json_encode($value->identity_roles??[])??null,
            'tags'=>json_encode($value->tags??[])??null,
            'finix_id'=>$value->id??null,
            'api_user'=>$api_userID??null,
            'is_live'=>$islive??null,
        ]);
        $merchantMade->save();
        $merchantMade->refresh();
            return ['worked'=>true,"responce"=>$merchant[0],"ref"=>$merchantMade];
        }else{
            return ['worked'=>false,"responce"=>$merchant[0]];
        }
    }
}
