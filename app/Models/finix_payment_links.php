<?php

namespace App\Models;

use App\Http\Controllers\API\merchantsController;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class finix_payment_links extends Model
{
    use HasFactory;
    protected $table="finix_payment_links";
    protected $guarded=['id'];

    public static function runUpdate(){
        $result= merchantsController::listPaymentLink(config("app.api_username"),config("app.api_password"));
        $object=json_decode($result[0]);
        while(isset($object->_embedded)&&isset($object->_embedded->payment_links)&&isset($object->page)&&isset($object->page->next_cursor)&&count($object->_embedded->payment_links)>0){
            self::fromArray($object->_embedded->payment_links);
         $nextArray=['after_cursor'=>$object->page->next_cursor];
         $result= merchantsController::listPaymentLink(config("app.api_username"),config("app.api_password"),'https://finix.sandbox-payments-api.com',$nextArray);
         $object=json_decode($result[0]);
        }
     }
    public static function fromArray($array)
{
    foreach ($array as $value) {
        $value = (object)$value;
        $found = self::where('finix_id', $value->id)->first();

        if ($found == null) {
            $found = self::create([
                'finix_id' => $value->id ?? null,
                'created_at_finix' => $value->created_at ?? null,
                'updated_at_finix' => $value->updated_at ?? null,
                'application_id' => $value->application_id ?? null,
                'merchant_id' => $value->merchant_id ?? null,
                'payment_frequency' => $value->payment_frequency ?? null,
                'is_multiple_use' => $value->is_multiple_use ?? null,
                'allowed_payment_methods' => json_encode($value->allowed_payment_methods ?? []) ?? null,
                'nickname' => $value->nickname ?? null,
                'items' => json_encode($value->items ?? []) ?? null,
                'buyer_details' => json_encode($value->buyer_details ?? []) ?? null,
                'amount_details' => json_encode($value->amount_details ?? []) ?? null,
                'branding' => json_encode($value->branding ?? []) ?? null,
                'additional_details' => json_encode($value->additional_details ?? []) ?? null,
                'state' => $value->state ?? null,
                'tags' => json_encode($value->tags ?? []) ?? null,
                'link_url' => $value->link_url ?? null,
                'link_expires_at' => $value->link_expires_at ?? null,
                '_links' => json_encode($value->_links ?? []) ?? null,
            ]);
        } else {
            $found->update([
                'finix_id' => $value->id ?? null,
                'created_at_finix' => $value->created_at ?? null,
                'updated_at_finix' => $value->updated_at ?? null,
                'application_id' => $value->application_id ?? null,
                'merchant_id' => $value->merchant_id ?? null,
                'payment_frequency' => $value->payment_frequency ?? null,
                'is_multiple_use' => $value->is_multiple_use ?? null,
                'allowed_payment_methods' => json_encode($value->allowed_payment_methods ?? []) ?? null,
                'nickname' => $value->nickname ?? null,
                'items' => json_encode($value->items ?? []) ?? null,
                'buyer_details' => json_encode($value->buyer_details ?? []) ?? null,
                'amount_details' => json_encode($value->amount_details ?? []) ?? null,
                'branding' => json_encode($value->branding ?? []) ?? null,
                'additional_details' => json_encode($value->additional_details ?? []) ?? null,
                'state' => $value->state ?? null,
                'tags' => json_encode($value->tags ?? []) ?? null,
                'link_url' => $value->link_url ?? null,
                'link_expires_at' => $value->link_expires_at ?? null,
                '_links' => json_encode($value->_links ?? []) ?? null,
            ]);
        }

        $found->save();
        $found->refresh();
    }
}

}
