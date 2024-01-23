<?php

namespace App\Models;

use App\Http\Controllers\API\payfacController;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ApplicationProfiles_live extends Model
{
    use HasFactory;
    protected $table='finix_application_profiles_live';
    protected $guarded=['id'];
    public static $name='application_profiles';
    public static function updateFromId_live($id){
       self::fromArray([json_decode(payfacController::fetchApplicationProfile(config("app.api_username"),config("app.api_password"),$id,'https://finix.live-payments-api.com')[0])]);
    }
    public static function runUpdate(){
        $result= payfacController::listApplicationProfiles(config("app.api_username"),config("app.api_password"));
        $object=json_decode($result[0]);
        while(isset($object->_embedded)&&isset($object->_embedded->application_profiles)&&isset($object->page)&&isset($object->page->next_cursor)&&count($object->_embedded->application_profiles)>0){
            self::fromArray($object->_embedded->application_profiles);
         $nextArray=['after_cursor'=>$object->page->next_cursor];
         $result= payfacController::listApplicationProfiles(config("app.api_username"),config("app.api_password"),'https://finix.live-payments-api.com',$nextArray);
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
                    'application' => $data->application ?? null,
                    'fee_profile' => $data->fee_profile ?? null,
                    'risk_profile' => $data->risk_profile ?? null,
                    'tags' => json_encode($data->tags) ?? null,
                ]);
            } else {
                $found->update([
                    'finix_id' => $data->id ?? null,
                    'finix_created_at' => $data->created_at ?? null,
                    'finix_updated_at' => $data->updated_at ?? null,
                    'application' => $data->application ?? null,
                    'fee_profile' => $data->fee_profile ?? null,
                    'risk_profile' => $data->risk_profile ?? null,
                    'tags' => json_encode($data->tags) ?? null,
                ]);
            }

            // Save and refresh the model
            $found->save();
            $found->refresh();
        }
    }
}
