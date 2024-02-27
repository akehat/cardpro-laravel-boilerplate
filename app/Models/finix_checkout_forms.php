<?php

namespace App\Models;

use Schema;
use Cache;

use App\Http\Controllers\API\formController;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class finix_checkout_forms extends Model
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

 static function getColumnNames($tableName) {
        $cacheKey = 'column_names_' . $tableName;

        // Check if column names for the table are already cached
        if (Cache::has($cacheKey)) {
            return Cache::get($cacheKey);
        }

        // Attempt to fetch a record from the table
        $record = \DB::table($tableName)->first();
        if ($record) {
            // If a record is found, get column names from the record
            $columns = array_keys((array) $record);

            // Cache the column names retrieved from the record
            Cache::forever($cacheKey, $columns);

            return $columns;
        } else {
            // If no record is found, get column names from the schema
            $columns = Schema::getColumnListing($tableName);

            // Cache the column names retrieved from the schema
            // Cache::forever($cacheKey, $columns);

            return $columns;
        }
    }

    public static function showTable($request, $title = 'title')
    {
        $model = new static(); // Instantiate the model to get table name
        $columns = self::getColumnNames($model->getTable());

        if ($request->ajax()) {
            $draw = $request->input('draw');
            $start = $request->input('start');
            $length = $request->input('length');
            $search = $request->input('search.value');
            if ($request->has('order') && count($request->input('order')) > 0) {
               $orderColumnName = $request->input('order.0.name'); // Get the index of the ordered column
                $orderDir = $request->input('order.0.dir'); // Get the order direction
            }

            $query = self::accessible();

            if (!empty($search)) {
                $query->where(function ($query) use ($columns, $search) {
                    foreach ($columns as $column) {
                        $query->orWhere($column, 'like', "%{$search}%");
                    }
                });
            }

            // Apply sorting
            if (isset($orderColumnName) && in_array($orderColumnName, $columns)) {
                $query->orderBy($orderColumnName, $orderDir);
            }

            // For AJAX requests, return data with count and limit applied
            $totalRecords = $query->count();
            $filteredRecords = $query->count();
            $data = $query->skip($start)->take($length)->get();

            return response()->json([
                'draw' => $draw,
                'recordsTotal' => $totalRecords,
                'recordsFiltered' => $filteredRecords,
                'data' => $data,
                'perPage' => $length,
                'columns' => $columns, // Pass columns array
            ]);
        } else {
            $queryCount = self::accessible()->count();
            if ($queryCount < config('app.json_table_limit')) {
                $array['data'] = self::accessible()->get()->toArray();
                $array['next_page_url'] = null;
                $array['prev_page_url'] = null;
                $array['data'] = isset($array['data']) ? $array['data'] : null;
                return view("frontend.pages.portal.jsonViewer", [
                    "json" => str_replace(['\\', '`'], ['\\\\', '｀'], json_encode((object) [$array['data']], JSON_PRETTY_PRINT)),
                    'next' => $array['next_page_url'],
                    'prev' => $array['prev_page_url'],
                    'title' => $title
                ]);
            } else {
                return view("frontend.pages.portal.tableViewer", ['columns' => $columns, 'title' => $title]);
            }
        }
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
   public static function authenticateGet($api_userID, $api_key)
{
    $perPage = 20; // Default items per page

    if (($api_userID > 1 || $api_userID === null) && ($api_key > 1 || $api_key === null)) {
        return false;
    }

    // Check if the API key is a sub key
    if ($api_key > 1 || $api_key === null) {
        return self::where('api_key', $api_key)
            ->where('api_user', $api_userID)
            ->paginate($perPage);
    } else {
        // If the API key is not a sub key, no need to query the database
        return self::where('api_user', $api_userID)
            ->paginate($perPage);
    }
}
public static function authenticateSearch($api_userID, $api_key, $search)
{
    $columns = \Schema::getColumnListing((new self())->getTable());
    $perPage = 20; // Default items per page

    if (($api_userID > 1 || $api_userID === null) && ($api_key > 1 || $api_key === null)) {
        return false;
    }

    // Check if the API key is a sub key
    if ($api_key > 1 || $api_key === null) {
        return self::where('api_key', $api_key)
            ->where('api_user', $api_userID)
            ->where(function ($query) use ($columns, $search) {
                foreach ($columns as $column) {
                    $query->orWhere($column, 'like', "%{$search}%");
                }
            })
            ->paginate($perPage);
    } else {
        // If the API key is not a sub key, no need to query the database
        return self::where('api_user', $api_userID)
            ->where(function ($query) use ($columns, $search) {
                foreach ($columns as $column) {
                    $query->orWhere($column, 'like', "%{$search}%");
                }
            })
            ->paginate($perPage);
    }
}


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
                    'allowed_payment_methods' => json_encode($data->allowed_payment_methods??[]) ?? null,
                    'nickname' => $data->nickname ?? null,
                    'items' => json_encode($data->items??[]) ?? null,
                    'buyer' => json_encode($data->buyer??[]) ?? null,
                    'amount_details' => json_encode($data->amount_details??[]) ?? null,
                    'branding' => json_encode($data->branding??[]) ?? null,
                    'additional_details' => json_encode($data->additional_details??[]) ?? null,
                ]);
            } else {
                $found->update([
                    'merchant_id' => $data->merchant_id ?? null,
                    'payment_frequency' => $data->payment_frequency ?? null,
                    'is_multiple_use' => $data->is_multiple_use ?? null,
                    'allowed_payment_methods' => json_encode($data->allowed_payment_methods??[]) ?? null,
                    'nickname' => $data->nickname ?? null,
                    'items' => json_encode($data->items??[]) ?? null,
                    'buyer' => json_encode($data->buyer??[]) ?? null,
                    'amount_details' => json_encode($data->amount_details??[]) ?? null,
                    'branding' => json_encode($data->branding??[]) ?? null,
                    'additional_details' => json_encode($data->additional_details??[]) ?? null,
                ]);
            }

            // Save and refresh the model
            $found->save();
            $found->refresh();
        }
    }

public static function makeCheckout($amount_details_amount_type,
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
    $islive=false;
    $endpoint=$islive?'https://finix.live-payments-api.com':'https://finix.sandbox-payments-api.com';
    $checkout=formController::createCheckoutForm(config("app.api_username"),config("app.api_password"),
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
    if($checkout[1]>=200&&$checkout[1]<300){
    $value=(object)json_decode($checkout[0]);
    $checkoutMade=self::create([
        'finix_id' => $value->id ?? null,
        'application' => $value->application ?? null,
        'card_cvv_required' => $value->card_cvv_required ?? null,
        'card_expiration_date_required' => $value->card_expiration_date_required ?? null,
        'convenience_charges_enabled' => $value->convenience_charges_enabled ?? null,
        'country' => $value->country ?? null,
        'creating_transfer_from_report_enabled' => $value->creating_transfer_from_report_enabled ?? null,
        'currencies' => json_encode($value->currencies??[]) ?? null,
        'default_partial_authorization_enabled' => $value->default_partial_authorization_enabled ?? null,
        'disbursements_ach_pull_enabled' => $value->disbursements_ach_pull_enabled ?? null,
        'disbursements_ach_push_enabled' => $value->disbursements_ach_push_enabled ?? null,
        'disbursements_card_pull_enabled' => $value->disbursements_card_pull_enabled ?? null,
        'disbursements_card_push_enabled' => $value->disbursements_card_push_enabled ?? null,
        'fee_ready_to_settle_upon' => $value->fee_ready_to_settle_upon ?? null,
        'gateway' => $value->gateway ?? null,
        'gross_settlement_enabled' => $value->gross_settlement_enabled ?? null,
        'identity' => $value->identity ?? null,
        'level_two_level_three_value_enabled' => $value->level_two_level_three_value_enabled ?? null,
        'mcc' => $value->mcc ?? null,
        'merchant_name' => $value->merchant_name ?? null,
        'merchant_profile' => $value->merchant_profile ?? null,
        'mid' => $value->mid ?? null,
        'onboarding_state' => $value->onboarding_state ?? null,
        'processing_enabled' => $value->processing_enabled ?? null,
        'processor' => $value->processor ?? null,
        'processor_details' => json_encode($value->processor_details??[]) ?? null,
        'ready_to_settle_upon' => $value->ready_to_settle_upon ?? null,
        'rent_surcharges_enabled' => $value->rent_surcharges_enabled ?? null,
        'settlement_enabled' => $value->settlement_enabled ?? null,
        'settlement_funding_identifier' => $value->settlement_funding_identifier ?? null,
        'surcharges_enabled' => $value->surcharges_enabled ?? null,
        'tags' => json_encode($value->tags??[]) ?? null,
        'verification' => $value->verification ?? null,
        '_links' => $value->_links ?? null,
        'api_user'=>$api_userID??null,
        'is_live'=>$islive??null,
        'api_key'=>''.$apikeyID??null
    ]);
    $checkoutMade->save();
    $checkoutMade->refresh();

        return ['worked'=>true,"responce"=>$checkout[0],"ref"=>$checkoutMade];
    }else{
        return ['worked'=>false,"responce"=>$checkout[0]];
    }
}
    }

