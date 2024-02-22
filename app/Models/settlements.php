<?php

namespace App\Models;

use App\Http\Controllers\API\merchantsController;
use DateTime;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class settlements extends Model
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
    protected $table="settlements";
    protected $guarded=['id'];
    public static $name='settlements';
    public static function updateFromId($id){
        self::fromArray([json_decode(merchantsController::fetchSettlement(config("app.api_username"),config("app.api_password"),$id)[0])]);
     }
    public static function runUpdate(){
        $result= merchantsController::listSettlements(config("app.api_username"),config("app.api_password"));
        $object=json_decode($result[0]);
        while(isset($object->_embedded)&&isset($object->_embedded->settlements)&&isset($object->page)&&isset($object->page->next_cursor)&&count($object->_embedded->settlements)>0){
            settlements::fromArray($object->_embedded->settlements);
         $nextArray=['after_cursor'=>$object->page->next_cursor];
         $result= merchantsController::listSettlements(config("app.api_username"),config("app.api_password"),'https://finix.sandbox-payments-api.com',$nextArray);
         $object=json_decode($result[0]);
        }
     }
    public static function fromArray($array){
        foreach ($array as $value) {
            $value=(object)$value;
$value->created_at = $value->created_at != null ? (new DateTime($value->created_at))->format('Y-m-d H:i:s') : null;
                $value->updated_at = $value->updated_at != null ? (new DateTime($value->updated_at))->format('Y-m-d H:i:s') : null;
            $found=settlements::where('finix_id',$value->id)->first();
            if($found==null){
               $found=settlements::create([
                'finix_id'=>$value->id??null,
                'created_at_finix'=>$value->created_at??null,
                'updated_at_finix'=>$value->updated_at??null,
                'application'=>$value->application??null,
                'currency'=>$value->currency??null,
                'destination'=>$value->destination??null,
                'funds_flow'=>$value->funds_flow??null,
                'identity'=>$value->identity??null,
                'merchant_id'=>$value->merchant_id??null,
                'net_amount'=>$value->net_amount??null,
                'payment_type'=>$value->payment_type??null,
                'processor'=>$value->processor??null,
                'status'=>$value->status??null,
                'tags'=>json_encode($value->tags??[])??null,
                ]);
            }else{
                $found->update([
                    'created_at_finix'=>$value->created_at??null,
                    'updated_at_finix'=>$value->updated_at??null,
                    'application'=>$value->application??null,
                    'currency'=>$value->currency??null,
                    'destination'=>$value->destination??null,
                    'funds_flow'=>$value->funds_flow??null,
                    'identity'=>$value->identity??null,
                    'merchant_id'=>$value->merchant_id??null,
                    'net_amount'=>$value->net_amount??null,
                    'payment_type'=>$value->payment_type??null,
                    'processor'=>$value->processor??null,
                    'status'=>$value->status??null,
                    'tags'=>json_encode($value->tags??[])??null,
                    ]);
            }
            $found->save();
            $found->refresh();
        }
    }

}
