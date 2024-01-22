<?php

namespace App\Models;

use App\Http\Controllers\API\fileController;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class finix_external_links extends Model
{
    use HasFactory;
    protected $table="finix_external_links";
    protected $guarded=['id'];
    public static $name='external_links';
    public static function updateFromIds($file_id,$id){
       self::fromArray([json_decode(fileController::fetchExternalFile(config("app.api_username"),config("app.api_password"),$file_id,$id)[0])]);
    }
    public static function runUpdateWithID($id){
        $result= fileController::listAllexternalLinks(config("app.api_username"),config("app.api_password"),$id);
        $object=json_decode($result[0]);
        while(isset($object->_embedded)&&isset($object->_embedded->external_links)&&isset($object->page)&&isset($object->page->next_cursor)&&count($object->_embedded->external_links)>0){
            self::fromArray($object->_embedded->external_links);
         $nextArray=['after_cursor'=>$object->page->next_cursor];
         $result= fileController::listAllexternalLinks(config("app.api_username"),config("app.api_password"),$id,'https://finix.sandbox-payments-api.com',$nextArray);
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
                'link_id' => $data->id ?? null, // assuming 'id' is the link_id
                'expires_at' => $data->expires_at ?? null,
                'file_id' => $data->file_id ?? null,
                'type' => $data->type ?? null,
                'url' => $data->url ?? null,
                'user_id' => $data->user_id ?? null,
            ]);
        } else {
            $found->update([
                'finix_id' => $data->id ?? null,
                'link_id' => $data->id ?? null, // assuming 'id' is the link_id
                'expires_at' => $data->expires_at ?? null,
                'file_id' => $data->file_id ?? null,
                'type' => $data->type ?? null,
                'url' => $data->url ?? null,
                'user_id' => $data->user_id ?? null,
            ]);
        }

        // Save and refresh the model
        $found->save();
        $found->refresh();
    }
}
}
