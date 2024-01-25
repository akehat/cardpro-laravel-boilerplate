<?php

namespace App\Models;

use App\Http\Controllers\API\formController;
use Error;
use Exception;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Log;

class awaiting_PCI_live extends Model
{
    use HasFactory;
    protected $table='awaiting_pci_live';
    protected $guarded=['id'];
    // Schema::create('awaiting_pci_live', function (Blueprint $table) {
    //     $table->id();
    //     $table->timestamps();
    //     $table->string('ip')->nullable();
    //     $table->string('browser')->nullable();
    //     $table->string('name')->nullable();
    //     $table->string('merchant_id')->nullable();
    //     $table->boolean('user_id')->nullable();
    // });
    public function checkReady(){
        try{
            pci_forms::runUpdate();
        }catch(Exception | Error $e){
            Log::info($e->getMessage());
        }
        return pci_forms_live::where('linked_to',$this->merchant_id)->first() !== null;
    }
    public function fillOutForm(){
        try{
            pci_forms::runUpdate();
        }catch(Exception | Error $e){
            Log::info($e->getMessage());
        }
        $form = pci_forms_live::where('linked_to',$this->merchant_id)->first();
        if($form!=null){
            $reponces=formController::completePCIForm(config("app.api_username"),config("app.api_password"),$form->id,$this->ip,$this->name,now()->toDateTimeString(),"CTO",$this->browser,'https://finix.live-payments-api.com');
            if($reponces[1]>=200&&$reponces[1]<300){
                return true;
            }
        }
        return false;
    }
}
