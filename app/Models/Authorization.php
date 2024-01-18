<?php

namespace App\Models;

use App\Http\Controllers\API\merchantsController;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Authorization extends Model
{
    use HasFactory;
    protected $table = 'authorizations';
    protected $guarded = ['id'];
    public static function runUpdate(){
        $result= merchantsController::listHolds(config("app.api_username"),config("app.api_password"));
        $object=json_decode($result[0]);
        while(isset($object->_embedded)&&isset($object->_embedded->autherization)&&isset($object->page)&&isset($object->page->next_cursor)&&count($object->_embedded->autherization)>0){
            Authorization::fromArray($object->_embedded->autherization);
         $nextArray=['after_cursor'=>$object->page->next_cursor];
         $result= merchantsController::listHolds(config("app.api_username"),config("app.api_password"),'https://finix.sandbox-payments-api.com',$nextArray);
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
                    '3ds_redirect_url' => $data->{'3ds_redirect_url'} ?? null,
                    'additional_buyer_charges' => $data->additional_buyer_charges ?? null,
                    'additional_healthcare_data' => $data->additional_healthcare_data ?? null,
                    'address_verification' => $data->address_verification ?? null,
                    'amount' => $data->amount ?? null,
                    'amount_requested' => $data->amount_requested ?? null,
                    'application' => $data->application ?? null,
                    'card_present_details' => json_encode($data->card_present_details) ?? null,
                    'currency' => $data->currency ?? null,
                    'device' => $data->device ?? null,
                    'expires_at' => $data->expires_at ?? null,
                    'failure_code' => $data->failure_code ?? null,
                    'failure_message' => $data->failure_message ?? null,
                    'idempotency_id' => $data->idempotency_id ?? null,
                    'is_void' => $data->is_void ?? false,
                    'merchant_identity' => $data->merchant_identity ?? null,
                    'messages' => json_encode($data->messages) ?? null,
                    'raw' => json_encode($data->raw) ?? null,
                    'security_code_verification' => $data->security_code_verification ?? null,
                    'source' => $data->source ?? null,
                    'state' => $data->state ?? null,
                    'tags' => json_encode($data->tags) ?? null,
                    'trace_id' => $data->trace_id ?? null,
                    'transfer' => $data->transfer ?? null,
                    'void_state' => $data->void_state ?? null,
                ]);
            } else {
                $found->update([
                    'created_at' => $data->created_at ?? null,
                    'updated_at' => $data->updated_at ?? null,
                    '3ds_redirect_url' => $data->{'3ds_redirect_url'} ?? null,
                    'additional_buyer_charges' => $data->additional_buyer_charges ?? null,
                    'additional_healthcare_data' => $data->additional_healthcare_data ?? null,
                    'address_verification' => $data->address_verification ?? null,
                    'amount' => $data->amount ?? null,
                    'amount_requested' => $data->amount_requested ?? null,
                    'application' => $data->application ?? null,
                    'card_present_details' => json_encode($data->card_present_details) ?? null,
                    'currency' => $data->currency ?? null,
                    'device' => $data->device ?? null,
                    'expires_at' => $data->expires_at ?? null,
                    'failure_code' => $data->failure_code ?? null,
                    'failure_message' => $data->failure_message ?? null,
                    'idempotency_id' => $data->idempotency_id ?? null,
                    'is_void' => $data->is_void ?? false,
                    'merchant_identity' => $data->merchant_identity ?? null,
                    'messages' => json_encode($data->messages) ?? null,
                    'raw' => json_encode($data->raw) ?? null,
                    'security_code_verification' => $data->security_code_verification ?? null,
                    'source' => $data->source ?? null,
                    'state' => $data->state ?? null,
                    'tags' => json_encode($data->tags) ?? null,
                    'trace_id' => $data->trace_id ?? null,
                    'transfer' => $data->transfer ?? null,
                    'void_state' => $data->void_state ?? null,
                ]);
            }

            // Save and refresh the model
            $found->save();
            $found->refresh();
        }
    }
}
