<?php

namespace App\Models;

use App\Http\Controllers\API\payfacController;
use DateTime;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Applications extends Model
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
    protected $table = 'applications';
    protected $guarded = ['id'];
    public static $name='applications';
    public static function updateFromId($id){
       self::fromArray([json_decode(payfacController::fetchApplication(config("app.api_username"),config("app.api_password"),$id)[0])]);
    }
    public static function runUpdate(){
        $result= payfacController::listApplications(config("app.api_username"),config("app.api_password"));
        $object=json_decode($result[0]);
        while(isset($object->_embedded)&&isset($object->_embedded->applications)&&isset($object->page)&&isset($object->page->next_cursor)&&count($object->_embedded->applications)>0){
            self::fromArray($object->_embedded->applications);
         $nextArray=['after_cursor'=>$object->page->next_cursor];
         $result= payfacController::listApplications(config("app.api_username"),config("app.api_password"),'https://finix.sandbox-payments-api.com',$nextArray);
         $object=json_decode($result[0]);
        }
     }
    public static function fromArray($array){
        foreach ($array as $value) {
            $value=(object)$value;
      $found=self::where('finix_id',$value->id)->first();
            if($found==null){
                $found=self::create([
                    'finix_id'=>$value->id,
                    'card_cvv_required'=>$value->card_cvv_required??null,
                    'card_expiration_date_required'=>$value->card_expiration_date_required??null,
                    'name'=>$value->name??null,
                    'enabled'=>$value->enabled??null,
                    'processing_enabled'=>$value->processing_enabled??null,
                    'fee_ready_to_settle_upon'=>$value->fee_ready_to_settle_upon??null,
                    'ready_to_settle_upon'=>$value->ready_to_settle_upon??null,
                    'owner'=>$value->owner??null,
                    'settlement_enabled'=>$value->settlement_enabled??null,
                    'settlement_funding_identifier'=>$value->settlement_funding_identifier??null,
                    'creating_transfer_from_report_enabled'=>$value->creating_transfer_from_report_enabled??null,
                ]);

            }else{
                $found->update([
                    'finix_id'=>$value->id,
                    'card_cvv_required'=>$value->card_cvv_required??null,
                    'card_expiration_date_required'=>$value->card_expiration_date_required??null,
                    'name'=>$value->name??null,
                    'enabled'=>$value->enabled??null,
                    'processing_enabled'=>$value->processing_enabled??null,
                    'fee_ready_to_settle_upon'=>$value->fee_ready_to_settle_upon??null,
                    'ready_to_settle_upon'=>$value->ready_to_settle_upon??null,
                    'owner'=>$value->owner??null,
                    'settlement_enabled'=>$value->settlement_enabled??null,
                    'settlement_funding_identifier'=>$value->settlement_funding_identifier??null,
                    'creating_transfer_from_report_enabled'=>$value->creating_transfer_from_report_enabled??null,
                ]);
            }
            $found->save();
            $found->refresh();
        }
    }
}
