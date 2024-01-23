<?php

namespace App\Models;

use App\Http\Controllers\API\payfacController;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Applications_live extends Model
{
    use HasFactory;
    protected $table = 'applications_live';
    protected $guarded = ['id'];
    public static $name='applications';
    public static function updateFromId_live($id){
       self::fromArray([json_decode(payfacController::fetchApplication(config("app.api_username"),config("app.api_password"),$id,'https://finix.live-payments-api.com')[0])]);
    }
    public static function runUpdate(){
        $result= payfacController::listApplications(config("app.api_username"),config("app.api_password"));
        $object=json_decode($result[0]);
        while(isset($object->_embedded)&&isset($object->_embedded->applications)&&isset($object->page)&&isset($object->page->next_cursor)&&count($object->_embedded->applications)>0){
            self::fromArray($object->_embedded->applications);
         $nextArray=['after_cursor'=>$object->page->next_cursor];
         $result= payfacController::listApplications(config("app.api_username"),config("app.api_password"),'https://finix.live-payments-api.com',$nextArray);
         $object=json_decode($result[0]);
        }
     }
    public static function fromArray($array){
        foreach ($array as $value) {
            $value=(object)$value;
            $found=self::where('finix_id',$value->id)->first();
            if($found==null){
                $found=self::create([
                    'finix_id'=>$value->id,
                    'card_cvv_required'=>$value->card_cvv_required??null,
                    'card_expiration_date_required'=>$value->card_expiration_date_required??null,
                    'name'=>$value->name??null,
                    'enabled'=>$value->enabled??null,
                    'processing_enabled'=>$value->processing_enabled??null,
                    'fee_ready_to_settle_upon'=>$value->fee_ready_to_settle_upon??null,
                    'ready_to_settle_upon'=>$value->ready_to_settle_upon??null,
                    'owner'=>$value->owner??null,
                    'settlement_enabled'=>$value->settlement_enabled??null,
                    'settlement_funding_identifier'=>$value->settlement_funding_identifier??null,
                    'creating_transfer_from_report_enabled'=>$value->creating_transfer_from_report_enabled??null,
                ]);

            }else{
                $found->update([
                    'finix_id'=>$value->id,
                    'card_cvv_required'=>$value->card_cvv_required??null,
                    'card_expiration_date_required'=>$value->card_expiration_date_required??null,
                    'name'=>$value->name??null,
                    'enabled'=>$value->enabled??null,
                    'processing_enabled'=>$value->processing_enabled??null,
                    'fee_ready_to_settle_upon'=>$value->fee_ready_to_settle_upon??null,
                    'ready_to_settle_upon'=>$value->ready_to_settle_upon??null,
                    'owner'=>$value->owner??null,
                    'settlement_enabled'=>$value->settlement_enabled??null,
                    'settlement_funding_identifier'=>$value->settlement_funding_identifier??null,
                    'creating_transfer_from_report_enabled'=>$value->creating_transfer_from_report_enabled??null,
                ]);
            }
            $found->save();
            $found->refresh();
        }
    }
}
