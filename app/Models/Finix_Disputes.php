<?php

namespace App\Models;

use App\Http\Controllers\API\merchantsController;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Finix_Disputes extends Model
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
    protected $table="finix_disputes";
    protected $guarded=['id'];
    public static $name='disputes';
    public static function updateFromId($id){
        self::fromArray([json_decode(merchantsController::fetchDispute(config("app.api_username"),config("app.api_password"),$id)[0])]);
     }
    public static function runUpdate(){
        $result= merchantsController::listDisputes(config("app.api_username"),config("app.api_password"));
        $object=json_decode($result[0]);
        while(isset($object->_embedded)&&isset($object->_embedded->disputes)&&isset($object->page)&&isset($object->page->next_cursor)&&count($object->_embedded->disputes)>0){
            self::fromArray($object->_embedded->disputes);
         $nextArray=['after_cursor'=>$object->page->next_cursor];
         $result= merchantsController::listDisputes(config("app.api_username"),config("app.api_password"),'https://finix.sandbox-payments-api.com',$nextArray);
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
                    'finix_created_at' => $data->created_at ?? null,
                    'finix_updated_at' => $data->updated_at ?? null,
                    'action' => $data->action ?? null,
                    'amount' => $data->amount ?? null,
                    'application' => $data->application ?? null,
                    'dispute_details' => json_encode($data->dispute_details) ?? null,
                    'identity' => $data->identity ?? null,
                    'merchant' => $data->merchant ?? null,
                    'occurred_at' => $data->occurred_at ?? null,
                    'reason' => $data->reason ?? null,
                    'respond_by' => $data->respond_by ?? null,
                    'state' => $data->state ?? null,
                    'tags' => json_encode($data->tags) ?? null,
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
                    'dispute_details' => json_encode($data->dispute_details) ?? null,
                    'identity' => $data->identity ?? null,
                    'merchant' => $data->merchant ?? null,
                    'occurred_at' => $data->occurred_at ?? null,
                    'reason' => $data->reason ?? null,
                    'respond_by' => $data->respond_by ?? null,
                    'state' => $data->state ?? null,
                    'tags' => json_encode($data->tags) ?? null,
                    'transfer' => $data->transfer ?? null,
                ]);
            }

            // Save and refresh the model
            $found->save();
            $found->refresh();
        }
    }
}
