<?php

namespace App\Models;

use App\Http\Controllers\API\merchantsController;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class settlements_live extends Model
{
    use HasFactory;
    protected $table="settlements_live";
    protected $guarded=['id'];
    public static $name='settlements';
    public static function updateFromId_live($id){
        self::fromArray([json_decode(merchantsController::fetchSettlement(config("app.api_username"),config("app.api_password"),$id,'https://finix.live-payments-api.com')[0])]);
     }
    public static function runUpdate(){
        $result= merchantsController::listSettlements(config("app.api_username"),config("app.api_password"));
        $object=json_decode($result[0]);
        while(isset($object->_embedded)&&isset($object->_embedded->settlements)&&isset($object->page)&&isset($object->page->next_cursor)&&count($object->_embedded->settlements)>0){
            settlements::fromArray($object->_embedded->settlements);
         $nextArray=['after_cursor'=>$object->page->next_cursor];
         $result= merchantsController::listSettlements(config("app.api_username"),config("app.api_password"),'https://finix.live-payments-api.com',$nextArray);
         $object=json_decode($result[0]);
        }
     }
    public static function fromArray($array){
        foreach ($array as $value) {
            $value=(object)$value;
            $found=settlements::where('finix_id',$value->id)->first();
            if($found==null){
               $found=settlements::create([
                'finix_id'=>$value->id??null,
                'created_at_finix'=>$value->created_at??null,
                'updated_at_finix'=>$value->updated_at??null,
                'application'=>$value->application??null,
                'currency'=>$value->currency??null,
                'destination'=>$value->destination??null,
                'funds_flow'=>$value->funds_flow??null,
                'identity'=>$value->identity??null,
                'merchant_id'=>$value->merchant_id??null,
                'net_amount'=>$value->net_amount??null,
                'payment_type'=>$value->payment_type??null,
                'processor'=>$value->processor??null,
                'status'=>$value->status??null,
                'tags'=>json_encode($value->tags??[])??null,
                ]);
            }else{
                $found->update([
                    'created_at_finix'=>$value->created_at??null,
                    'updated_at_finix'=>$value->updated_at??null,
                    'application'=>$value->application??null,
                    'currency'=>$value->currency??null,
                    'destination'=>$value->destination??null,
                    'funds_flow'=>$value->funds_flow??null,
                    'identity'=>$value->identity??null,
                    'merchant_id'=>$value->merchant_id??null,
                    'net_amount'=>$value->net_amount??null,
                    'payment_type'=>$value->payment_type??null,
                    'processor'=>$value->processor??null,
                    'status'=>$value->status??null,
                    'tags'=>json_encode($value->tags??[])??null,
                    ]);
            }
            $found->save();
            $found->refresh();
        }
    }

}
