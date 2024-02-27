<?php

namespace App\Models;

use Schema;
use Cache;

use App\Http\Controllers\API\merchantsController;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Finix_Merchant extends Model
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

    public static function showTable($request, $title = 'title')
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
            $queryCount = self::accessible()->count();
            if ($queryCount < config('app.json_table_limit')) {
                $array['data'] = self::accessible()->get()->toArray();
                $array['next_page_url'] = null;
                $array['prev_page_url'] = null;
                $array['data'] = isset($array['data']) ? $array['data'] : null;
                return view("frontend.pages.portal.jsonViewer", [
                    "json" => str_replace(['\\', '`'], ['\\\\', '｀'], json_encode((object) [$array['data']], JSON_PRETTY_PRINT)),
                    'next' => $array['next_page_url'],
                    'prev' => $array['prev_page_url'],
                    'title' => $title
                ]);
            } else {
                return view("frontend.pages.portal.tableViewer", ['columns' => $columns, 'title' => $title]);
            }
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
    public static function authenticateGetIDWithUserID($id, $api_userID , $api_key)
    {
        if(($api_userID > 1 || $api_userID === null) && ($api_key > 1 || $api_key === null)) return false;

            // If the API key is not a sub key, no need to query the database
            return self::where('api_user', $api_userID)
                ->where(function ($query) use ($id) {
            $query->where('id', $id)
                  ->orWhere('finix_id', $id);
        })
                ->first();
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
    protected $table="finix_merchants";
    protected $guarded=['id'];
    public static $name='merchants';
    public static function updateFromId($id){
       self::fromArray([json_decode(merchantsController::fetchMerchant(config("app.api_username"),config("app.api_password"),$id)[0])]);
    }

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
public static function makeMerchant($merchantIdentity,$userID,$api_userID,$apikeyID=0){
    $islive=false;
    $endpoint=$islive?'https://finix.live-payments-api.com':'https://finix.sandbox-payments-api.com';
    $processor=$islive?merchantsController::$processors[1]:merchantsController::$processors[0];
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
'api_user'=>$api_userID,
'identity'=>$merchantMade->finix_id,
'userID'=>$userID
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
    if (ApiKey::where('api_key', $apiKey)->exists()) {
        // If it exists, generate a new API key
        return self::generateApiKey($length);
    }else{
        return $apiKey;
    }
}
}
