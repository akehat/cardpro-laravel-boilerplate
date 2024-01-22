<?php

namespace App\Models;

use App\Http\Controllers\API\payfacController;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class payoutProfile extends Model
{
    use HasFactory;
    protected $table ='finix_payout_profiles';
    protected $guarded=['id'];
    public static $name='payout_profiles';
    public static function updateFromId($id){
        self::fromArray([json_decode(payfacController::fetchPayoutProfile(config("app.api_username"),config("app.api_password"),$id)[0])]);
     }
    public static function runUpdate(){
        $result= payfacController::listPayoutProfiles(config("app.api_username"),config("app.api_password"));
        $object=json_decode($result[0]);
        while(isset($object->_embedded)&&isset($object->_embedded->payout_profiles)&&isset($object->page)&&isset($object->page->next_cursor)&&count($object->_embedded->payout_profiles)>0){
            self::fromArray($object->_embedded->payout_profiles);
         $nextArray=['after_cursor'=>$object->page->next_cursor];
         $result= payfacController::listPayoutProfiles(config("app.api_username"),config("app.api_password"),'https://finix.sandbox-payments-api.com',$nextArray);
         $object=json_decode($result[0]);
        }
     }
    public static function fromArray(array $array)
    {
        foreach ($array as $data) {
            $data = (object)$data;

            $found = self::where('finix_id', $data->id)->first();

            if ($found == null) {
                $found = self::create([
                    'finix_id' => $data->id ?? null,
                    'finix_created_at' => $data->created_at ?? null,
                    'finix_updated_at' => $data->updated_at ?? null,
                    'linked_id' => $data->linked_id ?? null,
                    'linked_type' => $data->linked_type ?? null,
                    'gross' => json_encode($data->gross??[]) ?? null,
                    'tags' => json_encode($data->tags??[]) ?? null,
                    'type' => $data->type ?? null,
                ]);
            } else {
                $found->update([
                    'finix_created_at' => $data->created_at ?? null,
                    'finix_updated_at' => $data->updated_at ?? null,
                    'linked_id' => $data->linked_id ?? null,
                    'linked_type' => $data->linked_type ?? null,
                    'gross' => json_encode($data->gross??[]) ?? null,
                    'tags' => json_encode($data->tags??[]) ?? null,
                    'type' => $data->type ?? null,
                ]);
            }

            // Save and refresh the model
            $found->save();
            $found->refresh();
        }
    }
}
