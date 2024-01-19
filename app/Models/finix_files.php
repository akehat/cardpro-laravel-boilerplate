<?php

namespace App\Models;

use App\Http\Controllers\API\fileController;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class finix_files extends Model
{
    use HasFactory;
    protected $table="finix_files";
    protected $guarded=['id'];
    public static function runUpdate(){
        $result= fileController::listAllFiles(config("app.api_username"),config("app.api_password"));
        $object=json_decode($result[0]);
        while(isset($object->_embedded)&&isset($object->_embedded->files)&&isset($object->page)&&isset($object->page->next_cursor)&&count($object->_embedded->files)>0){
            self::fromArray($object->_embedded->files);
         $nextArray=['after_cursor'=>$object->page->next_cursor];
         $result= fileController::listAllFiles(config("app.api_username"),config("app.api_password"),'https://finix.sandbox-payments-api.com',$nextArray);
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
                    'file_id' => $data->file_id ?? null,
                    'display_name' => $data->display_name ?? null,
                    'linked_to' => $data->linked_to ?? null,
                    'linked_type' => $data->linked_type ?? null,
                    'platform_id' => $data->platform_id ?? null,
                    'status' => $data->status ?? null,
                    'tags' => $data->tags ?? null,
                    'type' => $data->type ?? null,
                    'api_key' => $data->api_key ?? null,
                    'is_live' => $data->is_live ?? null,
                    'api_user' => $data->api_user ?? null,
                ]);
            } else {
                $found->update([
                    'finix_id' => $data->id ?? null,
                    'file_id' => $data->file_id ?? null,
                    'display_name' => $data->display_name ?? null,
                    'linked_to' => $data->linked_to ?? null,
                    'linked_type' => $data->linked_type ?? null,
                    'platform_id' => $data->platform_id ?? null,
                    'status' => $data->status ?? null,
                    'tags' => $data->tags ?? null,
                    'type' => $data->type ?? null,
                    'api_key' => $data->api_key ?? null,
                    'is_live' => $data->is_live ?? null,
                    'api_user' => $data->api_user ?? null,
                ]);
            }

            // Save and refresh the model
            $found->save();
            $found->refresh();
            finix_external_links::runUpdateWithID($found->finix_id);
        }
    }
}
