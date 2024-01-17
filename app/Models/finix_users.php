<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class finix_users extends Model
{
    use HasFactory;
    protected $table="finix_users";
    protected $guarded=['id'];
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
                $found::update([
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
