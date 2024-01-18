<?php

namespace App\Models;

use App\Http\Controllers\API\merchantsController;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class identities extends Model
{
    use HasFactory;
    protected $table="identities";
    protected $guarded=['id'];
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
}
