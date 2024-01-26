<?php

namespace App\Models;

use App\Http\Controllers\API\merchantsController;
use Doctrine\DBAL\Query;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Authorization_live extends Model
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
    use HasFactory;
    protected $table = 'authorizations_live';
    protected $guarded = ['id'];
    public static $name='authorizations';
    public static function updateFromId_live($id){
       self::fromArray([json_decode(merchantsController::fetchHold(config("app.api_username"),config("app.api_password"),$id,'https://finix.live-payments-api.com')[0])]);
    }
    public static function runUpdate(){
        $result= merchantsController::listHolds(config("app.api_username"),config("app.api_password"));
        $object=json_decode($result[0]);
        while(isset($object->_embedded)&&isset($object->_embedded->autherization)&&isset($object->page)&&isset($object->page->next_cursor)&&count($object->_embedded->autherization)>0){
            Authorization::fromArray($object->_embedded->autherization);
         $nextArray=['after_cursor'=>$object->page->next_cursor];
         $result= merchantsController::listHolds(config("app.api_username"),config("app.api_password"),'https://finix.live-payments-api.com',$nextArray);
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
                    'finix_created_at' => $data->created_at ?? null,
                    'finix_updated_at' => $data->updated_at ?? null,
                    '3ds_redirect_url' => $data->{'3ds_redirect_url'} ?? null,
                    'additional_buyer_charges' => $data->additional_buyer_charges ?? null,
                    'additional_healthcare_data' => $data->additional_healthcare_data ?? null,
                    'address_verification' => $data->address_verification ?? null,
                    'amount' => $data->amount ?? null,
                    'amount_requested' => $data->amount_requested ?? null,
                    'application' => $data->application ?? null,
                    'card_present_details' => json_encode($data->card_present_details) ?? null,
                    'currency' => $data->currency ?? null,
                    'device' => $data->device ?? null,
                    'expires_at' => $data->expires_at ?? null,
                    'failure_code' => $data->failure_code ?? null,
                    'failure_message' => $data->failure_message ?? null,
                    'idempotency_id' => $data->idempotency_id ?? null,
                    'is_void' => $data->is_void ?? false,
                    'merchant_identity' => $data->merchant_identity ?? null,
                    'messages' => json_encode($data->messages) ?? null,
                    'raw' => json_encode($data->raw) ?? null,
                    'security_code_verification' => $data->security_code_verification ?? null,
                    'source' => $data->source ?? null,
                    'state' => $data->state ?? null,
                    'tags' => json_encode($data->tags) ?? null,
                    'trace_id' => $data->trace_id ?? null,
                    'transfer' => $data->transfer ?? null,
                    'void_state' => $data->void_state ?? null,
                ]);
            } else {
                $found->update([
                    'finix_created_at' => $data->created_at ?? null,
                    'finix_updated_at' => $data->updated_at ?? null,
                    '3ds_redirect_url' => $data->{'3ds_redirect_url'} ?? null,
                    'additional_buyer_charges' => $data->additional_buyer_charges ?? null,
                    'additional_healthcare_data' => $data->additional_healthcare_data ?? null,
                    'address_verification' => $data->address_verification ?? null,
                    'amount' => $data->amount ?? null,
                    'amount_requested' => $data->amount_requested ?? null,
                    'application' => $data->application ?? null,
                    'card_present_details' => json_encode($data->card_present_details) ?? null,
                    'currency' => $data->currency ?? null,
                    'device' => $data->device ?? null,
                    'expires_at' => $data->expires_at ?? null,
                    'failure_code' => $data->failure_code ?? null,
                    'failure_message' => $data->failure_message ?? null,
                    'idempotency_id' => $data->idempotency_id ?? null,
                    'is_void' => $data->is_void ?? false,
                    'merchant_identity' => $data->merchant_identity ?? null,
                    'messages' => json_encode($data->messages) ?? null,
                    'raw' => json_encode($data->raw) ?? null,
                    'security_code_verification' => $data->security_code_verification ?? null,
                    'source' => $data->source ?? null,
                    'state' => $data->state ?? null,
                    'tags' => json_encode($data->tags) ?? null,
                    'trace_id' => $data->trace_id ?? null,
                    'transfer' => $data->transfer ?? null,
                    'void_state' => $data->void_state ?? null,
                ]);
            }

            // Save and refresh the model
            $found->save();
            $found->refresh();
        }
    }
    public static function makeHold($merchant,$currency,$amount_in_cents,$card,$userID,$api_userID,$apikeyID=0){
        $islive=true;
        $endpoint=$islive?'https://finix.live-payments-api.com':'https://finix.sandbox-payments-api.com';
        $hold=merchantsController::createHoldMinReq(config("app.api_username"),config("app.api_password"),$amount_in_cents,$currency,$merchant,$card,$endpoint,[],['tags'=>["userID"=>"userID_".$userID,"api_userID"=>"api_userID_".$api_userID,"apikeyID"=>"apikeyID_".$apikeyID]]);
        if($hold[1]>=200&&$hold[1]<300){
        $value=(object)json_decode($hold[0]);
        $holdMade=self::create([
            'finix_id' => $value->id ?? null,
            'finix_created_at' => $value->created_at ?? null,
            'finix_updated_at' => $value->updated_at ?? null,
            '3ds_redirect_url' => $value->{'3ds_redirect_url'} ?? null,
            'additional_buyer_charges' => $value->additional_buyer_charges ?? null,
            'additional_healthcare_value' => $value->additional_healthcare_value ?? null,
            'address_verification' => $value->address_verification ?? null,
            'amount' => $value->amount ?? null,
            'amount_requested' => $value->amount_requested ?? null,
            'application' => $value->application ?? null,
            'card_present_details' => json_encode($value->card_present_details) ?? null,
            'currency' => $value->currency ?? null,
            'device' => $value->device ?? null,
            'expires_at' => $value->expires_at ?? null,
            'failure_code' => $value->failure_code ?? null,
            'failure_message' => $value->failure_message ?? null,
            'idempotency_id' => $value->idempotency_id ?? null,
            'is_void' => $value->is_void ?? false,
            'merchant_identity' => $value->merchant_identity ?? null,
            'messages' => json_encode($value->messages) ?? null,
            'raw' => json_encode($value->raw) ?? null,
            'security_code_verification' => $value->security_code_verification ?? null,
            'source' => $value->source ?? null,
            'state' => $value->state ?? null,
            'tags' => json_encode($value->tags) ?? null,
            'trace_id' => $value->trace_id ?? null,
            'transfer' => $value->transfer ?? null,
            'void_state' => $value->void_state ?? null,
            'api_user'=>$api_userID??null,
            'is_live'=>$islive??null,
            'api_key'=>''.$apikeyID??null
        ]);
        $holdMade->save();
        $holdMade->refresh();
            return ['worked'=>true,"responce"=>$hold[0],"ref"=>$holdMade];
        }else{
            return ['worked'=>false,"responce"=>$hold[0]];
        }
    }
    public static function makeCapture($id,$amount_in_cents,$api_userID,$apikeyID=0){
        $islive=true;
        $endpoint=$islive?'https://finix.live-payments-api.com':'https://finix.sandbox-payments-api.com';
        $exists=null;
        if(!empty($api_userID)){
        $exists=self::where('finix_id',$id)->where('api_user', $api_userID)->first();
        }else if(!empty($apikeyID)&&$apikeyID!=0){
        $exists=self::where('finix_id',$id)->where('api_key', $api_userID)->first();
        }
        if($exists!==null){
            merchantsController::captureHold(config("app.api_username"),config("app.api_password"),$id,$amount_in_cents,0,$endpoint,[],['tags'=>["api_userID"=>"api_userID_".$api_userID,"apikeyID"=>"apikeyID_".$apikeyID]]);
        }
    }
    public static function voidCapture($id,$api_userID,$apikeyID=0){
        $islive=true;
        $endpoint=$islive?'https://finix.live-payments-api.com':'https://finix.sandbox-payments-api.com';
        $exists=null;
        if(!empty($api_userID)){
        $exists=self::where('finix_id',$id)->where('api_user', $api_userID)->first();
        }else if(!empty($apikeyID)&&$apikeyID!=0){
        $exists=self::where('finix_id',$id)->where('api_key', $api_userID)->first();
        }
        if($exists!==null){
            merchantsController::releaseHold(config("app.api_username"),config("app.api_password"),$id,true,$endpoint);
        }
    }
}
