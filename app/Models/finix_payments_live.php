<?php

namespace App\Models;

use Schema;
use Cache;

use App\Http\Controllers\API\merchantsController;
use Carbon\Carbon;
use DateTime;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class finix_payments_live extends Model
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

 static function getColumnNames($tableName) {
        $cacheKey = 'column_names_' . $tableName;

        // Check if column names for the table are already cached
        if (Cache::has($cacheKey)) {
            return Cache::get($cacheKey);
        }

        // Attempt to fetch a record from the table
        $record = \DB::table($tableName)->first();
        if ($record) {
            // If a record is found, get column names from the record
            $columns = array_keys((array) $record);

            // Cache the column names retrieved from the record
            Cache::forever($cacheKey, $columns);

            return $columns;
        } else {
            // If no record is found, get column names from the schema
            $columns = Schema::getColumnListing($tableName);

            // Cache the column names retrieved from the schema
            // Cache::forever($cacheKey, $columns);

            return $columns;
        }
    }

    public static function ajaxTable($request, $title = 'title')
    {
        $model = new static(); // Instantiate the model to get table name
        $columns = self::getColumnNames($model->getTable());

        if ($request->ajax()) {
            $draw = $request->input('draw');
            $start = $request->input('start');
            $length = $request->input('length');
            $search = $request->input('search.value');
            if ($request->has('order') && count($request->input('order')) > 0) {
               $orderColumnName = $request->input('order.0.name'); // Get the index of the ordered column
                $orderDir = $request->input('order.0.dir'); // Get the order direction
            }

            $query = self::accessible();

            if (!empty($search)) {
                $query->where(function ($query) use ($columns, $search) {
                    foreach ($columns as $column) {
                        $query->orWhere($column, 'like', "%{$search}%");
                    }
                });
            }

            // Apply sorting
            if (isset($orderColumnName) && in_array($orderColumnName, $columns)) {
                $query->orderBy($orderColumnName, $orderDir);
            }

            // For AJAX requests, return data with count and limit applied
            $totalRecords = $query->count();
            $filteredRecords = $query->count();
            $data = $query->skip($start)->take($length)->get();

            return response()->json([
                'draw' => $draw,
                'recordsTotal' => $totalRecords,
                'recordsFiltered' => $filteredRecords,
                'data' => $data,
                'perPage' => $length,
                'columns' => $columns, // Pass columns array
            ]);
        } else {
            // For initial table rendering, return an array of columns
            return view("frontend.pages.portal.tablePaymentViewer", ['columns' => $columns, 'title' => $title]);
        }
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
    public static $name='transfers';
    public static function updateFromId_live($id){
       self::fromArray([json_decode(merchantsController::fetchPayment(config("app.api_username"),config("app.api_password"),$id,'https://finix.live-payments-api.com')[0])]);
    }
    protected $table="finix_payments_live";
    protected $guarded=['id'];
    public static function runUpdate(){
        $result= merchantsController::listPayments(config("app.api_username"),config("app.api_password"));
        $object=json_decode($result[0]);
        while(isset($object->_embedded)&&isset($object->_embedded->transfers)&&isset($object->page)&&isset($object->page->next_cursor)&&count($object->_embedded->transfers)>0){
            self::fromArray($object->_embedded->transfers);
         $nextArray=['after_cursor'=>$object->page->next_cursor];
         $result= merchantsController::listPayments(config("app.api_username"),config("app.api_password"),'https://finix.live-payments-api.com',$nextArray);
         $object=json_decode($result[0]);
        }
     }
    public static function fromArray($array){
        foreach ($array as $value) {
            $value=(object)$value;
$value->created_at = $value->created_at != null ? (new DateTime($value->created_at))->format('Y-m-d H:i:s') : null;
                $value->updated_at = $value->updated_at != null ? (new DateTime($value->updated_at))->format('Y-m-d H:i:s') : null;
            $found=finix_payments::where('finix_id',$value->id)->first();
            if($found==null){
               $found=finix_payments::create([
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
                    'ready_to_settle_at' => $value->ready_to_settle_at != null ? (new DateTime($value->ready_to_settle_at))->format('Y-m-d H:i:s') : null,
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
                    'fee_type'=>$value->fee_type??null
                ]);
            }else{
                $found->update([
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
                    'ready_to_settle_at' => $value->ready_to_settle_at != null ? (new DateTime($value->ready_to_settle_at))->format('Y-m-d H:i:s') : null,
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
                    'fee_type'=>$value->fee_type??null
                ]);
            }
            $found->save();
            $found->refresh();
        }
    }
    public static function makePayment($merchant,$currency,$amount_in_cents,$card,$userID,$api_userID,$apikeyID=0){
        $islive=true;
        $endpoint=$islive?'https://finix.live-payments-api.com':'https://finix.sandbox-payments-api.com';
        $payment=merchantsController::makePaymentMinReq(config("app.api_username"),config("app.api_password"),$merchant,$currency,$amount_in_cents,$card,$endpoint,[],['tags'=>["userID"=>"userID_".$userID,"api_userID"=>"api_userID_".$api_userID,"apikeyID"=>"apikeyID_".$apikeyID]]);
        if($payment[1]>=200&&$payment[1]<300){
        $value=(object)json_decode($payment[0]);
        $paymentMade=self::create([
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
            'ready_to_settle_at' => $value->ready_to_settle_at != null ? (new DateTime($value->ready_to_settle_at))->format('Y-m-d H:i:s') : null,
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
        $merchant=ApiKey::where('live',$islive)->where('merchant_id', $merchant)->increment('balance', $value->amount??0);
            return ['worked'=>true,"responce"=>$payment[0],"ref"=>$paymentMade];
        }else{
            return ['worked'=>false,"responce"=>$payment[0]];
        }
    }
    public static function makeRefund($id,$amount_in_cents,$api_userID,$apikeyID=0){
        $islive=true;

        $endpoint=$islive?'https://finix.live-payments-api.com':'https://finix.sandbox-payments-api.com';
        $exists=null;
        if(!empty($api_userID)){
        $exists=self::where('finix_id',$id)->where('api_user', $api_userID)->first();
        }else if(!empty($apikeyID)&&$apikeyID!=0){
        $exists=self::where('finix_id',$id)->where('api_key', $api_userID)->first();
        }
        if($exists!==null){
            $refund=merchantsController::createRefund(config("app.api_username"),config("app.api_password"),$id,['tags'=>["api_userID"=>"api_userID_".$api_userID,"apikeyID"=>"apikeyID_".$apikeyID,'refund'=>'made']],$amount_in_cents,$endpoint);
            if($refund[1]>=200&&$refund[1]<300){
                $value=json_decode($refund[0]);
                $found=finix_payments::create([
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
                    'ready_to_settle_at' => $value->ready_to_settle_at != null ? (new DateTime($value->ready_to_settle_at))->format('Y-m-d H:i:s') : null,
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

            $found->save();
            $found->refresh();
                $merchant=ApiKey::where('live',$islive)->where('id', $apikeyID)->decrement('balance', $value->amount??0);
            return ['worked'=>true,"responce"=>$refund[0],'ref'=>$found];

            }
            return ['worked'=>false,"responce"=>$refund[0]];

        }
        return ['worked'=>false,"responce"=>"We dont have a payment for that user"];
    }

}
