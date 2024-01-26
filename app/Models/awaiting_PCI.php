<?php

namespace App\Models;

use App\Http\Controllers\API\formController;
use App\Http\Controllers\API\merchantsController;
use Error;
use Exception;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;

class awaiting_PCI extends Model
{
public function scopeAccessible($query)
    {
        // Check if the authenticated user is an admin
        if (Auth::check() && Auth::user()->isAdmin()) {
            return $query; // No additional condition needed for admins
        }

        // If not an admin, add the additional condition
        return $query->where('api_user', Auth::user()->apiuser()->select('api_users.id')->first()->id);
    }
    use HasFactory;
    protected $table='awaiting_pci';
    protected $guarded=['id'];

    public function checkReady(){
        try{
            pci_forms::runUpdate();
        }catch(Exception | Error $e){
            Log::info($e->getMessage());
        }
        return pci_forms::where('linked_to',$this->merchant_id)->first() !== null;
    }
    public function fillOutForm(){
        try{
            pci_forms::runUpdate();
        }catch(Exception | Error $e){
            Log::info($e->getMessage());
        }
        $form = pci_forms::where('linked_to',$this->merchant_id)->first();
        if($form!=null){
        $reponces=formController::completePCIForm(config("app.api_username"),config("app.api_password"),$form->id,$this->ip,$this->name,now()->toDateTimeString(),"CTO",$this->browser);
            if($reponces[1]>=200&&$reponces[1]<300){
                return true;
            }
        }
        return false;
    }
}
