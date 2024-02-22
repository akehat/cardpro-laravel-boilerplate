<?php

namespace App\Models;

use App\Http\Controllers\API\payfacController;
use App\Http\Controllers\API\subscriptionController;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class subscription_schedules extends Model
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

 public static function ajaxTable($request, $title = 'title')
    {
        $model = new static(); // Instantiate the model to get table name
        $columns = \Schema::getColumnListing($model->getTable());

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
            return view("frontend.pages.portal.tableViewer", ['columns' => $columns, 'title' => $title]);
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
    protected $table="subscription_schedules";
    protected $guarded=['id'];
    public static $name='subscription_schedules';
    public static function updateFromId($id){
        self::fromArray([json_decode(subscriptionController::fetchSubscriptionSchedule(config("app.api_username"),config("app.api_password"),$id)[0])]);
     }
    public static function runUpdate(){
        $result= subscriptionController::listSubscriptionSchedule(config("app.api_username"),config("app.api_password"));
        $object=json_decode($result[0]);
        while(isset($object->_embedded)&&isset($object->_embedded->subscription_schedules)&&isset($object->page)&&isset($object->page->next_cursor)&&count($object->_embedded->subscription_schedules)>0){
            self::fromArray($object->_embedded->subscription_schedules);
         $nextArray=['after_cursor'=>$object->page->next_cursor];
         $result= subscriptionController::listSubscriptionSchedule(config("app.api_username"),config("app.api_password"),'https://finix.sandbox-payments-api.com',$nextArray);
         $object=json_decode($result[0]);
        }
     }
    public static function fromArray($array){
        foreach ($array as $value) {
            $value=(object)$value;
            $found=self::where('finix_id',$value->id)->first();
            if($found==null){
               $found=self::create([
                'subscription_schedules' => json_encode($value->subscription_schedules) ?? null,
                'metadata' => json_encode($value->metadata) ?? null,
                'finix_id' => $value->id ?? null,
                'nickname' => $value->nickname ?? null,
                'line_item_type' => $value->line_item_type ?? null,
                'subscription_type' => $value->subscription_type ?? null,
            ]);
            }else{
                $found->update([
                    'subscription_schedules' => json_encode($value->subscription_schedules) ?? null,
                    'metadata' => json_encode($value->metadata) ?? null,
                    'finix_id' => $value->id ?? null,
                    'nickname' => $value->nickname ?? null,
                    'line_item_type' => $value->line_item_type ?? null,
                    'subscription_type' => $value->subscription_type ?? null,
                ]);
            }
            $found->save();
            $found->refresh();
            subscription_amounts::runUpdateWithID($found->finix_id);
        }
    }

}
