<?php

namespace App\Models;

use Exception;
use App\Http\Controllers\API\merchantsController;
use Auth;
use Cache;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Schema;

class Dispute_Evidence_Live extends Model
{
    use HasFactory;


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
protected $table = 'dispute_evidence';
protected $guarded = ['id'];
public static $name='evidences';
public static function updateFromIds($id,$evidenceid){
   self::fromArray([json_decode(merchantsController::fetchEvidenceAboutDispute(config("app.api_username"),config("app.api_password"),$id,$evidenceid,'https://finix.live-payments-api.com')[0])]);
}
public static function runUpdateWithID($id){
    $result= merchantsController::listEvidenceAboutDispute(config("app.api_username"),config("app.api_password"),$id,'https://finix.live-payments-api.com');
    $object=json_decode($result[0]);
    while(isset($object->_embedded)&&isset($object->_embedded->evidences)&&isset($object->page)&&isset($object->page->next_cursor)&&count($object->_embedded->evidences)>0){
        self::fromArray($object->_embedded->evidences);
     $nextArray=['after_cursor'=>$object->page->next_cursor];
     $result= merchantsController::listEvidenceAboutDispute(config("app.api_username"),config("app.api_password"),'https://finix.live-payments-api.com',$nextArray);
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

        if ($found == null) {
            $found = self::create([
                'finix_id' => $data->id,
                'finix_created_at' => Carbon::parse($data->created_at),
                'finix_updated_at' => Carbon::parse($data->updated_at),
                'application' => $data->application,
                'dispute' => $data->dispute,
                'identity' => $data->identity,
                'merchant' => $data->merchant,
                'state' => $data->state,
                'tags' => json_encode($data->tags ?? []), // If 'tags' is not set, default to an empty object
            ]);
        } else {
            $found->update([
                'finix_id' => $data->id,
                'finix_created_at' => Carbon::parse($data->created_at),
                'finix_updated_at' => Carbon::parse($data->updated_at),
                'application' => $data->application,
                'dispute' => $data->dispute,
                'identity' => $data->identity,
                'merchant' => $data->merchant,
                'state' => $data->state,
                'tags' => json_encode($data->tags ?? []),
            ]);
        }
        self::checkForOwner($data,$found);
        // Save and refresh the model
        $found->save();
        $found->refresh();
    }
}
public static function checkForOwner($data,$model){
    $found=Finix_Merchant_live::where('finix_id',$data->merchant)->first();
    if($found!=null){
        $model->api_user=$found->api_user;
        $model->is_live=$found->is_live;
        $model->api_key=$found->api_key;
        return;
    }
    $found=identities_live::where('finix_id',$data->identity)->first();
    if($found!=null){
        $model->api_user=$found->api_user;
        $model->is_live=$found->is_live;
        $model->api_key=$found->api_key;
        return;
    }
}
public static function uploadFileAsEvidence($id,$filepath,$userID,$api_userID,$apikeyID=0){
    $islive=true;
    $endpoint=$islive?'https://finix.live-payments-api.com':'https://finix.sandbox-payments-api.com';
    $evidence=merchantsController::uploadFileToProveDispute(config("app.api_username"),config("app.api_password"),$id,$filepath,$endpoint,[],['tags'=>["userID"=>"userID_".$userID,"api_userID"=>"api_userID_".$api_userID,"apikeyID"=>"apikeyID_".$apikeyID]]);
    if($evidence[1]>=200&&$evidence[1]<300){
    $value=(object)json_decode($evidence[0]);
    $evidenceMade=self::create([
        'finix_id' => $value->id,
        'finix_created_at' => Carbon::parse($value->created_at),
        'finix_updated_at' => Carbon::parse($value->updated_at),
        'application' => $value->application,
        'dispute' => $value->dispute,
        'identity' => $value->identity,
        'merchant' => $value->merchant,
        'state' => $value->state,
        'tags' => json_encode($value->tags ?? []),
        'api_user'=>$api_userID??null,
        'is_live'=>$islive??null,
        'api_key'=>''.$apikeyID??null
    ]);
    $evidenceMade->save();
    $evidenceMade->refresh();
        return ['worked'=>true,"responce"=>$evidence[0],"ref"=>$evidenceMade];
    }else{
        return ['worked'=>false,"responce"=>$evidence[0]];
    }
}
public static function downloadEvidence($id,$evidenceid){
    return response()->stream(function () use ($id, $evidenceid) {
        $islive = true;
        $endpoint = $islive ? 'https://finix.live-payments-api.com' : 'https://finix.sandbox-payments-api.com';
        list($response, $httpcode) = merchantsController::downloadDisputeEvidence(config("app.api_username"), config("app.api_password"), $id, $evidenceid, $endpoint);

        // Check if cURL request was successful
        if ($httpcode === 200) {
            echo $response;
        } else {
            // Handle error, for example:
            echo "Error downloading file. HTTP code: $httpcode and response: $response";
        }
    }, 200, [
        'Content-Type' => 'application/octet-stream',
        'Content-Disposition' => 'attachment; filename="downloaded-file"'
    ]);
}
}
