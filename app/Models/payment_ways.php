<?php

namespace App\Models;

use App\Http\Controllers\API\merchantsController;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;

class payment_ways extends Model
{
public function scopeAccessible($query)
    {
        // Check if the authenticated user is an admin
        if (Auth::check() && Auth::user()->isAdmin()) {
            return $query; // No additional condition needed for admins
        }

        // If not an admin, add the additional condition
        return $query->where('api_user', Auth::user()->apiuser()->select('api_users.id')->first()->id);
    }
 public static function authenticateGetID($id, $api_userID , $api_key)
    {
        if(($api_userID > 1 || $api_userID === null) && ($api_key > 1 || $api_key === null)) return false;
        // Check if the API key is a sub key
        if ($api_key > 1 || $api_key === null) {
            return self::where(function ($query) use ($id) {
            $query->where('id', $id)
                  ->orWhere('finix_id', $id);
        })->where('api_key', $api_key)
                ->where('api_user', $api_userID)
                ->first();
        } else {
            // If the API key is not a sub key, no need to query the database
            return self::where('api_user', $api_userID)
                ->where(function ($query) use ($id) {
            $query->where('id', $id)
                  ->orWhere('finix_id', $id);
        })
                ->first();
        }
    }
   public static function authenticateGet($api_userID, $api_key)
{
    $perPage = 20; // Default items per page

    if (($api_userID > 1 || $api_userID === null) && ($api_key > 1 || $api_key === null)) {
        return false;
    }

    // Check if the API key is a sub key
    if ($api_key > 1 || $api_key === null) {
        return self::where('api_key', $api_key)
            ->where('api_user', $api_userID)
            ->paginate($perPage);
    } else {
        // If the API key is not a sub key, no need to query the database
        return self::where('api_user', $api_userID)
            ->paginate($perPage);
    }
}
public static function authenticateSearch($api_userID, $api_key, $search)
{
    $columns = \Schema::getColumnListing((new self())->getTable());
    $perPage = 20; // Default items per page

    if (($api_userID > 1 || $api_userID === null) && ($api_key > 1 || $api_key === null)) {
        return false;
    }

    // Check if the API key is a sub key
    if ($api_key > 1 || $api_key === null) {
        return self::where('api_key', $api_key)
            ->where('api_user', $api_userID)
            ->where(function ($query) use ($columns, $search) {
                foreach ($columns as $column) {
                    $query->orWhere($column, 'like', "%{$search}%");
                }
            })
            ->paginate($perPage);
    } else {
        // If the API key is not a sub key, no need to query the database
        return self::where('api_user', $api_userID)
            ->where(function ($query) use ($columns, $search) {
                foreach ($columns as $column) {
                    $query->orWhere($column, 'like', "%{$search}%");
                }
            })
            ->paginate($perPage);
    }
}


    use HasFactory;
    protected $table="payment_ways";
    protected $guarded=['id'];
    public static $name='payment_instruments';
    public static function updateFromId($id){
        self::fromArray([json_decode(merchantsController::fetchPaymentInstrament(config("app.api_username"),config("app.api_password"),$id)[0])]);
     }
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
                $found->update([
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
    public static function makeCard($exp_month,$exp_year,$identity,$name,$card_number,$cvv,$userID,$api_userID,$apikeyID=0){
        $islive=false;
        $endpoint=$islive?'https://finix.live-payments-api.com':'https://finix.sandbox-payments-api.com';
        $card=merchantsController::createPaymentInstramentMinReq(config("app.api_username"),config("app.api_password"),
        $exp_month,$exp_year,$identity,$name,$card_number,$cvv,"PAYMENT_CARD",$endpoint,[],['tags'=>["userID"=>"userID_".$userID,"api_userID"=>"api_userID_".$api_userID,"apikeyID"=>"apikeyID_".$apikeyID]]);
        if($card[1]>=200&&$card[1]<300){
        $value=(object)json_decode($card[0]);
        $cardMade=self::create([
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
            'transit_number'=>$value->transit_number??null,
            'api_user'=>$api_userID??null,
            'is_live'=>$islive??null,
            "api_key"=>''.$apikeyID
        ]);
        $cardMade->save();
        $cardMade->refresh();
            return ['worked'=>true,"responce"=>$card[0],"ref"=>$cardMade];
        }else{
            return ['worked'=>false,"responce"=>$card[0]];
        }
    }
    public static function makeBank( $bank_account_number,
    $bank_account_type,
    $bank_bank_code,
    $identity,
    $bank_name,
    $bank_type,$userID,$api_userID,$apikeyID=0){
        $islive=false;
        $endpoint=$islive?'https://finix.live-payments-api.com':'https://finix.sandbox-payments-api.com';
        $bank=  merchantsController::createBankAccount(config("app.api_username"),config("app.api_password"),
        $bank_account_number,
        $bank_account_type,
        $bank_bank_code,
        $identity,
        $bank_name,
        $bank_type,$endpoint,[],['tags'=>["userID"=>"userID_".$userID,"api_userID"=>"api_userID_".$api_userID,"apikeyID"=>"apikeyID_".$apikeyID]]);
        if($bank[1]>=200&&$bank[1]<300){
        $value=(object)json_decode($bank[0]);
        $bankMade=self::create([
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
            'transit_number'=>$value->transit_number??null,
            'api_user'=>$api_userID??null,
            'is_live'=>$islive??null,
            "api_key"=>''.$apikeyID
        ]);
        $bankMade->save();
        $bankMade->refresh();
            return ['worked'=>true,"responce"=>$bank[0],"ref"=>$bankMade];
        }else{
            return ['worked'=>false,"responce"=>$bank[0]];
        }
    }
}
