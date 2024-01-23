<?php

namespace App\Models;

use App\Http\Controllers\API\payfacController;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BalanceTransfer extends Model
{
    use HasFactory;
    protected $table = 'finix_balance_transfers';
    protected $guarded = ['id'];
    public static $name='balance_transfers';
    public static function updateFromId($id){
       self::fromArray([json_decode(payfacController::fetchBalanceTransfers(config("app.api_username"),config("app.api_password"),$id)[0])]);
    }
    public static function runUpdate(){
        $result= payfacController::listBalanceTransfers(config("app.api_username"),config("app.api_password"));
        $object=json_decode($result[0]);
        while(isset($object->_embedded)&&isset($object->_embedded->balance_transfers)&&isset($object->page)&&isset($object->page->next_cursor)&&count($object->_embedded->balance_transfers)>0){
            self::fromArray($object->_embedded->balance_transfers);
         $nextArray=['after_cursor'=>$object->page->next_cursor];
         $result= payfacController::listBalanceTransfers(config("app.api_username"),config("app.api_password"),'https://finix.sandbox-payments-api.com',$nextArray);
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
                    'amount' => $data->amount ?? null,
                    'currency' => $data->currency ?? null,
                    'description' => $data->description ?? null,
                    'destination' => $data->destination ?? null,
                    'external_reference_id' => $data->external_reference_id ?? null,
                    'processor_type' => $data->processor_type ?? null,
                    'reference_id' => $data->reference_id ?? null,
                    'source' => $data->source ?? null,
                    'state' => $data->state ?? null,
                    'tags' => json_encode($data->tags) ?? null,
                ]);
            } else {
                $found->update([
                    'finix_id' => $data->id ?? null,
                    'finix_created_at' => $data->created_at ?? null,
                    'finix_updated_at' => $data->updated_at ?? null,
                    'amount' => $data->amount ?? null,
                    'currency' => $data->currency ?? null,
                    'description' => $data->description ?? null,
                    'destination' => $data->destination ?? null,
                    'external_reference_id' => $data->external_reference_id ?? null,
                    'processor_type' => $data->processor_type ?? null,
                    'reference_id' => $data->reference_id ?? null,
                    'source' => $data->source ?? null,
                    'state' => $data->state ?? null,
                    'tags' => json_encode($data->tags) ?? null,
                ]);
            }

            // Save and refresh the model
            $found->save();
            $found->refresh();
        }
    }
}
