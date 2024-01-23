<?php

namespace App\Models;

use App\Http\Controllers\API\finixUsersController;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class finix_users_live extends Model
{
    use HasFactory;
    public static $name='users';
    public static function updateFromId_live($id){
       self::fromArray([json_decode(finixUsersController::fetchAUser(config("app.api_username"),config("app.api_password"),$id)[0])]);
    }
    protected $table="finix_users_live";
    protected $guarded=['id'];
    public static function runUpdate(){
        $result= finixUsersController::listAllUsers(config("app.api_username"),config("app.api_password"));
        $object=json_decode($result[0]);
        while(isset($object->_embedded)&&isset($object->_embedded->users)&&isset($object->page)&&isset($object->page->next_cursor)&&count($object->_embedded->users)>0){
            finix_users::fromArray($object->_embedded->users);
         $nextArray=['after_cursor'=>$object->page->next_cursor];
         $result= finixUsersController::listAllUsers(config("app.api_username"),config("app.api_password"),'https://finix.sandbox-payments-api.com',$nextArray);
         $object=json_decode($result[0]);
        }
     }
    public static function fromArray($array){
        foreach ($array as $value) {
            $value=(object)$value;
            $found=finix_users::where('finix_id',$value->id)->first();
            if($found==null){
                $found=finix_users::create([
                    'finix_id'=>$value->id,
                    'enabled'=>$value->enabled??null,
                    'identity'=>$value->identity??null,
                    'last_used_date'=>$value->last_used_date??null,
                    'password'=>$value->password??null,
                    'tags'=>json_encode($value->tags)??null,
                    'role'=>$value->role??null,
                ]);
            }else{
                $found->update([
                    'finix_id'=>$value->id,
                    'enabled'=>$value->enabled??null,
                    'identity'=>$value->identity??null,
                    'last_used_date'=>$value->last_used_date??null,
                    'password'=>$value->password??null,
                    'tags'=>json_encode($value->tags)??null,
                    'role'=>$value->role??null,
                ]);
            }
            $found->save();
            $found->refresh();
        }
    }
}
