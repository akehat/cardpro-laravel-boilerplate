<?php

namespace App\Models;

use App\Http\Controllers\API\merchantsController;
use Carbon\Carbon;
use Doctrine\DBAL\Query;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Authorization extends Model
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
    protected $table = 'authorizations';
    protected $guarded = ['id'];
    public static $name='authorizations';
    public static function updateFromId($id){
       self::fromArray([json_decode(merchantsController::fetchHold(config("app.api_username"),config("app.api_password"),$id)[0])]);
    }
    public static function runUpdate(){
        $result= merchantsController::listHolds(config("app.api_username"),config("app.api_password"));
        $object=json_decode($result[0]);
        while(isset($object->_embedded)&&isset($object->_embedded->autherization)&&isset($object->page)&&isset($object->page->next_cursor)&&count($object->_embedded->autherization)>0){
            Authorization::fromArray($object->_embedded->autherization);
         $nextArray=['after_cursor'=>$object->page->next_cursor];
         $result= merchantsController::listHolds(config("app.api_username"),config("app.api_password"),'https://finix.sandbox-payments-api.com',$nextArray);
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
                    'card_present_details' => json_encode($data->card_present_details??[]) ?? null,
                    'currency' => $data->currency ?? null,
                    'device' => $data->device ?? null,
                    'expires_at' => $data->expires_at ?? null,
                    'failure_code' => $data->failure_code ?? null,
                    'failure_message' => $data->failure_message ?? null,
                    'idempotency_id' => $data->idempotency_id ?? null,
                    'is_void' => $data->is_void ?? false,
                    'merchant_identity' => $data->merchant_identity ?? null,
                    'messages' => json_encode($data->messages??[]) ?? null,
                    'raw' => json_encode($data->raw??[]) ?? null,
                    'security_code_verification' => $data->security_code_verification ?? null,
                    'source' => $data->source ?? null,
                    'state' => $data->state ?? null,
                    'tags' => json_encode($data->tags??[]) ?? null,
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
        $islive=false;
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
            'card_present_details' => json_encode($value->card_present_details??[]) ?? null,
            'currency' => $value->currency ?? null,
            'device' => $value->device ?? null,
            'expires_at' => $value->expires_at ?? null,
            'failure_code' => $value->failure_code ?? null,
            'failure_message' => $value->failure_message ?? null,
            'idempotency_id' => $value->idempotency_id ?? null,
            'is_void' => $value->is_void ?? false,
            'merchant_identity' => $value->merchant_identity ?? null,
            'messages' => json_encode($value->messages??[]) ?? null,
            'raw' => json_encode($value->raw??[]) ?? null,
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
        $islive=false;
        $endpoint=$islive?'https://finix.live-payments-api.com':'https://finix.sandbox-payments-api.com';
        $exists=null;
        if(!empty($api_userID)){
        $exists=self::where('finix_id',$id)->where('api_user', $api_userID)->first();
        }else if(!empty($apikeyID)&&$apikeyID!=0){
        $exists=self::where('finix_id',$id)->where('api_key', $apikeyID)->first();
        }
        if($exists!==null){
            $capture= merchantsController::captureHold(config("app.api_username"),config("app.api_password"),$id,$amount_in_cents,0,$endpoint,[],['tags'=>["api_userID"=>"api_userID_".$api_userID,"apikeyID"=>"apikeyID_".$apikeyID]]);
            if($capture[1]>=200&&$capture[1]<300){
                $value=json_decode($capture[0]);
                $paymentMade=finix_payments::create([
                    'finix_id'=>$value->id??null,
                    'created_at_finix'=>$value->created_at??null,
                    'updated_at_finix'=>$value->updated_at??null,
                    'additional_buyer_charges'=>$value->additional_buyer_charges??null,
                    'additional_healthcare_data'=>$value->additional_healthcare_data??null,
                    'additional_purchase_data'=>$value->additional_purchase_data??null,
                    'address_verification'=>$value->address_verification??null,
                    'amount'=>$value->amount??null,
                    'amount_requested'=>$value->amount_requested??null,
                    'application'=>$value->application??null,
                    'currency'=>$value->currency??null,
                    'destination'=>$value->destination??null,
                    'externally_funded'=>$value->externally_funded??null,
                    'failure_code'=>$value->failure_code??null,
                    'failure_message'=>$value->failure_message??null,
                    'fee'=>$value->fee??null,
                    'idempotency_id'=>$value->idempotency_id??null,
                    'merchant'=>$value->merchant??null,
                    'merchant_identity'=>$value->merchant_identity??null,
                    'messages'=>json_encode($value->messages??[])??null,
                    'parent_transfer'=>$value->parent_transfer??null,
                    'parent_transfer_trace_id'=>$value->parent_transfer_trace_id??null,
                    'raw'=>$value->raw??null,
                    'ready_to_settle_at'=>$value->ready_to_settle_at??null,
                    'receipt_last_printed_at'=>$value->receipt_last_printed_at??null,
                    'security_code_verification'=>$value->security_code_verification??null,
                    'source'=>$value->source??null,
                    'split_transfers'=>json_encode($value->split_transfers??[])??null,
                    'state'=>$value->state??null,
                    'statement_descriptor'=>$value->statement_descriptor??null,
                    'subtype'=>$value->subtype??null,
                    'tags'=>json_encode($value->tags??[])??null,
                    'trace_id'=>$value->trace_id??null,
                    'type'=>$value->type??null,
                    'fee_type'=>$value->fee_type??null,
                    'api_user'=>$api_userID??null,
                    'is_live'=>$islive??null,
                    'api_key'=>''.$apikeyID??null
                ]);
                $paymentMade->save();
                $paymentMade->refresh();
                $merchant=ApiKey::where('live',$islive)->where('merchant_id', $value->merchant)->increment('balance', $value->amount??0, ['increased_at' => Carbon::now()]);
            return ['worked'=>true,"responce"=>$capture[0]];

            }
            return ['worked'=>false,"responce"=>$capture[0]];
        }
        return ['worked'=>false,"responce"=>"We dont have a hold for that user"];
    }
    public static function voidCapture($id,$api_userID,$apikeyID=0){
        $islive=false;
        $endpoint=$islive?'https://finix.live-payments-api.com':'https://finix.sandbox-payments-api.com';
        $exists=null;
        if(!empty($api_userID)){
        $exists=self::where('finix_id',$id)->where('api_user', $api_userID)->first();
        }else if(!empty($apikeyID)&&$apikeyID!=0){
        $exists=self::where('finix_id',$id)->where('api_key', $apikeyID)->first();
        }
        if($exists!==null){
            $refund= merchantsController::releaseHold(config("app.api_username"),config("app.api_password"),$id,true,$endpoint);
            if($refund[1]>=200&&$refund[1]<300){
                self::fromArray([json_decode($refund[0])]);
            return ['worked'=>true,"responce"=>$refund[0]];

            }
            return ['worked'=>false,"responce"=>$refund[0]];
        }
        return ['worked'=>false,"responce"=>"We dont have a hold for that user"];

    }
}
