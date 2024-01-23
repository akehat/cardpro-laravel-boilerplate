<?php

namespace App\Models;

use App\Http\Controllers\API\payfacController;
use App\Http\Controllers\API\subscriptionController;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class subscription_schedules_live extends Model
{
    use HasFactory;
    protected $table="subscription_schedules_live";
    protected $guarded=['id'];
    public static $name='subscription_schedules';
    public static function updateFromId_live($id){
        self::fromArray([json_decode(subscriptionController::fetchSubscriptionSchedule(config("app.api_username"),config("app.api_password"),$id,'https://finix.live-payments-api.com')[0])]);
     }
    public static function runUpdate(){
        $result= subscriptionController::listSubscriptionSchedule(config("app.api_username"),config("app.api_password"));
        $object=json_decode($result[0]);
        while(isset($object->_embedded)&&isset($object->_embedded->subscription_schedules)&&isset($object->page)&&isset($object->page->next_cursor)&&count($object->_embedded->subscription_schedules)>0){
            self::fromArray($object->_embedded->subscription_schedules);
         $nextArray=['after_cursor'=>$object->page->next_cursor];
         $result= subscriptionController::listSubscriptionSchedule(config("app.api_username"),config("app.api_password"),'https://finix.live-payments-api.com',$nextArray);
         $object=json_decode($result[0]);
        }
     }
    public static function fromArray($array){
        foreach ($array as $value) {
            $value=(object)$value;
            $found=self::where('finix_id',$value->id)->first();
            if($found==null){
               $found=self::create([
                'subscription_schedules' => json_encode($value->subscription_schedules) ?? null,
                'metadata' => json_encode($value->metadata) ?? null,
                'finix_id' => $value->id ?? null,
                'nickname' => $value->nickname ?? null,
                'line_item_type' => $value->line_item_type ?? null,
                'subscription_type' => $value->subscription_type ?? null,
            ]);
            }else{
                $found->update([
                    'subscription_schedules' => json_encode($value->subscription_schedules) ?? null,
                    'metadata' => json_encode($value->metadata) ?? null,
                    'finix_id' => $value->id ?? null,
                    'nickname' => $value->nickname ?? null,
                    'line_item_type' => $value->line_item_type ?? null,
                    'subscription_type' => $value->subscription_type ?? null,
                ]);
            }
            $found->save();
            $found->refresh();
            subscription_amounts::runUpdateWithID($found->finix_id);
        }
    }

}
