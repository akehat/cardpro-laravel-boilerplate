<?php

namespace App\Models;

use App\Http\Controllers\API\finixUsersController;
use Error;
use Exception;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Log;

class awaiting_users_live extends Model
{
    use HasFactory;
    protected $table='awaiting_user_live';
    protected $guarded=['id'];
    // Schema::create('awaiting_user_live', function (Blueprint $table) {
    //     $table->id();
    //     $table->timestamps();
    //     $table->string('identity')->default(0)->nullable();
    //     $table->integer('user_id')->nullable();
    // });
    public function checkReady(){
        try{
            verifications_live::runUpdate();
        }catch(Exception | Error $e){
            Log::info($e->getMessage());
        }
        return verifications_live::where('identity',$this->identity)->first() !== null;
    }
    public function checkStatus(){
        try{
            verifications_live::runUpdate();
        }catch(Exception | Error $e){
            Log::info($e->getMessage());
        }
        $verifications=verifications_live::where('identity',$this->identity)->first();
        if($verifications==null){
            return null;
        }
        else{
            return $verifications->state;
        }
    }
    public function completeSignup(){
        $user=finixUsersController::createAMerchantUser($this->identity,'https://finix.live-payments-api.com');
        if($user[1]>=200&&$user[1]<300){
            $value=json_decode($user[0]);
            $userApi=ApiUser::where('user_id',$this->user_id)->first();
            $userApi->update([
                "username_live"=>$value->id,
                "password_live"=>$value->password
            ]);
            $userApi->save();
            $userApi->refresh();
            $userRef=$userApi->user();
            $userRef->update([
                'hasId_live'=>true
            ]);
            $userRef->save();
            $userRef->refresh();
            return true;
        }else{
            return $user[0];
        }

    }
}
