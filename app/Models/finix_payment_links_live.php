<?php

namespace App\Models;

use App\Http\Controllers\API\merchantsController;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class finix_payment_links_live extends Model
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
    protected $table="finix_payment_links_live";
    protected $guarded=['id'];
    public static $name='payment_links';
    public static function updateFromId_live($id){
       self::fromArray([json_decode(merchantsController::fetchPaymentLink(config("app.api_username"),config("app.api_password"),$id,'https://finix.live-payments-api.com')[0])]);
    }
    public static function runUpdate(){
        $result= merchantsController::listPaymentLink(config("app.api_username"),config("app.api_password"));
        $object=json_decode($result[0]);
        while(isset($object->_embedded)&&isset($object->_embedded->payment_links)&&isset($object->page)&&isset($object->page->next_cursor)&&count($object->_embedded->payment_links)>0){
            self::fromArray($object->_embedded->payment_links);
         $nextArray=['after_cursor'=>$object->page->next_cursor];
         $result= merchantsController::listPaymentLink(config("app.api_username"),config("app.api_password"),'https://finix.live-payments-api.com',$nextArray);
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

public static function makePaymentLink($amount_details_amount_type,
$amount_details_total_amount,
$amount_details_currency,
$amount_details_amount_breakdown_subtotal_amount,
$amount_details_amount_breakdown_shipping_amount,
$amount_details_amount_breakdown_estimated_tax_amount,
$amount_details_amount_breakdown_discount_amount,
$amount_details_amount_breakdown_tip_amount,
$branding_brand_color,
$branding_accent_color,
$branding_logo,
$branding_icon,
$additional_details_collect_name,
$additional_details_collect_email,
$additional_details_collect_phone_number,
$additional_details_collect_billing_address,
$additional_details_collect_shipping_address,
$additional_details_success_return_url,
$additional_details_cart_return_url,
$additional_details_expired_session_url,
$additional_details_terms_of_service_url,
$merchant,
$allowed_payment_methods_0,
$nickname,
$items_0_image_details_primary_image_url,
$items_0_image_details_alternative_image_urls_0,
$items_0_image_details_alternative_image_urls_1,
$description,
$items_0_price_details_sale_amount,
$items_0_price_details_currency,
$items_0_price_details_price_type,
$items_0_price_details_regular_amount,
$buyer,$userID,$api_userID,$apikeyID=0){
    $islive=true;
    $endpoint=$islive?'https://finix.live-payments-api.com':'https://finix.sandbox-payments-api.com';
    $paymentLink=merchantsController::createPaymentLinkMinReq(config("app.api_username"),config("app.api_password"),
        $amount_details_amount_type,
        $amount_details_total_amount,
        $amount_details_currency,
        null,null,
        $amount_details_amount_breakdown_subtotal_amount,
        $amount_details_amount_breakdown_shipping_amount,
        $amount_details_amount_breakdown_estimated_tax_amount,
        $amount_details_amount_breakdown_discount_amount,
        $amount_details_amount_breakdown_tip_amount,
        $branding_brand_color,
        $branding_accent_color,
        $branding_logo,
        $branding_icon,
        $additional_details_collect_name??'false',
        $additional_details_collect_email??'false',
        $additional_details_collect_phone_number??'false',
        $additional_details_collect_billing_address??'false',
        $additional_details_collect_shipping_address??'false',
        $additional_details_success_return_url,
      $additional_details_cart_return_url,
        $additional_details_expired_session_url,
        $additional_details_terms_of_service_url,
        $merchant,
        false,
        [$allowed_payment_methods_0],
        $nickname,
        ["primary_image_url" =>  $items_0_image_details_primary_image_url,
        "alternative_image_urls_0" => $items_0_image_details_alternative_image_urls_0,
        "alternative_image_urls_1" => $items_0_image_details_alternative_image_urls_1],
        $description,
        ["sale_amount" => $items_0_price_details_sale_amount,
        "currency" => $items_0_price_details_currency,
         "price_type" => $items_0_price_details_price_type,
        "regular_amount" => $items_0_price_details_regular_amount],
        1,$buyer,
        $endpoint,[],['tags'=>["userID"=>"userID_".$userID,"api_userID"=>"api_userID_".$api_userID,"apikeyID"=>"apikeyID_".$apikeyID]]
);
    if($paymentLink[1]>=200&&$paymentLink[1]<300){
    $value=(object)json_decode($paymentLink[0]);
    $paymentLinkMade=self::create([
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
        'api_user'=>$api_userID??null,
        'is_live'=>$islive??null,
        'api_key'=>''.$apikeyID??null
    ]);
    $paymentLinkMade->save();
    $paymentLinkMade->refresh();

        return ['worked'=>true,"responce"=>$paymentLink[0],"ref"=>$paymentLinkMade];
    }else{
        return ['worked'=>false,"responce"=>$paymentLink[0]];
    }
}
}
