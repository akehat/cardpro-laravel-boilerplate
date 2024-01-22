<?php

namespace App\Models;

use App\Http\Controllers\API\formController;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class finix_checkout_forms extends Model
{
    use HasFactory;
    protected $table="finix_checkout_forms";
    protected $guarded=['id'];
    public static $name='checkout_forms';
    public static function updateFromId($id){
       self::fromArray([json_decode(formController::fetchCheckoutForm(config("app.api_username"),config("app.api_password"),$id)[0])]);
    }
    public static function runUpdate(){
        $result= formController::listCheckoutForm(config("app.api_username"),config("app.api_password"));
        $object=json_decode($result[0]);
        while(isset($object->_embedded)&&isset($object->_embedded->checkout_forms)&&isset($object->page)&&isset($object->page->next_cursor)&&count($object->_embedded->checkout_forms)>0){
            finix_checkout_forms::fromArray($object->_embedded->checkout_forms);
         $nextArray=['after_cursor'=>$object->page->next_cursor];
         $result= formController::listCheckoutForm(config("app.api_username"),config("app.api_password"),'https://finix.sandbox-payments-api.com',$nextArray);
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
                    'merchant_id' => $data->merchant_id ?? null,
                    'finix_id' => $data->id ?? null,
                    'payment_frequency' => $data->payment_frequency ?? null,
                    'is_multiple_use' => $data->is_multiple_use ?? null,
                    'allowed_payment_methods' => json_encode($data->allowed_payment_methods) ?? null,
                    'nickname' => $data->nickname ?? null,
                    'items' => json_encode($data->items) ?? null,
                    'buyer' => json_encode($data->buyer) ?? null,
                    'amount_details' => json_encode($data->amount_details) ?? null,
                    'branding' => json_encode($data->branding) ?? null,
                    'additional_details' => json_encode($data->additional_details) ?? null,
                ]);
            } else {
                $found->update([
                    'merchant_id' => $data->merchant_id ?? null,
                    'payment_frequency' => $data->payment_frequency ?? null,
                    'is_multiple_use' => $data->is_multiple_use ?? null,
                    'allowed_payment_methods' => json_encode($data->allowed_payment_methods) ?? null,
                    'nickname' => $data->nickname ?? null,
                    'items' => json_encode($data->items) ?? null,
                    'buyer' => json_encode($data->buyer) ?? null,
                    'amount_details' => json_encode($data->amount_details) ?? null,
                    'branding' => json_encode($data->branding) ?? null,
                    'additional_details' => json_encode($data->additional_details) ?? null,
                ]);
            }

            // Save and refresh the model
            $found->save();
            $found->refresh();
        }
    }
}
