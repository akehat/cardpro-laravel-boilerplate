<?php

namespace App\Models;

use App\Http\Controllers\API\subscriptionController;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class subscription_enrollments_live extends Model
{
    use HasFactory;
    protected $table="subscription_enrollments_live";
    protected $guarded=['id'];
    public static $name='subscription_enrollments';
    public static function updateFromId_live($id){
        self::fromArray([json_decode(subscriptionController::fetchSubscriptionEnrollment(config("app.api_username"),config("app.api_password"),$id,'https://finix.live-payments-api.com')[0])]);
     }
    public static function runUpdate(){
        $result= subscriptionController::listSubscriptionEnrollments(config("app.api_username"),config("app.api_password"));
        $object=json_decode($result[0]);
        while(isset($object->_embedded)&&isset($object->_embedded->subscription_enrollments)&&isset($object->page)&&isset($object->page->next_cursor)&&count($object->_embedded->subscription_enrollments)>0){
            self::fromArray($object->_embedded->subscription_enrollments);
         $nextArray=['after_cursor'=>$object->page->next_cursor];
         $result= subscriptionController::listSubscriptionEnrollments(config("app.api_username"),config("app.api_password"),'https://finix.live-payments-api.com',$nextArray);
         $object=json_decode($result[0]);
        }
     }
    public static function fromArray($array){
        foreach ($array as $value) {
            $value=(object)$value;
            $found=self::where('finix_id',$value->id)->first();
            if($found==null){
               $found=self::create([
                'finix_id' => $value->id ?? null,
                'nickname' => $value->nickname ?? null,
                'started_at' => $value->started_at ?? null,
                'ended_at' => $value->ended_at ?? null,
                'created_by' => $value->created_by ?? null,
                'merchant' => $value->merchant ?? null,
                'subscription_schedule' => $value->subscription_schedule ?? null,
                'tags' => json_encode($value->tags) ?? null,
            ]);
            }else{
                $found->update([
                    'finix_id' => $value->id ?? null,
                    'nickname' => $value->nickname ?? null,
                    'started_at' => $value->started_at ?? null,
                    'ended_at' => $value->ended_at ?? null,
                    'created_by' => $value->created_by ?? null,
                    'merchant' => $value->merchant ?? null,
                    'subscription_schedule' => $value->subscription_schedule ?? null,
                    'tags' => json_encode($value->tags) ?? null,
                ]);
            }
            $found->save();
            $found->refresh();
        }
    }
}
