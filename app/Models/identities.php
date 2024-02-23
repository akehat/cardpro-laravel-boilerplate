<?php

namespace App\Models;

use Schema;
use Cache;

use App\Http\Controllers\API\merchantsController;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class identities extends Model
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

    public static function ajaxTable($request, $title = 'title')
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
            // For initial table rendering, return an array of columns
            return view("frontend.pages.portal.tableViewer", ['columns' => $columns, 'title' => $title]);
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

public static function authenticateGetCustomerByID($id, $api_userID , $api_key)
{
    if(($api_userID > 1 || $api_userID === null) && ($api_key > 1 || $api_key === null)) return false;
    // Check if the API key is a sub key
    if ($api_key > 1 || $api_key === null) {
        return self::where(function ($query) use ($id) {
            $query->where('id', $id)
                  ->orWhere('finix_id', $id);
        })
            ->where('api_key', $api_key)
            ->where('isBuyer', 1)
            ->where('api_user', $api_userID)
            ->first();
    } else {
        // If the API key is not a sub key, no need to query the database
        return self::where('api_user', $api_userID)
            ->where('isBuyer', 1)
            ->where(function ($query) use ($id) {
                $query->where('id', $id)
                      ->orWhere('finix_id', $id);
            })
            ->first();
    }
}
public static function authenticateGetCustomer( $api_userID , $api_key)
{
    $perPage = 20; // Default items per page
    if(($api_userID > 1 || $api_userID === null) && ($api_key > 1 || $api_key === null)) return false;
    // Check if the API key is a sub key
    if ($api_key > 1 || $api_key === null) {
        return self::where('api_key', $api_key)
            ->where('api_user', $api_userID)
            ->where('isBuyer', 1)
            ->paginate($perPage);

    } else {
        // If the API key is not a sub key, no need to query the database
        return self::where('api_user', $api_userID)
        ->where('isBuyer', 1)
        ->paginate($perPage);

    }
}

public static function authenticateSearchCustomer($api_userID, $api_key, $search)
{
    $columns = \Schema::getColumnListing((new self)->getTable());
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
public static function authenticateGetMerchantByID($id, $api_userID , $api_key)
{
    if(($api_userID > 1 || $api_userID === null) && ($api_key > 1 || $api_key === null)) return false;
    // Check if the API key is a sub key
    if ($api_key > 1 || $api_key === null) {
        return self::where(function ($query) use ($id) {
            $query->where('id', $id)
                  ->orWhere('finix_id', $id);
        })
            ->where('api_key', $api_key)
            ->where('isMerchant', 1)
            ->where('api_user', $api_userID)
            ->first();
    } else {
        // If the API key is not a sub key, no need to query the database
        return self::where('api_user', $api_userID)
            ->where('isMerchant', 1)
            ->where(function ($query) use ($id) {
                $query->where('id', $id)
                      ->orWhere('finix_id', $id);
            })
            ->first();
    }
}
public static function authenticateGetMerchant( $api_userID , $api_key)
{
    $perPage = 20; // Default items per page

    if(($api_userID > 1 || $api_userID === null) && ($api_key > 1 || $api_key === null)) return false;
    // Check if the API key is a sub key
    if ($api_key > 1 || $api_key === null) {
        return self::where('api_key', $api_key)
            ->where('api_user', $api_userID)
            ->where('isMerchant', 1)
            ->paginate($perPage);

    } else {
        // If the API key is not a sub key, no need to query the database
        return self::where('api_user', $api_userID)
        ->where('isMerchant', 1)
        ->paginate($perPage);

    }
}

    use HasFactory;
    protected $table="identities";
    protected $guarded=['id'];
    public static $name='identities';
    public static function updateFromId($id){
       self::fromArray([json_decode(merchantsController::fetchIDIdentity(config("app.api_username"),config("app.api_password"),$id)[0])]);
    }
    public static function runUpdate(){
        $result= merchantsController::listIdentities(config("app.api_username"),config("app.api_password"));
        $object=json_decode($result[0]);
        while(isset($object->_embedded)&&isset($object->_embedded->identities)&&isset($object->page)&&isset($object->page->next_cursor)&&count($object->_embedded->identities)>0){
            identities::fromArray($object->_embedded->identities);
         $nextArray=['after_cursor'=>$object->page->next_cursor];
         $result= merchantsController::listIdentities(config("app.api_username"),config("app.api_password"),'https://finix.sandbox-payments-api.com',$nextArray);
         $object=json_decode($result[0]);
        }
     }
    public static function fromArray($array){
        foreach ($array as $value) {
            $value=(object)$value;
            $found=identities::where('finix_id',$value->id)->first();
            if($found==null){
               $found=identities::create([
                'application'=>$value->application??null,
                'entity'=>json_encode($value->entity??[])??null,
                'identity_roles'=>json_encode($value->identity_roles??[])??null,
                'tags'=>json_encode($value->tags??[])??null,
                'finix_id'=>$value->id??null
                ]);
            }else{
                $found->update([
                    'application'=>$value->application??null,
                    'entity'=>json_encode($value->entity??[])??null,
                    'identity_roles'=>json_encode($value->identity_roles??[])??null,
                    'tags'=>json_encode($value->tags??[])??null,
                    'finix_id'=>$value->id??null
                    ]);
            }
            $found->save();
            $found->refresh();
        }
    }
    public static function makeMerchantIdentity($entity_annual_card_volume,
    $entity_business_address_city,
    $entity_business_address_country,
    $entity_business_address_region,
    $entity_business_address_line2,
    $entity_business_address_line1,
    $entity_business_address_postal_code,
    $entity_business_name,
    $entity_business_phone,
    $entity_business_tax_id,
    $entity_business_type,
    $entity_default_statement_descriptor,
    $entity_dob_year,
    $entity_dob_day,
    $entity_dob_month,
    $entity_doing_business_as,
    $entity_email,
    $entity_first_name,
    $entity_has_accepted_credit_cards_previously,
    $entity_incorporation_date_year,
    $entity_incorporation_date_day,
    $entity_incorporation_date_month,
    $entity_last_name,
    $entity_max_transaction_amount,
    $entity_ach_max_transaction_amount,
    $entity_mcc,
    $entity_ownership_type,
    $entity_personal_address_city,
    $entity_personal_address_country,
    $entity_personal_address_region,
    $entity_personal_address_line2,
    $entity_personal_address_line1,
    $entity_personal_address_postal_code,
    $entity_phone,
    $entity_principal_percentage_ownership,
    $entity_tax_id,
    $entity_title,
    $entity_url,$userID,$api_userID){
        $islive=false;
        $endpoint=$islive?'https://finix.live-payments-api.com':'https://finix.sandbox-payments-api.com';
        $merchant=merchantsController::createIdentityMerchantMinReq(config("app.api_username"),config("app.api_password"),
        $entity_annual_card_volume,
        $entity_business_address_city,
        $entity_business_address_country,
        $entity_business_address_region,
        $entity_business_address_line2,
        $entity_business_address_line1,
        $entity_business_address_postal_code,
        $entity_business_name,
        $entity_business_phone,
        $entity_business_tax_id,
        $entity_business_type,
        $entity_default_statement_descriptor,
        $entity_dob_year,
        $entity_dob_day,
        $entity_dob_month,
        $entity_doing_business_as,
        $entity_email,
        $entity_first_name,
        $entity_has_accepted_credit_cards_previously??'false',
        $entity_incorporation_date_year,
        $entity_incorporation_date_day,
        $entity_incorporation_date_month,
        $entity_last_name,
        $entity_max_transaction_amount,
        $entity_ach_max_transaction_amount,
        $entity_mcc,
        $entity_ownership_type,
        $entity_personal_address_city,
        $entity_personal_address_country,
        $entity_personal_address_region,
        $entity_personal_address_line2,
        $entity_personal_address_line1,
        $entity_personal_address_postal_code,
        $entity_phone,
        $entity_principal_percentage_ownership,
        $entity_tax_id,
        $entity_title,
        $entity_url,$endpoint,[],['tags'=>["userID"=>"userID_".$userID,"api_userID"=>"api_userID_".$api_userID]]);
        if($merchant[1]>=200&&$merchant[1]<300){
        $value=(object)json_decode($merchant[0]);
        $merchantMade=self::create([
            'application'=>$value->application??null,
            'entity'=>json_encode($value->entity??[])??null,
            'identity_roles'=>json_encode($value->identity_roles??[])??null,
            'tags'=>json_encode($value->tags??[])??null,
            'finix_id'=>$value->id??null,
            'api_user'=>$api_userID??null,
            'is_live'=>$islive??null,
            'isBuyer'=>false,
            'isMerchant'=>true,
        ]);
        $merchantMade->save();
        $merchantMade->refresh();
            return ['worked'=>true,"responce"=>$merchant[0],"ref"=>$merchantMade];
        }else{
            return ['worked'=>false,"responce"=>$merchant[0]];
        }
    }
       public static function makeBuyerIdentity($email,$userID,$api_userID,$apikeyID=0){
        $islive=false;
        $endpoint=$islive?'https://finix.live-payments-api.com':'https://finix.sandbox-payments-api.com';
        $buyer=merchantsController::createIdentityBuyerMinReq(config("app.api_username"),config("app.api_password"),$email,$endpoint,[],['tags'=>["userID"=>"userID_".$userID,"api_userID"=>"api_userID_".$api_userID,"apikeyID"=>"apikeyID_".$apikeyID]]);
        if($buyer[1]>=200&&$buyer[1]<300){
        $value=(object)json_decode($buyer[0]);
        $buyerMade=self::create([
            'application'=>$value->application??null,
            'entity'=>json_encode($value->entity??[])??null,
            'identity_roles'=>json_encode($value->identity_roles??[])??null,
            'tags'=>json_encode($value->tags??[])??null,
            'finix_id'=>$value->id??null,
            'api_user'=>$api_userID??null,
            'is_live'=>$islive??null,
            "api_key"=>''.$apikeyID,
            'isBuyer'=>true,
            'isMerchant'=>false,
        ]);
        $buyerMade->save();
        $buyerMade->refresh();
            return ['worked'=>true,"responce"=>$buyer[0],"ref"=>$buyerMade];
        }else{
            return ['worked'=>false,"responce"=>$buyer[0]];
        }
    }
}
