<?php

namespace App\Models;

use Exception;

use Schema;
use Cache;

use App\Http\Controllers\API\merchantsController;
use DateTime;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Finix_Disputes_live extends Model
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
        if ($api_key > 1 && $api_key !== null) {
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
    if ($api_key > 1 && $api_key !== null) {
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
    if ($api_key > 1 && $api_key !== null) {
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
    protected $table="finix_disputes_live";
    protected $guarded=['id'];
    public static $name='disputes';
    public static function updateFromId_live($id){
        self::fromArray([json_decode(merchantsController::fetchDispute(config("app.api_username"),config("app.api_password"),$id,'https://finix.live-payments-api.com')[0])]);
     }
    public static function runUpdate(){
        $result= merchantsController::listDisputes(config("app.api_username"),config("app.api_password"),'https://finix.live-payments-api.com');
        $object=json_decode($result[0]);
        while(isset($object->_embedded)&&isset($object->_embedded->disputes)&&isset($object->page)&&isset($object->page->next_cursor)&&count($object->_embedded->disputes)>0){
            self::fromArray($object->_embedded->disputes);
         $nextArray=['after_cursor'=>$object->page->next_cursor];
         $result= merchantsController::listDisputes(config("app.api_username"),config("app.api_password"),'https://finix.live-payments-api.com',$nextArray);
         $object=json_decode($result[0]);
        }
     }
      public static function readTags($found, $tags){
    $tags=(object)($tags??[]);
    if (isset($tags->api_userID)) {
        try {
            $api_userID_tag = str_replace("api_userID_", "", $tags->api_userID);
            $api_userID_tag = intval($api_userID_tag);
            if (!empty($api_userID_tag)) {
                $found->api_user = $api_userID_tag;
            }
        } catch (Exception $e) {
            // Handle exception, if any
            // For example, log the error or set a default value
        }
    }

    if (isset($tags->apikeyID)) {
        try {
            $apikeyID_tag = str_replace("apikeyID_", "", $tags->apikeyID);
            $apikeyID_tag = intval($apikeyID_tag);
            if (!empty($apikeyID_tag)) {
                $found->api_key = $apikeyID_tag;
            }
        } catch (Exception $e) {
            // Handle exception, if any
            // For example, log the error or set a default value
        }
    }
}

public static function fromArray(array $array)
    {
        foreach ($array as $data) {
            $data = (object)$data;

            $found = self::where('finix_id', $data->id)->first();
            $data->created_at = $data->created_at != null ? (new DateTime($data->created_at))->format('Y-m-d H:i:s') : null;
            $data->updated_at = $data->updated_at != null ? (new DateTime($data->updated_at))->format('Y-m-d H:i:s') : null;

            if ($found == null) {
                $found = self::create([
                    'finix_id' => $data->id ?? null,
                    'finix_created_at' => $data->created_at ?? null,
                    'finix_updated_at' => $data->updated_at ?? null,
                    'action' => $data->action ?? null,
                    'amount' => $data->amount ?? null,
                    'application' => $data->application ?? null,
                    'dispute_details' => json_encode($data->dispute_details ?? []) ?? null,
                    'identity' => $data->identity ?? null,
                    'merchant' => $data->merchant ?? null,
                    'occurred_at' => $data->occurred_at ?? null,
                    'reason' => $data->reason ?? null,
                    'respond_by' => $data->respond_by ?? null,
                    'state' => $data->state ?? null,
                    'tags' => json_encode($data->tags ?? []) ?? null,
                    'transfer' => $data->transfer ?? null,
                ]);
            } else {
                $found->update([
                    'finix_id' => $data->id ?? null,
                    'finix_created_at' => $data->created_at ?? null,
                    'finix_updated_at' => $data->updated_at ?? null,
                    'action' => $data->action ?? null,
                    'amount' => $data->amount ?? null,
                    'application' => $data->application ?? null,
                    'dispute_details' => json_encode($data->dispute_details ?? []) ?? null,
                    'identity' => $data->identity ?? null,
                    'merchant' => $data->merchant ?? null,
                    'occurred_at' => $data->occurred_at ?? null,
                    'reason' => $data->reason ?? null,
                    'respond_by' => $data->respond_by ?? null,
                    'state' => $data->state ?? null,
                    'tags' => json_encode($data->tags ?? []) ?? null,
                    'transfer' => $data->transfer ?? null,
                ]);
            }
            self::checkForOwner($data,$found);
            self::readTags($found,($data->tags??(object)[]));
// Save and refresh the model new
            $found->save();
            $found->refresh();
            Dispute_Evidence_live::runUpdateWithID($found->finix_id);
        }
    }
    public static function checkForOwner($data,$model){
        $found=Finix_Merchant_live::where('finix_id',$data->merchant)->first();
        if($found!=null){
            $model->api_userID=$found->api_userID;
            $model->islive=$found->islive;
            $model->apikeyID=$found->api_user;
            return;
        }
        $found=identities_live::where('finix_id',$data->merchant)->first();
        if($found!=null){
            $model->api_userID=$found->api_userID;
            $model->islive=$found->islive;
            $model->apikeyID=$found->api_user;
            return;
        }
    }

public static function uploadNoteEvidence($id,$note,$userID,$api_userID,$apikeyID=0){
    $islive=true;
    $endpoint=$islive?'https://finix.live-payments-api.com':'https://finix.sandbox-payments-api.com';
    $evidence=merchantsController::submitDisputeEvidence(config("app.api_username"),config("app.api_password"),$id,$note,$endpoint,[],['tags'=>["userID"=>"userID_".$userID,"api_userID"=>"api_userID_".$api_userID,"apikeyID"=>"apikeyID_".$apikeyID]]);
    if($evidence[1]>=200&&$evidence[1]<300){
    $value=(object)json_decode($evidence[0]);
    $value->created_at = $value->created_at != null ? (new DateTime($value->created_at))->format('Y-m-d H:i:s') : null;
    $value->updated_at = $value->updated_at != null ? (new DateTime($value->updated_at))->format('Y-m-d H:i:s') : null;

    $data=[
        'finix_id' => $value->id ?? null,
        'finix_created_at' => $value->created_at ?? null,
        'finix_updated_at' => $value->updated_at ?? null,
        'action' => $value->action ?? null,
        'amount' => $value->amount ?? null,
        'application' => $value->application ?? null,
        'dispute_details' => json_encode($value->dispute_details ?? []) ?? null,
        'identity' => $value->identity ?? null,
        'merchant' => $value->merchant ?? null,
        'occurred_at' => $value->occurred_at ?? null,
        'reason' => $value->reason ?? null,
        'respond_by' => $value->respond_by ?? null,
        'state' => $value->state ?? null,
        'tags' => json_encode($value->tags ?? []) ?? null,
        'transfer' => $value->transfer ?? null,
        'api_user'=>$api_userID??null,
        'is_live'=>$islive??null,
        'api_key'=>''.$apikeyID??null
    ];
    $found = self::where('finix_id', $value->id)->first();
            if($found!=null){
                $evidenceMade=$found->update($data);
            }else{
                $evidenceMade=self::create($data);
            }
    $evidenceMade->save();
    $evidenceMade->refresh();
        return ['worked'=>true,"responce"=>$evidence[0],"ref"=>$evidenceMade];
    }else{
        return ['worked'=>false,"responce"=>$evidence[0]];
    }
}

public static function acceptDispute($id,$note,$userID,$api_userID,$apikeyID=0){
    $islive=true;
    $endpoint=$islive?'https://finix.live-payments-api.com':'https://finix.sandbox-payments-api.com';
    $acceptedDispute=merchantsController::acceptADispute(config("app.api_username"),config("app.api_password"),$id,$note,$endpoint,[],['tags'=>["userID"=>"userID_".$userID,"api_userID"=>"api_userID_".$api_userID,"apikeyID"=>"apikeyID_".$apikeyID]]);
    if($acceptedDispute[1]>=200&&$acceptedDispute[1]<300){
    $value=(object)json_decode($acceptedDispute[0]);
    $value->created_at = $value->created_at != null ? (new DateTime($value->created_at))->format('Y-m-d H:i:s') : null;
    $value->updated_at = $value->updated_at != null ? (new DateTime($value->updated_at))->format('Y-m-d H:i:s') : null;
    $data=[
        'finix_id' => $value->id ?? null,
        'finix_created_at' => $value->created_at ?? null,
        'finix_updated_at' => $value->updated_at ?? null,
        'action' => $value->action ?? null,
        'amount' => $value->amount ?? null,
        'application' => $value->application ?? null,
        'dispute_details' => json_encode($value->dispute_details ?? []) ?? null,
        'identity' => $value->identity ?? null,
        'merchant' => $value->merchant ?? null,
        'occurred_at' => $value->occurred_at ?? null,
        'reason' => $value->reason ?? null,
        'respond_by' => $value->respond_by ?? null,
        'state' => $value->state ?? null,
        'tags' => json_encode($value->tags ?? []) ?? null,
        'transfer' => $value->transfer ?? null,
        'api_user'=>$api_userID??null,
        'is_live'=>$islive??null,
        'api_key'=>''.$apikeyID??null
    ];
    $found = self::where('finix_id', $value->id)->first();
            if($found!=null){
                $acceptedDisputeMade=$found->update($data);
            }else{
                $acceptedDisputeMade=self::create($data);
            }
    $acceptedDisputeMade->save();
    $acceptedDisputeMade->refresh();
        return ['worked'=>true,"responce"=>$acceptedDispute[0],"ref"=>$acceptedDisputeMade];
    }else{
        return ['worked'=>false,"responce"=>$acceptedDispute[0]];
    }
}
}
