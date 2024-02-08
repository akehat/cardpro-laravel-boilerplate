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
    public static function authenticateGet( $api_userID , $api_key)
    {
        if(($api_userID > 1 || $api_userID === null) && ($api_key > 1 || $api_key === null)) return false;
        // Check if the API key is a sub key
        if ($api_key > 1 || $api_key === null) {
            return self::where('api_key', $api_key)
                ->where('api_user', $api_userID)
                ->first();
        } else {
            // If the API key is not a sub key, no need to query the database
            return self::where('api_user', $api_userID)
                ->first();
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
