<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class identities extends Model
{
    use HasFactory;
    protected $table="identities";
    protected $guarded=['id'];
    public static function fromArray($array){
        foreach ($array as $value) {
            $value=(object)$value;
            $found=identities::where('finix_id',$value->id)->first();
            if($found==null){
               $found=identities::create([
                'application'=>$value->application??null,
                'entity'=>$value->entity??null,
                'identity_roles'=>$value->identity_roles??null,
                'tags'=>$value->tags??null,
                'finix_id'=>$value->id??null
                ]);
            }else{
                $found::update([
                    'application'=>$value->application??null,
                    'entity'=>$value->entity??null,
                    'identity_roles'=>$value->identity_roles??null,
                    'tags'=>$value->tags??null,
                    'finix_id'=>$value->id??null
                    ]);
            }
            $found->save();
            $found->refresh();
        }
    }
}
