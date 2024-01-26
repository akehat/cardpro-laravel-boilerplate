<?php

namespace App\Models;

use App\Http\Controllers\API\payfacController;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class verifications_live extends Model
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
    use HasFactory;
    protected $table="finix_verifications_live";
    protected $guarded=['id'];
    public static $name='verifications';
    public static function updateFromId_live($id){
        self::fromArray([json_decode(payfacController::fetchVerifications(config("app.api_username"),config("app.api_password"),$id,'https://finix.live-payments-api.com')[0])]);
     }
    public static function runUpdate(){
        $result= payfacController::listVerifications(config("app.api_username"),config("app.api_password"));
        $object=json_decode($result[0]);
        while(isset($object->_embedded)&&isset($object->_embedded->verifications)&&isset($object->page)&&isset($object->page->next_cursor)&&count($object->_embedded->verifications)>0){
            self::fromArray($object->_embedded->verifications);
         $nextArray=['after_cursor'=>$object->page->next_cursor];
         $result= payfacController::listVerifications(config("app.api_username"),config("app.api_password"),'https://finix.live-payments-api.com',$nextArray);
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
                'application' => $data->application ?? null,
                'identity' => $data->identity ?? null,
                'merchant' => $data->merchant ?? null,
                'merchant_identity' => $data->merchant_identity ?? null,
                'messages' => json_encode($data->messages) ?? null,
                'payment_instrument' => $data->payment_instrument ?? null,
                'processor' => $data->processor ?? null,
                'raw' => $data->raw ?? null,
                'state' => $data->state ?? null,
                'tags' => json_encode($data->tags) ?? null,
                'trace_id' => $data->trace_id ?? null,
            ]);
            } else {
                $found->update([
                'finix_id' => $data->id ?? null,
                'finix_created_at' => $data->created_at ?? null,
                'finix_updated_at' => $data->updated_at ?? null,
                'application' => $data->application ?? null,
                'identity' => $data->identity ?? null,
                'merchant' => $data->merchant ?? null,
                'merchant_identity' => $data->merchant_identity ?? null,
                'messages' => json_encode($data->messages) ?? null,
                'payment_instrument' => $data->payment_instrument ?? null,
                'processor' => $data->processor ?? null,
                'raw' => $data->raw ?? null,
                'state' => $data->state ?? null,
                'tags' => json_encode($data->tags) ?? null,
                'trace_id' => $data->trace_id ?? null,
            ]);
            }

            // Save and refresh the model
            $found->save();
            $found->refresh();
        }
    }
}
