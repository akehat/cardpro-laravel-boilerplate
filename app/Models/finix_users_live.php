<?php

namespace App\Models;

use Exception;

use Schema;
use Cache;

use App\Http\Controllers\API\finixUsersController;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class finix_users_live extends Model
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

  static function forgetColumnNames() {
        $cacheKey = 'column_names_' . (new static())->getTable();
        if (Cache::has($cacheKey)) {
            Cache::forget($cacheKey);
        }
    }
static function getRemovedNames($tableName, $allcolumns) {
        $cacheKey = 'removed_names_' . $tableName;
        if (Cache::has($cacheKey)) {
            $removed = Cache::get($cacheKey);
        } else {
            $record = removed_items::where('table', $cacheKey)->first();
            if ($record != null) {
                $removed = (array)json_decode($record->json);
                Cache::forever($cacheKey, $removed);
            } else {
                $removed = [];
                Cache::forever($cacheKey, []);
            }
        }
        if($allcolumns==false){return $removed;}
        // Filtering out removed columns from allcolumns
        $filteredColumns = array_diff($allcolumns, $removed);

        return $filteredColumns;
    }

    static function setRemovedNames($tableName, $array) {
        $cacheKey = 'removed_names_' . $tableName;
        $record = removed_items::where('table', $cacheKey)->first();
        if ($record != null) {
            $record->json = json_encode($array);
            $record->save();
             Cache::forget($cacheKey);
            Cache::forever($cacheKey, $array);
        } else {
            $removed = removed_items::create([
                'table' => $cacheKey,
                'json' => json_encode($array)
            ]);
            $removed ->save();
             $removed ->refresh();
            Cache::forget($cacheKey);
            Cache::forever($cacheKey, $array);
        }
    }

    static function getColumnNames($tableName, $all = false) {
        $cacheKey = 'column_names_' . $tableName;

        // Check if column names for the table are already cached
        if (Cache::has($cacheKey)) {
            $columns = Cache::get($cacheKey);
            if ($all) {
                return $columns;
            }
            return self::getRemovedNames($tableName, $columns);
        }

        // Attempt to fetch a record from the table
        $record = \DB::table($tableName)->first();
        if ($record) {
            // If a record is found, get column names from the record
            $columns = array_keys((array)$record);

            // Cache the column names retrieved from the record
            Cache::forever($cacheKey, $columns);
            if ($all) {
                return $columns;
            }
            return self::getRemovedNames($tableName, $columns);
        } else {
            // If no record is found, get column names from the schema
            $columns = Schema::getColumnListing($tableName);

            // Cache the column names retrieved from the schema
            Cache::forever($cacheKey, $columns);
            if ($all) {
                return $columns;
            }
            return self::getRemovedNames($tableName, $columns);
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

            $query = self::accessible()->select($columns);

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
                $array['data'] = self::accessible()->select($columns)->get()->toArray();
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
    public static $name='users';
    public static function updateFromId_live($id){
       self::fromArray([json_decode(finixUsersController::fetchAUser(config("app.api_username"),config("app.api_password"),$id,'https://finix.live-payments-api.com')[0])]);
    }
    protected $table="finix_users_live";
    protected $guarded=['id'];
    public static function runUpdate(){
        $result= finixUsersController::listAllUsers(config("app.api_username"),config("app.api_password"),'https://finix.live-payments-api.com');
        $object=json_decode($result[0]);
        while(isset($object->_embedded)&&isset($object->_embedded->users)&&isset($object->page)&&isset($object->page->next_cursor)&&count($object->_embedded->users)>0){
            finix_users::fromArray($object->_embedded->users);
         $nextArray=['after_cursor'=>$object->page->next_cursor];
         $result= finixUsersController::listAllUsers(config("app.api_username"),config("app.api_password"),'https://finix.live-payments-api.com',$nextArray);
         $object=json_decode($result[0]);
        }
     }
    public static function fromArray($array){
        foreach ($array as $value) {
            $value=(object)$value;
            $found=finix_users::where('finix_id',$value->id)->first();
            if($found==null){
                $found=finix_users::create([
                    'finix_id'=>$value->id,
                    'enabled'=>$value->enabled??null,
                    'identity'=>$value->identity??null,
                    'last_used_date'=>$value->last_used_date??null,
                    'password'=>$value->password??null,
                    'tags'=>json_encode($value->tags ?? [])??null,
                    'role'=>$value->role??null,
                ]);
            }else{
                $found->update([
                    'finix_id'=>$value->id,
                    'enabled'=>$value->enabled??null,
                    'identity'=>$value->identity??null,
                    'last_used_date'=>$value->last_used_date??null,
                    'password'=>$value->password??null,
                    'tags'=>json_encode($value->tags ?? [])??null,
                    'role'=>$value->role??null,
                ]);
            }
            $found->save();
            $found->refresh();
        }
    }
}
