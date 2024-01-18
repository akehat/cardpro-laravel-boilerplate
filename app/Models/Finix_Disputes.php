<?php

namespace App\Models;

use App\Http\Controllers\API\merchantsController;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Finix_Disputes extends Model
{
    use HasFactory;
    protected $table="finix_disputes";
    protected $guarded=['id'];
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
                    'created_at' => $data->created_at ?? null,
                    'updated_at' => $data->updated_at ?? null,
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
                    'created_at' => $data->created_at ?? null,
                    'updated_at' => $data->updated_at ?? null,
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
