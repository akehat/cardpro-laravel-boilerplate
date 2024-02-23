<?php

namespace App\Models;

use Schema;
use Cache;

use App\Http\Controllers\API\subscriptionController;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class subscription_amounts extends Model
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
                $array['next_page_url'] = isset($array['next_page_url']) ? $array['next_page_url'] : null;
                $array['prev_page_url'] = isset($array['prev_page_url']) ? $array['prev_page_url'] : null;
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
    protected $table="subscription_amounts";
    protected $guarded=['id'];
    public static $name='subscription_amounts';
    public static function updateFromIds($sub_id,$amount_id){
        self::fromArray([json_decode(subscriptionController::fetchSubscriptionAmount(config("app.api_username"),config("app.api_password"),$sub_id,$amount_id)[0])]);
     }
    public static function runUpdateWithID($sub_id){
        $result= subscriptionController::listSubscriptionAmounts(config("app.api_username"),config("app.api_password"),$sub_id);
        $object=json_decode($result[0]);
        while(isset($object->_embedded)&&isset($object->_embedded->subscription_amounts)&&isset($object->page)&&isset($object->page->next_cursor)&&count($object->_embedded->subscription_amounts)>0){
            self::fromArray($object->_embedded->subscription_amounts);
         $nextArray=['after_cursor'=>$object->page->next_cursor];
         $result= subscriptionController::listSubscriptionAmounts(config("app.api_username"),config("app.api_password"),$sub_id,'https://finix.sandbox-payments-api.com',$nextArray);
         $object=json_decode($result[0]);
        }
     }
    public static function fromArray($array){
        foreach ($array as $value) {
            $value=(object)$value;
            $found=self::where('finix_id',$value->id)->first();
            if($found==null){
               $found=self::create([
                'finix_id' => $value->id ?? null,
                'nickname' => $value->nickname ?? null,
                'amount_type' => $value->amount_type ?? null,
                'amount' => $value->fee_amount_data->amount ?? null,
                'currency' => $value->fee_amount_data->currency ?? null,
                'created_by' => $value->created_by ?? null,
                'fee_amount_data' => json_encode($value->fee_amount_data) ?? null,
                'subscription_schedule' => $value->subscription_schedule ?? null,
                'tags' => json_encode($value->tags) ?? null,
            ]);
            }else{
                $found->update([
                    'finix_id' => $value->id ?? null,
                    'nickname' => $value->nickname ?? null,
                    'amount_type' => $value->amount_type ?? null,
                    'amount' => $value->fee_amount_data->amount ?? null,
                    'currency' => $value->fee_amount_data->currency ?? null,
                    'created_by' => $value->created_by ?? null,
                    'fee_amount_data' => json_encode($value->fee_amount_data) ?? null,
                    'subscription_schedule' => $value->subscription_schedule ?? null,
                    'tags' => json_encode($value->tags) ?? null,
                ]);
            }
            $found->save();
            $found->refresh();
        }
    }
}
