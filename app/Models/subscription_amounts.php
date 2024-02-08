<?php

namespace App\Models;

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
