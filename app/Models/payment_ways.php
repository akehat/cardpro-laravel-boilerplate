<?php

namespace App\Models;

use App\Http\Controllers\API\merchantsController;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Log;

class payment_ways extends Model
{
    use HasFactory;
    protected $table="payment_ways";
    protected $guarded=['id'];
    public static function runUpdate(){
       $result= merchantsController::listPaymentInstraments(config("app.api_username"),config("app.api_password"));
       $object=json_decode($result[0]);
       while(isset($object->_embedded)&&isset($object->_embedded->payment_instruments)&&isset($object->page)&&isset($object->page->next_cursor)&&count($object->_embedded->payment_instruments)>0){
        payment_ways::fromArray($object->_embedded->payment_instruments);
        $nextArray=['after_cursor'=>$object->page->next_cursor];
        $result= merchantsController::listPaymentInstraments(config("app.api_username"),config("app.api_password"),'https://finix.sandbox-payments-api.com',$nextArray);
        $object=json_decode($result[0]);
       }
    }
    public static function fromArray($array){
        foreach ($array as $value) {
            $value=(object)$value;
            $found=payment_ways::where('finix_id',$value->id)->first();
            if($found==null){
               $found=payment_ways::create([
               'finix_id'=>$value->id??null,
                'created_at_finix'=>$value->created_at??null,
                'updated_at_finix'=>$value->updated_at??null,
                'application'=>$value->application??null,
                'created_via'=>$value->created_via??null,
                'currency'=>$value->currency??null,
                'disabled_code'=>$value->disabled_code??null,
                'disabled_message'=>$value->disabled_message??null,
                'enabled'=>$value->enabled??null,
                'fingerprint'=>$value->fingerprint??null,
                'identity'=>$value->identity??null,
                'instrument_type'=>$value->instrument_type??null,
                'address'=>$value->address??null,
                'address_verification'=>$value->address_verification??null,
                'bin'=>$value->bin??null,
                'brand'=>$value->brand??null,
                'card_type'=>$value->card_type??null,
                'expiration_month'=>$value->expiration_month??null,
                'expiration_year'=>$value->expiration_year??null,
                'issuer_country'=>$value->issuer_country??null,
                'last_four'=>$value->last_four??null,
                'name'=>$value->name??null,
                'security_code_verification'=>$value->security_code_verification??null,
                'tags'=>json_encode($value->tags)??null,
               'type'=>$value->type??null,
                'account_type'=>$value->account_type??null,
                'bank_account_validation_check'=>$value->bank_account_validation_check??null,
                'bank_code'=>$value->bank_code??null,
                'country'=>$value->country??null,
                'institution_number'=>$value->institution_number??null,
                'masked_account_number'=>$value->masked_account_number??null,
                'transit_number'=>$value->transit_number??null
                ]);
            }else{
                $found::update([
                    'finix_id'=>$value->id??null,
                     'created_at_finix'=>$value->created_at??null,
                     'updated_at_finix'=>$value->updated_at??null,
                     'application'=>$value->application??null,
                     'created_via'=>$value->created_via??null,
                     'currency'=>$value->currency??null,
                     'disabled_code'=>$value->disabled_code??null,
                     'disabled_message'=>$value->disabled_message??null,
                     'enabled'=>$value->enabled??null,
                     'fingerprint'=>$value->fingerprint??null,
                     'identity'=>$value->identity??null,
                     'instrument_type'=>$value->instrument_type??null,
                     'address'=>$value->address??null,
                     'address_verification'=>$value->address_verification??null,
                     'bin'=>$value->bin??null,
                     'brand'=>$value->brand??null,
                     'card_type'=>$value->card_type??null,
                     'expiration_month'=>$value->expiration_month??null,
                     'expiration_year'=>$value->expiration_year??null,
                     'issuer_country'=>$value->issuer_country??null,
                     'last_four'=>$value->last_four??null,
                     'name'=>$value->name??null,
                     'security_code_verification'=>$value->security_code_verification??null,
                     'tags'=>json_encode($value->tags)??null,
                    'type'=>$value->type??null,
                     'account_type'=>$value->account_type??null,
                     'bank_account_validation_check'=>$value->bank_account_validation_check??null,
                     'bank_code'=>$value->bank_code??null,
                     'country'=>$value->country??null,
                     'institution_number'=>$value->institution_number??null,
                     'masked_account_number'=>$value->masked_account_number??null,
                     'transit_number'=>$value->transit_number??null
                     ]);
            }
            $found->save();
            $found->refresh();
        }
    }
}
