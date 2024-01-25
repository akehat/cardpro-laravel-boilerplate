<?php

namespace App\Models;

use App\Http\Controllers\API\finixUsersController;
use App\Http\Controllers\API\merchantsController;
use Error;
use Exception;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Log;

class awaiting_users extends Model
{
    use HasFactory;
    protected $table='awaiting_user';
    protected $guarded=['id'];
    public function checkReady(){
        try{
            verifications::runUpdate();
        }catch(Exception | Error $e){
            Log::info($e->getMessage());
        }
        return verifications::where('identity',$this->identity)->first() !== null;
    }
    public function checkStatus(){
        try{
            verifications::runUpdate();
        }catch(Exception | Error $e){
            Log::info($e->getMessage());
        }
        $verifications=verifications::where('identity',$this->identity)->first();
        if($verifications==null){
            return null;
        }
        else{
            return $verifications->state;
        }
    }
    public function completeSignup(){
        $user=finixUsersController::createAMerchantUser($this->identity);
        if($user[1]>=200&&$user[1]<300){
            $value=json_decode($user[0]);
            $userApi=ApiUser::where('user_id',$this->user_id)->first();
            $userApi->update([
                "username"=>$value->id,
                "password"=>$value->password
            ]);
            $userApi->save();
            $userApi->refresh();
            $userRef=$userApi->user();
            $userRef->update([
                'hasId'=>true
            ]);
            $userRef->save();
            $userRef->refresh();
            return true;
        }else{
            return $user[0];
        }

    }

    // Schema::create('awaiting_user', function (Blueprint $table) {
    //     $table->id();
    //     $table->timestamps();
    //     $table->string('identity')->default(0)->nullable();
    //     $table->integer('user_id')->nullable();
    // });

}
